<?php

require_once("/var/www/mileage/php/models/Fillup.php");

class FillupRepository
{
    private $db;
    private $vehicle_id;

    private $records = [];
    private $loaded = false;

    public $actionDataMessage;

    public function __construct(DatabaseV2 $db, $vehicle_id)
    {
        $this->db = $db;
        $this->vehicle_id = $vehicle_id;
    }

    public function getRecordById($id)
    {
        if (!array_key_exists($id, $this->records)) {
            $sql = "
                SELECT a.`id`, a.`created`, a.`updated`, a.`date`, a.`odometer`, a.`gallon`, a.`ppg`, a.`station`, a.`partial`, a.`missed`, a.`mpg`, IFNULL(a.`days`,'NULL') AS `days`, a.`miles`
                FROM fillup a
                WHERE a.`vehicle_id` = ?
                    AND a.`id` = ?
            ";

            $result = $this->db->query($sql, [
                $this->vehicle_id,
                $id
            ], "ii");

            if ($result) {
                $rec = Fillup::fromDatabase($result->fetch_array(MYSQLI_ASSOC));
                $this->records[$id] = $rec;
            } else {
                $this->records[$id] = null;
            }
        }
        return $this->records[$id];
    }

    public function getRecords()
    {
        if ($this->loaded) {
            $recs = [];
            foreach ($this->records as $key => $rec) {
                if ($rec->id() > 0)
                    $recs[$key] = $rec;
            }
            return $recs;
        }

        $sql = "
            SELECT a.`id`, a.`created`, a.`updated`, a.`date`, a.`odometer`, a.`gallon`, a.`ppg`, a.`station`, a.`partial`, a.`missed`, a.`mpg`, IFNULL(a.`days`,'NULL') AS `days`, a.`miles`
            FROM fillup a
            WHERE a.`vehicle_id` = ?
            ORDER BY a.`date` DESC, a.`odometer` DESC
        ";

        $result = $this->db->query($sql, [
            $this->vehicle_id
        ], "i");

        $this->loaded = true;
        $this->records = [];
        foreach ($result->fetch_all(MYSQLI_ASSOC) as $rec) {
            $this->records[$rec['id']] = Fillup::fromDatabase($rec);
        }
        return $this->records;
    }

    public function insertRecord(Fillup $rec)
    {
        $this->actionDataMessage = "Failed to insert Fillup";

        if (empty($rec->date()) || !is_int($rec->odometer()) || !is_float($rec->gallon()) || !is_float($rec->ppg())) {
            $this->actionDataMessage = "Missing required fields to insert Fillup";
            return 0;
        }

        $this->db->beginTransaction();

        $sql = "
            INSERT INTO fillup (`vehicle_id`,`date`,`odometer`,`gallon`,`ppg`,`station`,`partial`,`missed`)
            VALUES (?,?,?,?,?,?,?,?)
        ";

        $result = $this->db->query($sql, [
            $this->vehicle_id,
            $rec->date(),
            $rec->odometer(),
            $rec->gallon(),
            $rec->ppg(),
            $rec->station(),
            (int)$rec->partial(),
            (int)$rec->missed()
        ], "isiddsii");

        if (is_int($result) && $result > 0) {
            $this->actionDataMessage = "Fillup Inserted";
            $this->db->commit();
            $this->loaded = false;
            $this->calculateStats();
            return $result;
        }
        $this->db->rollback();
        return 0;
    }

    public function updateRecord(Fillup $rec)
    {
        $this->actionDataMessage = "Failed to update Fillup";

        if (empty($rec->date()) || !is_int($rec->odometer()) || !is_float($rec->gallon()) || !is_float($rec->ppg())) {
            $this->actionDataMessage = "Missing required fields to update Fillup";
            return 0;
        }

        $this->db->beginTransaction();

        $sql = "
            UPDATE fillup
            SET `date` = ?,
                `odometer` = ?,
                `gallon` = ?,
                `ppg` = ?,
                `station` = ?,
                `partial` = ?,
                `missed` = ? 
            WHERE `id` = ? 
            AND `vehicle_id` = ?
        ";

        $result = $this->db->query($sql, [
            $rec->date(),
            $rec->odometer(),
            $rec->gallon(),
            $rec->ppg(),
            $rec->station(),
            (int)$rec->partial(),
            (int)$rec->missed(),
            $rec->id(),
            $this->vehicle_id
        ], "siddsiiii");

        if ($result !== false) {
            if ($result !== 1) {
                $this->actionDataMessage = "Fillup Unchanged";
                return 2;
            }
            $this->actionDataMessage = "Fillup Updated";
            $this->db->commit();
            $this->loaded = false;
            $this->calculateStats();
            return 1;
        }

        $this->db->rollback();
        return false;
    }

    public function updateRecordStats(Fillup $rec)
    {
        // $this->actionDataMessage = "Failed to update Fillup Stats";

        $this->db->beginTransaction();

        $sql = "
            UPDATE fillup
            SET `mpg` = ?,
                `days` = ?,
                `miles` = ? 
            WHERE `id` = ? 
            AND `vehicle_id` = ?
        ";

        $result = $this->db->query($sql, [
            $rec->mpg(),
            $rec->days(),
            $rec->miles(),
            $rec->id(),
            $this->vehicle_id
        ], "diiii");

        if ($result !== false) {
            if ($result !== 1) {
                // $this->actionDataMessage = "Fillup Stats Unchanged";
                return 2;
            }
            // $this->actionDataMessage = "Fillup Stats Updated";
            $this->db->commit();
            return 1;
        }

        $this->db->rollback();
        return false;
    }

    public function deleteRecord(Fillup $rec)
    {
        $this->actionDataMessage = "Failed to delete Fillup";

        $this->db->beginTransaction();

        $sql = "
            DELETE FROM fillup 
            WHERE `id` = ? 
            AND `vehicle_id` = ?
        ";

        $result = $this->db->query($sql, [
            $rec->id(),
            $this->vehicle_id
        ], "ii");

        if (is_int($result) && $result > 0) {
            $this->actionDataMessage = "Fillup Deleted";
            $this->db->commit();
            $this->loaded = false;
            $this->calculateStats();
            return 1;
        }
        $this->db->rollback();
        return 0;
    }

    //

    public function calculateStats()
    {
        $fillups = $this->getRecords();

        usort($fillups, function ($a, $b) {
            return $a->odometer() > $b->odometer();
        });

        // MPG

        $startOdom = null;
        $totalGallon = 0;

        foreach ($fillups as $fillup) {
            if (is_null($startOdom)) {
                $startOdom = $fillup->odometer();
                $totalGallon = 0;
                $fillup->set_mpg(null);
                continue;
            }
            if ($fillup->missed()) {
                $startOdom = $fillup->odometer();
                $totalGallon = 0;
                $fillup->set_mpg(null);
                continue;
            }

            $totalGallon += $fillup->gallon();
            if ($fillup->partial()) {
                $fillup->set_mpg(null);
                continue;
            }

            $fillup->set_mpg(($fillup->odometer() - $startOdom) / $totalGallon);
            $totalGallon = 0;
            $startOdom = $fillup->odometer();
        }

        // DAYS and MILES

        $startDate = null;
        $startOdom = null;

        foreach ($fillups as $fillup) {
            if (is_null($startDate) || $fillup->missed()) {
                $startDate = $fillup->date();
                $startOdom = $fillup->odometer();
                continue;
            }

            $d1 = new DateTime($startDate);
            $d2 = new DateTime($fillup->date());
            $interval = $d1->diff($d2);

            $day = $interval->format('%a');
            $fillup->set_days($day);
            $startDate = $fillup->date();

            $mile = $fillup->odometer() - $startOdom;
            $fillup->set_miles($mile);
            $startOdom = $fillup->odometer();
        }

        foreach ($fillups as $fillup) {
            $this->updateRecordStats($fillup);
        }
    }
}
