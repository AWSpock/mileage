<?php

$vehicleData = $data->vehicles($userAuth->user()->id());

$recVehicle = $vehicleData->getRecordById($vehicle_id);
if ($recVehicle->id() < 0) {
    header('Location: /');
    die();
}
if (!$recVehicle->isOwner()) {
    header('Location: /vehicle/' . $recVehicle->id() . '/summary');
    die();
}

// $recVehicle->store_bill_types($data->bill_types($recVehicle->id())->getRecords());

//

if (!empty($_POST)) {
    $res = $vehicleData->deleteRecord($recVehicle);
    $_SESSION['last_message_text'] = $vehicleData->actionDataMessage;
    if ($res == 1) {
        $_SESSION['last_message_type'] = "success";
        header('Location: /');
        die();
    } else {
        $_SESSION['last_message_type'] = "danger";
    }
}
?>