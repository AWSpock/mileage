<?php

require_once("/var/www/mileage/php/models/TripCheckpoint.php");

class TripCheckpointRepository
{
    private $db;
    private $trip_id;

    private $records = [];
    private $loaded = false;

    public $actionDataMessage;

    public function __construct(DatabaseV2 $db, $trip_id)
    {
        $this->db = $db;
        $this->trip_id = $trip_id;
    }

    public function getRecordById($id)
    {
        if (!array_key_exists($id, $this->records)) {
            $sql = "
                SELECT a.`id`, a.`created`, a.`updated`, a.`date`, a.`odometer`, a.`description`
                FROM trip_checkpoint a
                WHERE a.`trip_id` = ?
                    AND a.`id` = ?
            ";

            $result = $this->db->query($sql, [
                $this->trip_id,
                $id
            ], "ii");

            if ($result) {
                $rec = TripCheckpoint::fromDatabase($result->fetch_array(MYSQLI_ASSOC));
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
            SELECT a.`id`, a.`created`, a.`updated`, a.`date`, a.`odometer`, a.`description`
            FROM trip_checkpoint a
            WHERE a.`trip_id` = ?
            ORDER BY a.`date` DESC, a.`odometer` DESC
        ";

        $result = $this->db->query($sql, [
            $this->trip_id
        ], "i");

        $this->loaded = true;
        $this->records = [];
        foreach ($result->fetch_all(MYSQLI_ASSOC) as $rec) {
            $this->records[$rec['id']] = TripCheckpoint::fromDatabase($rec);
        }
        return $this->records;
    }

    public function insertRecord(TripCheckpoint $rec)
    {
        $this->actionDataMessage = "Failed to insert Trip Checkpoint";

        if (empty($rec->date()) || !is_int($rec->odometer()) || empty($rec->description())) {
            $this->actionDataMessage = "Missing required fields to insert Trip Checkpoint";
            return 0;
        }

        $this->db->beginTransaction();

        $sql = "
            INSERT INTO trip_checkpoint (`trip_id`,`date`,`odometer`,`description`)
            VALUES (?,?,?,?)
        ";

        $result = $this->db->query($sql, [
            $this->trip_id,
            $rec->date(),
            $rec->odometer(),
            $rec->description()
        ], "isis");

        if (is_int($result) && $result > 0) {
            $this->actionDataMessage = "Trip Checkpoint Inserted";
            $this->db->commit();
            return $result;
        }
        $this->db->rollback();
        return 0;
    }

    public function updateRecord(TripCheckpoint $rec)
    {
        $this->actionDataMessage = "Failed to update Trip Checkpoint";

        if (empty($rec->date()) || !is_int($rec->odometer()) || empty($rec->description())) {
            $this->actionDataMessage = "Missing required fields to update Trip Checkpoint";
            return 0;
        }

        $this->db->beginTransaction();

        $sql = "
            UPDATE trip_checkpoint
            SET `date` = ?,
                `odometer` = ?,
                `description` = ? 
            WHERE `id` = ? 
            AND `trip_id` = ?
        ";

        $result = $this->db->query($sql, [
            $rec->date(),
            $rec->odometer(),
            $rec->description(),
            $rec->id(),
            $this->trip_id
        ], "sisii");

        if ($result !== false) {
            if ($result !== 1) {
                $this->actionDataMessage = "Trip Checkpoint Unchanged";
                return 2;
            }
            $this->actionDataMessage = "Trip Checkpoint Updated";
            $this->db->commit();
            return 1;
        }

        $this->db->rollback();
        return false;
    }

    public function deleteRecord(TripCheckpoint $rec)
    {
        $this->actionDataMessage = "Failed to delete Trip Checkpoint";

        $this->db->beginTransaction();

        $sql = "
            DELETE FROM trip_checkpoint 
            WHERE `id` = ? 
            AND `trip_id` = ?
        ";

        $result = $this->db->query($sql, [
            $rec->id(),
            $this->trip_id
        ], "ii");

        if (is_int($result) && $result > 0) {
            $this->actionDataMessage = "Trip Checkpoint Deleted";
            $this->db->commit();
            return 1;
        }
        $this->db->rollback();
        return 0;
    }
}
