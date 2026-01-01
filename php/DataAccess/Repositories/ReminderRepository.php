<?php

require_once("/var/www/mileage/php/models/Reminder.php");

class ReminderRepository
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
                SELECT a.`id`, a.`created`, a.`updated`, a.`name`, a.`description`, a.`due_months`, a.`due_miles`, a.`due_date`, a.`due_odometer`
                FROM reminder a
                WHERE a.`vehicle_id` = ?
                    AND a.`id` = ?
            ";

            $result = $this->db->query($sql, [
                $this->vehicle_id,
                $id
            ], "ii");

            if ($result) {
                $rec = Reminder::fromDatabase($result->fetch_array(MYSQLI_ASSOC));
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
            SELECT a.`id`, a.`created`, a.`updated`, a.`name`, a.`description`, a.`due_months`, a.`due_miles`, a.`due_date`, a.`due_odometer`
            FROM reminder a
            WHERE a.`vehicle_id` = ?
            ORDER BY a.`name`, a.`description`
        ";

        $result = $this->db->query($sql, [
            $this->vehicle_id
        ], "i");

        $this->loaded = true;
        $this->records = [];
        foreach ($result->fetch_all(MYSQLI_ASSOC) as $rec) {
            $this->records[$rec['id']] = Reminder::fromDatabase($rec);
        }
        return $this->records;
    }

    public function insertRecord(Reminder $rec)
    {
        $this->actionDataMessage = "Failed to insert Reminder";

        if (empty($rec->name()) || empty($rec->description())) {
            $this->actionDataMessage = "Missing required fields to insert Reminder";
            return 0;
        }

        $this->db->beginTransaction();

        $sql = "
            INSERT INTO reminder (`vehicle_id`,`name`,`description`,`due_months`,`due_miles`,`due_date`,`due_odometer`)
            VALUES (?,?,?,?,?,?,?)
        ";

        $result = $this->db->query($sql, [
            $this->vehicle_id,
            $rec->name(),
            $rec->description(),
            $rec->due_months(),
            $rec->due_miles(),
            $rec->due_date() !== "" ? $rec->due_date() : NULL,
            $rec->due_odometer()
        ], "issiisi");

        if (is_int($result) && $result > 0) {
            $this->actionDataMessage = "Reminder Inserted";
            $this->db->commit();
            return $result;
        }
        $this->db->rollback();
        return 0;
    }

    public function updateRecord(Reminder $rec)
    {
        $this->actionDataMessage = "Failed to update Reminder";

        if (empty($rec->name()) || empty($rec->description())) {
            $this->actionDataMessage = "Missing required fields to update Reminder";
            return 0;
        }

        $this->db->beginTransaction();

        $sql = "
            UPDATE reminder
            SET `name` = ?,
                `description` = ?,
                `due_months` = ?,
                `due_miles` = ?,
                `due_date` = ?,
                `due_odometer` = ?
            WHERE `id` = ? 
            AND `vehicle_id` = ?
        ";

        $result = $this->db->query($sql, [
            $rec->name(),
            $rec->description(),
            $rec->due_months(),
            $rec->due_miles(),
            $rec->due_date() !== "" ? $rec->due_date() : NULL,
            $rec->due_odometer(),
            $rec->id(),
            $this->vehicle_id
        ], "ssiisiii");

        if ($result !== false) {
            if ($result !== 1) {
                $this->actionDataMessage = "Reminder Unchanged";
                return 2;
            }
            $this->actionDataMessage = "Reminder Updated";
            $this->db->commit();
            return 1;
        }

        $this->db->rollback();
        return false;
    }

    public function deleteRecord(Reminder $rec)
    {
        $this->actionDataMessage = "Failed to delete Reminder";

        $this->db->beginTransaction();

        $sql = "
            DELETE FROM reminder 
            WHERE `id` = ? 
            AND `vehicle_id` = ?
        ";

        $result = $this->db->query($sql, [
            $rec->id(),
            $this->vehicle_id
        ], "ii");

        if (is_int($result) && $result > 0) {
            $this->actionDataMessage = "Reminder Deleted";
            $this->db->commit();
            return 1;
        }
        $this->db->rollback();
        return 0;
    }
}
