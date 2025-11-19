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
$recTrip = $tripData->getRecordById($trip_id);
if ($recTrip->id() < 0) {
    header('Location: /vehicle/' . $recVehicle->id() . '/trip');
    die();
}

$recTripCheckpoint = new TripCheckpoint();

// 

if (!empty($_POST)) {
    $tripCheckpointData = $data->trip_checkpoints($recVehicle->id(), $recTrip->id());
    $recTripCheckpoint = TripCheckpoint::fromPost($_POST);
    $trip_checkpoint_id = $tripCheckpointData->insertRecord($recTripCheckpoint);
    $_SESSION['last_message_text'] = $tripData->actionDataMessage;
    if ($trip_id > 0) {
        $_SESSION['last_message_type'] = "success";
        header('Location: /vehicle/' . $recVehicle->id() . '/trip/' . $recTrip->id() . '/checkpoint');
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
