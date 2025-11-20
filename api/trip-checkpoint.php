<?php

$vehicleData = $data->vehicles($userAuth->user()->id());

$recVehicle = $vehicleData->getRecordById($vehicle_id);
if ($recVehicle->id() < 0) {
    echo "Vehicle Not Found";
    http_response_code(404);
    die();
}

$tripData = $data->trips($recVehicle->id());

$recTrip = $tripData->getRecordById($trip_id);
if ($recTrip->id() < 0) {
    echo "Trip Not Found";
    http_response_code(404);
    die();
}

switch ($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        if (isset($trip_checkpoint_id)) {
            echo $data->trip_checkpoints($recVehicle->id(), $recTrip->id())->getRecordById($trip_checkpoint_id)->toString();
        } else {
            $recs = [];
            foreach ($data->trip_checkpoints($recVehicle->id(), $recTrip->id())->getRecords() as $rec) {
                array_push($recs, json_decode($rec->toString()));
            }
            echo json_encode($recs);
        }
        break;
    case "POST":
        break;
    default:
        echo "Unknown Method";
        http_response_code(405);
        break;
}
