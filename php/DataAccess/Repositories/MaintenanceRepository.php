<?php

require_once("/var/www/mileage/php/models/Maintenance.php");

class MaintenanceRepository
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
                SELECT a.`id`, a.`created`, a.`updated`, a.`date`, a.`odometer`, a.`price`, a.`description`, a.`garage`
                FROM maintenance a
                WHERE a.`vehicle_id` = ?
                    AND a.`id` = ?
            ";

            $result = $this->db->query($sql, [
                $this->vehicle_id,
                $id
            ], "ii");

            if ($result) {
                $rec = Maintenance::fromDatabase($result->fetch_array(MYSQLI_ASSOC));
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
            SELECT a.`id`, a.`created`, a.`updated`, a.`date`, a.`odometer`, a.`price`, a.`description`, a.`garage`
            FROM maintenance a
            WHERE a.`vehicle_id` = ?
            ORDER BY a.`date` DESC, a.`odometer` DESC
        ";

        $result = $this->db->query($sql, [
            $this->vehicle_id
        ], "i");

        $this->loaded = true;
        $this->records = [];
        foreach ($result->fetch_all(MYSQLI_ASSOC) as $rec) {
            $this->records[$rec['id']] = Maintenance::fromDatabase($rec);
        }
        return $this->records;
    }

    public function insertRecord(Maintenance $rec)
    {
        $this->actionDataMessage = "Failed to insert Maintenance";

        if (empty($rec->date()) || !is_int($rec->odometer()) || !is_float($rec->price()) || empty($rec->description())) {
            $this->actionDataMessage = "Missing required fields to insert Maintenance";
            return 0;
        }

        $this->db->beginTransaction();

        $sql = "
            INSERT INTO maintenance (`vehicle_id`,`date`,`odometer`,`price`,`description`,`garage`)
            VALUES (?,?,?,?,?,?)
        ";

        $result = $this->db->query($sql, [
            $this->vehicle_id,
            $rec->date(),
            $rec->odometer(),
            $rec->price(),
            $rec->description(),
            $rec->garage()
        ], "isidss");

        if (is_int($result) && $result > 0) {
            $this->actionDataMessage = "Maintenance Inserted";
            $this->db->commit();
            return $result;
        }
        $this->db->rollback();
        return 0;
    }

    public function updateRecord(Maintenance $rec)
    {
        $this->actionDataMessage = "Failed to update Maintenance";

        if (empty($rec->date()) || !is_int($rec->odometer()) || !is_float($rec->price()) || empty($rec->description())) {
            $this->actionDataMessage = "Missing required fields to update Maintenance";
            return 0;
        }

        $this->db->beginTransaction();

        $sql = "
            UPDATE maintenance
            SET `date` = ?,
                `odometer` = ?,
                `price` = ?,
                `description` = ?,
                `garage` = ? 
            WHERE `id` = ? 
            AND `vehicle_id` = ?
        ";

        $result = $this->db->query($sql, [
            $rec->date(),
            $rec->odometer(),
            $rec->price(),
            $rec->description(),
            $rec->garage(),
            $rec->id(),
            $this->vehicle_id
        ], "sidssii");

        if ($result !== false) {
            if ($result !== 1) {
                $this->actionDataMessage = "Maintenance Unchanged";
                return 2;
            }
            $this->actionDataMessage = "Maintenance Updated";
            $this->db->commit();
            return 1;
        }

        $this->db->rollback();
        return false;
    }

    public function deleteRecord(Maintenance $rec)
    {
        $this->actionDataMessage = "Failed to delete Maintenance";

        $this->db->beginTransaction();

        $sql = "
            DELETE FROM maintenance 
            WHERE `id` = ? 
            AND `vehicle_id` = ?
        ";

        $result = $this->db->query($sql, [
            $rec->id(),
            $this->vehicle_id
        ], "ii");

        if (is_int($result) && $result > 0) {
            $this->actionDataMessage = "Maintenance Deleted";
            $this->db->commit();
            return 1;
        }
        $this->db->rollback();
        return 0;
    }
}
