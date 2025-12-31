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

$recFillup = new Fillup();

$stations = [];

// 

if (!empty($_POST)) {
    $recFillup = Fillup::fromPost($_POST);
    $record_id = $fillupData->insertRecord($recFillup);
    $_SESSION['last_message_text'] = $fillupData->actionDataMessage;
    if ($record_id > 0) {
        $_SESSION['last_message_type'] = "success";
        header('Location: /vehicle/' . $recVehicle->id() . '/fillup/' . $record_id . '/edit');
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
