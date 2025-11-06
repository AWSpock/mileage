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

$fillupData = $data->fillups($recVehicle->id());
$recFillup = $fillupData->getRecordById($record_id);
if ($recFillup->id() < 0) {
    header('Location: /vehicle/' . $recVehicle->id() . '/fillup');
    die();
}

// $recFillup->store_bills($data->bills($recVehicle->id(), $recFillup->id())->getRecords());

//

if (!empty($_POST)) {
    $res = $fillupData->deleteRecord($recFillup);
    $_SESSION['last_message_text'] = $fillupData->actionDataMessage;
    if ($res == 1) {
        $_SESSION['last_message_type'] = "success";
        header('Location: /vehicle/' . $recVehicle->id() . '/fillup');
        die();
    } else {
        $_SESSION['last_message_type'] = "danger";
    }
}
?>