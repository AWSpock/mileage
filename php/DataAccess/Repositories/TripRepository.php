<?php

require_once("/var/www/mileage/php/models/Trip.php");

class TripRepository
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
                SELECT a.`id`, a.`created`, a.`updated`, a.`name`, a.`description`, 
                    MIN(b.`odometer`) AS start_odometer, MIN(b.`date`) AS start_date, 
                    MAX(b.`odometer`) AS end_odometer, MAX(b.`date`) AS end_date,
                    MAX(b.`odometer`) - MIN(b.`odometer`) AS miles, DATEDIFF(MAX(b.`date`), MIN(b.`date`)) + 1 AS days
                FROM trip a
                    LEFT OUTER JOIN trip_checkpoint b ON b.trip_id = a.id
                WHERE a.`vehicle_id` = ?
                    AND a.`id` = ?
                GROUP BY a.`id`, a.`created`, a.`updated`, a.`name`, a.`description`
            ";

            $result = $this->db->query($sql, [
                $this->vehicle_id,
                $id
            ], "ii");

            if ($result) {
                $rec = Trip::fromDatabase($result->fetch_array(MYSQLI_ASSOC));
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
            SELECT a.`id`, a.`created`, a.`updated`, a.`name`, a.`description`, 
                MIN(b.`odometer`) AS start_odometer, MIN(b.`date`) AS start_date, 
                MAX(b.`odometer`) AS end_odometer, MAX(b.`date`) AS end_date,
                MAX(b.`odometer`) - MIN(b.`odometer`) AS miles, DATEDIFF(MAX(b.`date`), MIN(b.`date`)) + 1 AS days
            FROM trip a
	            LEFT OUTER JOIN trip_checkpoint b ON b.trip_id = a.id
            WHERE a.`vehicle_id` = ?
            GROUP BY a.`id`, a.`created`, a.`updated`, a.`name`, a.`description`
            ORDER BY start_date DESC, start_odometer DESC
        ";

        $result = $this->db->query($sql, [
            $this->vehicle_id
        ], "i");

        $this->loaded = true;
        $this->records = [];
        foreach ($result->fetch_all(MYSQLI_ASSOC) as $rec) {
            $this->records[$rec['id']] = Trip::fromDatabase($rec);
        }
        return $this->records;
    }

    public function insertRecord(Trip $rec)
    {
        $this->actionDataMessage = "Failed to insert Trip";

        if (empty($rec->name()) || empty($rec->description())) {
            $this->actionDataMessage = "Missing required fields to insert Trip";
            return 0;
        }

        $this->db->beginTransaction();

        $sql = "
            INSERT INTO trip (`vehicle_id`,`name`,`description`)
            VALUES (?,?,?)
        ";

        $result = $this->db->query($sql, [
            $this->vehicle_id,
            $rec->name(),
            $rec->description()
        ], "iss");

        if (is_int($result) && $result > 0) {
            $this->actionDataMessage = "Trip Inserted";
            $this->db->commit();
            return $result;
        }
        $this->db->rollback();
        return 0;
    }

    public function updateRecord(Trip $rec)
    {
        $this->actionDataMessage = "Failed to update Trip";

        if (empty($rec->name()) || empty($rec->description())) {
            $this->actionDataMessage = "Missing required fields to update Trip";
            return 0;
        }

        $this->db->beginTransaction();

        $sql = "
            UPDATE trip
            SET `name` = ?,
                `description` = ?
            WHERE `id` = ? 
            AND `vehicle_id` = ?
        ";

        $result = $this->db->query($sql, [
            $rec->name(),
            $rec->description(),
            $rec->id(),
            $this->vehicle_id
        ], "ssii");

        if ($result !== false) {
            if ($result !== 1) {
                $this->actionDataMessage = "Trip Unchanged";
                return 2;
            }
            $this->actionDataMessage = "Trip Updated";
            $this->db->commit();
            return 1;
        }

        $this->db->rollback();
        return false;
    }

    public function deleteRecord(Trip $rec)
    {
        $this->actionDataMessage = "Failed to delete Trip";

        $this->db->beginTransaction();

        $sql = "
            DELETE FROM trip 
            WHERE `id` = ? 
            AND `vehicle_id` = ?
        ";

        $result = $this->db->query($sql, [
            $rec->id(),
            $this->vehicle_id
        ], "ii");

        if (is_int($result) && $result > 0) {
            $this->actionDataMessage = "Trip Deleted";
            $this->db->commit();
            return 1;
        }
        $this->db->rollback();
        return 0;
    }
}
