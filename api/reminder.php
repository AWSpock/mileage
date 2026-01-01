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
        if (isset($reminder_id)) {
            echo $data->reminders($recVehicle->id())->getRecordById($reminder_id)->toString();
        } else {
            $recs = [];
            foreach ($data->reminders($recVehicle->id())->getRecords() as $rec) {
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
