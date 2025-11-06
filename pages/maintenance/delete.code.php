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

// $recMaintenance->store_bills($data->bills($recVehicle->id(), $recMaintenance->id())->getRecords());

//

if (!empty($_POST)) {
    $res = $maintenanceData->deleteRecord($recMaintenance);
    $_SESSION['last_message_text'] = $maintenanceData->actionDataMessage;
    if ($res == 1) {
        $_SESSION['last_message_type'] = "success";
        header('Location: /vehicle/' . $recVehicle->id() . '/maintenance');
        die();
    } else {
        $_SESSION['last_message_type'] = "danger";
    }
}
?>