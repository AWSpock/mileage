<?php

require_once("/var/www/mileage/php/models/TripTag.php");

class TripTagRepository
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
                SELECT a.`id`, a.`created`, a.`tag`
                FROM trip_tag a
                WHERE a.`trip_id` = ?
                    AND a.`id` = ?
            ";

            $result = $this->db->query($sql, [
                $this->trip_id,
                $id
            ], "ii");

            if ($result) {
                $rec = TripTag::fromDatabase($result->fetch_array(MYSQLI_ASSOC));
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
            SELECT a.`id`, a.`created`, a.`tag`
            FROM trip_tag a
            WHERE a.`trip_id` = ?
            ORDER BY a.`tag`
        ";

        $result = $this->db->query($sql, [
            $this->trip_id
        ], "i");

        $this->loaded = true;
        $this->records = [];
        foreach ($result->fetch_all(MYSQLI_ASSOC) as $rec) {
            $this->records[$rec['id']] = TripTag::fromDatabase($rec);
        }
        return $this->records;
    }

    public function insertRecord(TripTag $rec)
    {
        $this->actionDataMessage = "Failed to insert Trip Tag";

        if (empty($rec->tag())) {
            $this->actionDataMessage = "Missing required fields to insert Trip Tag";
            return 0;
        }

        $this->db->beginTransaction();

        $sql = "
            INSERT INTO trip_tag (`trip_id`,`tag`)
            VALUES (?,?)
        ";

        $result = $this->db->query($sql, [
            $this->trip_id,
            $rec->tag()
        ], "is");

        if (is_int($result) && $result > 0) {
            $this->actionDataMessage = "Trip Tag Inserted";
            $this->db->commit();
            return $result;
        }
        $this->db->rollback();
        return 0;
    }

    // public function updateRecord(TripTag $rec)
    // {
    //     $this->actionDataMessage = "Failed to update Trip Tag";

    //     if (empty($rec->tag())) {
    //         $this->actionDataMessage = "Missing required fields to update Trip Tag";
    //         return 0;
    //     }

    //     $this->db->beginTransaction();

    //     $sql = "
    //         UPDATE trip_tag
    //         SET `tag` = ? 
    //         WHERE `id` = ? 
    //         AND `trip_id` = ?
    //     ";

    //     $result = $this->db->query($sql, [
    //         $rec->tag(),
    //         $rec->id(),
    //         $this->trip_id
    //     ], "sii");

    //     if ($result !== false) {
    //         if ($result !== 1) {
    //             $this->actionDataMessage = "Trip Tag Unchanged";
    //             return 2;
    //         }
    //         $this->actionDataMessage = "Trip Tag Updated";
    //         $this->db->commit();
    //         return 1;
    //     }

    //     $this->db->rollback();
    //     return false;
    // }

    public function deleteRecord(TripTag $rec)
    {
        $this->actionDataMessage = "Failed to delete Trip Tag";

        $this->db->beginTransaction();

        $sql = "
            DELETE FROM trip_tag 
            WHERE `id` = ? 
            AND `trip_id` = ?
        ";

        $result = $this->db->query($sql, [
            $rec->id(),
            $this->trip_id
        ], "ii");

        if (is_int($result) && $result > 0) {
            $this->actionDataMessage = "Trip Tag Deleted";
            $this->db->commit();
            return 1;
        }
        $this->db->rollback();
        return 0;
    }
}
