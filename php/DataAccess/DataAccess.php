<?php
require_once("/var/www/mileage/php/DataAccess/Database.php");
require_once("/var/www/mileage/php/DataAccess/Repositories/VehicleRepository.php");
require_once("/var/www/mileage/php/DataAccess/Repositories/FillupRepository.php");
require_once("/var/www/mileage/php/DataAccess/Repositories/MaintenanceRepository.php");
require_once("/var/www/mileage/php/DataAccess/Repositories/ReminderRepository.php");
require_once("/var/www/mileage/php/DataAccess/Repositories/TripRepository.php");
require_once("/var/www/mileage/php/DataAccess/Repositories/TripCheckpointRepository.php");

class DataAccess
{
    private $db;
    private $vehicleRepository = [];
    private $fillupRepository = [];
    private $maintenanceRepository = [];
    private $reminderRepository = [];
    private $tripRepository = [];
    private $tripCheckpointRepository = [];

    public function __construct(mysqli $db = null)
    {
        $this->db = $db ?? new DatabaseV2();
    }

    public function vehicles($userid)
    {
        if (!array_key_exists($userid, $this->vehicleRepository)) {
            $this->vehicleRepository[$userid] = new VehicleRepository($this->db, $userid);
        }
        return $this->vehicleRepository[$userid];
    }

    public function fillups($vehicle_id)
    {
        if (!array_key_exists($vehicle_id, $this->fillupRepository)) {
            $this->fillupRepository[$vehicle_id] = new FillupRepository($this->db, $vehicle_id);
        }
        return $this->fillupRepository[$vehicle_id];
    }

    public function maintenances($vehicle_id)
    {
        if (!array_key_exists($vehicle_id, $this->maintenanceRepository)) {
            $this->maintenanceRepository[$vehicle_id] = new MaintenanceRepository($this->db, $vehicle_id);
        }
        return $this->maintenanceRepository[$vehicle_id];
    }

    public function reminders($vehicle_id)
    {
        if (!array_key_exists($vehicle_id, $this->reminderRepository)) {
            $this->reminderRepository[$vehicle_id] = new ReminderRepository($this->db, $vehicle_id);
        }
        return $this->reminderRepository[$vehicle_id];
    }

    public function trips($vehicle_id)
    {
        if (!array_key_exists($vehicle_id, $this->tripRepository)) {
            $this->tripRepository[$vehicle_id] = new TripRepository($this->db, $vehicle_id);
        }
        return $this->tripRepository[$vehicle_id];
    }

    public function trip_checkpoints($vehicle_id, $trip_id)
    {
        if (!array_key_exists($vehicle_id . "-" . $trip_id, $this->tripCheckpointRepository)) {
            $this->tripCheckpointRepository[$trip_id] = new TripCheckpointRepository($this->db, $trip_id);
        }
        return $this->tripCheckpointRepository[$trip_id];
    }

    //

    public function beginTransaction()
    {
        $this->db->beginTransaction();
    }
    public function commit()
    {
        $this->db->commit();
    }
    public function rollback()
    {
        $this->db->rollback();
    }
    public function close()
    {
        $this->db->close();
    }
    public function getDb()
    {
        return $this->db;
    }
}
