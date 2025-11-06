<?php

$vehicleData = $data->vehicles($userAuth->user()->id());

$recVehicle = $vehicleData->getRecordById($vehicle_id);
if ($recVehicle->id() < 0) {
    header('Location: /');
    die();
}
/*if (!$recVehicle->isOwner()) {
    header('Location: /vehicle/' . $recVehicle->id() . '/summary');
    die();
}*/

//

if (!empty($_POST)) {
    $recVehicle = Vehicle::fromPost($_POST);
    $res = $vehicleData->updateRecord($recVehicle);
    $_SESSION['last_message_text'] = $vehicleData->actionDataMessage;
    if ($res == 1 || $res == 2) {
        $_SESSION['last_message_type'] = "success";
        header('Location: /vehicle/' . $recVehicle->id() . '/summary');
        die();
    } else {
        $_SESSION['last_message_type'] = "danger";
    }
}
