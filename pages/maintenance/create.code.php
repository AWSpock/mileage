<?php

$vehicleData = $data->vehicles($userAuth->user()->id());

$recVehicle = $vehicleData->getRecordById($vehicle_id);
if ($recVehicle->id() < 0) {
    header('Location: /');
    die();
}
if (!($recVehicle->isOwner() || $recVehicle->isManager())) {
    header('Location: /vehicle/' . $recVehicle->id() . '/summary');
    die();
}

$maintenanceData = $data->maintenances($recVehicle->id());

$recMaintenance = new Maintenance();

$garages = [];

// 

if (!empty($_POST)) {
    $recMaintenance = Maintenance::fromPost($_POST);
    $record_id = $maintenanceData->insertRecord($recMaintenance);
    $_SESSION['last_message_text'] = $maintenanceData->actionDataMessage;
    if ($record_id > 0) {
        $_SESSION['last_message_type'] = "success";
        header('Location: /vehicle/' . $recVehicle->id() . '/maintenance');
        die();
    } else {
        $_SESSION['last_message_type'] = "danger";
    }
} else {
    foreach ($maintenanceData->getRecords() as $maintenance) {
        if (!in_array($maintenance->garage(), $garages))
            array_push($garages, $maintenance->garage());
    }
    sort($garages);
}
