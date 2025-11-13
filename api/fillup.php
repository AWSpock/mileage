<?php

$vehicleData = $data->vehicles($userAuth->user()->id());

$recVehicle = $vehicleData->getRecordById($vehicle_id);
if ($recVehicle->id() < 0) {
    echo "Vehicle Not Found";
    http_response_code(404);
    die();
}

switch ($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        if (isset($record_id)) {
            echo $data->fillups($recVehicle->id())->getRecordById($record_id)->toString();
        } else {
            // $data->fillups($recVehicle->id())->calculateStats();
            $recs = [];
            foreach ($data->fillups($recVehicle->id())->getRecords() as $rec) {
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
