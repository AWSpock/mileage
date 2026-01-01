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
