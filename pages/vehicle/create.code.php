<?php

$recVehicle = new Vehicle();

// 

if (!empty($_POST)) {
    $data = new DataAccess();
    $vehicleData = $data->vehicles($userAuth->user()->id());

    $recVehicle = Vehicle::fromPost($_POST);
    $vehicle_id = $vehicleData->insertRecord($recVehicle);
    $_SESSION['last_message_text'] = $vehicleData->actionDataMessage;
    if ($vehicle_id > 0) {
        $_SESSION['last_message_type'] = "success";
        header('Location: /vehicle/' . $vehicle_id . '/summary');
        die();
    } else {
        $_SESSION['last_message_type'] = "danger";
    }
}
