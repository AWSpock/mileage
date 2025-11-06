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
$recMaintenance = $maintenanceData->getRecordById($record_id);
if ($recMaintenance->id() < 0) {
    header('Location: /vehicle/' . $recVehicle->id() . '/maintenance');
    die();
}

$garages = [];

//

if (!empty($_POST)) {
    $recMaintenance = Maintenance::fromPost($_POST);
    $res = $maintenanceData->updateRecord($recMaintenance);
    $_SESSION['last_message_text'] = $maintenanceData->actionDataMessage;
    if ($res == 1 || $res == 2) {
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
