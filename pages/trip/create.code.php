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

$tripData = $data->trips($recVehicle->id());

$recTrip = new Trip();

$tags = [];

// 

if (!empty($_POST)) {
    $recTrip = Trip::fromPost($_POST);
    $record_id = $tripData->insertRecord($recTrip);
    $_SESSION['last_message_text'] = $tripData->actionDataMessage;
    if ($record_id > 0) {
        $_SESSION['last_message_type'] = "success";
        header('Location: /vehicle/' . $recVehicle->id() . '/trip');
        die();
    } else {
        $_SESSION['last_message_type'] = "danger";
    }
} else {
    // foreach ($tripData->getRecords() as $trip) {
    //     if (!in_array($trip->tag(), $tags))
    //         array_push($tags, $trip->station());
    // }
    // sort($tags);
}
