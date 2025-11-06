<?php
require_once("/var/www/mileage/php/DataAccess/Database.php");
require_once("/var/www/mileage/php/DataAccess/Repositories/VehicleRepository.php");
require_once("/var/www/mileage/php/DataAccess/Repositories/FillupRepository.php");
require_once("/var/www/mileage/php/DataAccess/Repositories/MaintenanceRepository.php");

class DataAccess
{
    private $db;
    private $vehicleRepository = [];
    private $fillupRepository = [];
    private $maintenanceRepository = [];

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
