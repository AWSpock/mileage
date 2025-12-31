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

$stations = [];

//

if (!empty($_POST)) {
    $recFillup = Fillup::fromPost($_POST);
    $res = $fillupData->updateRecord($recFillup);
    $_SESSION['last_message_text'] = $fillupData->actionDataMessage;
    if ($res == 1 || $res == 2) {
        $_SESSION['last_message_type'] = "success";
        header('Location: /vehicle/' . $recVehicle->id() . '/fillup/' . $recFillup->id() . '/edit');
        die();
    } else {
        $_SESSION['last_message_type'] = "danger";
    }
} else {
    foreach ($fillupData->getRecords() as $fillup) {
        if (!in_array($fillup->station(), $stations))
            array_push($stations, $fillup->station());
    }
    sort($stations);
}
