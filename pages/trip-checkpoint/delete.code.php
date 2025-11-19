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

$tripCheckpointData = $data->trip_checkpoints($recVehicle->id(), $recTrip->id());
$recTripCheckpoint = $tripCheckpointData->getRecordById($trip_checkpoint_id);
if ($recTripCheckpoint->id() < 0) {
    header('Location: /vehicle/' . $recVehicle->id() . '/trip' . $recTrip->id() . 'checkpoint');
    die();
}

//

// if (!empty($_POST)) {
//     $res = $tripData->deleteRecord($recTrip);
//     $_SESSION['last_message_text'] = $tripData->actionDataMessage;
//     if ($res == 1) {
//         $_SESSION['last_message_type'] = "success";
//         header('Location: /vehicle/' . $recVehicle->id() . '/trip');
//         die();
//     } else {
//         $_SESSION['last_message_type'] = "danger";
//     }
// }
