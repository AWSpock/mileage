<?php

$vehicleData = $data->vehicles($userAuth->user()->id());
$vehicles = $vehicleData->getRecords();

$recVehicle = $vehicleData->getRecordById($vehicle_id);
if ($recVehicle->id() < 0) {
    header('Location: /');
    die();
}

//$recVehicle->store_bill_types($data->bill_types($recVehicle->id())->getRecords());

// foreach ($recVehicle->bill_types() as $recBillType) {
//     $recBillType->store_bills($data->bills($recVehicle->id(), $recBillType->id())->getRecords());
// }

//

// if (!empty($_POST['vehicle_favorite'])) {
//     $res = 0;
//     switch ($_POST['vehicle_favorite']) {
//         case "Yes":
//             $res = $vehicleData->setFavorite($recVehicle->id());
//             break;
//         case "No":
//             $res = $vehicleData->removeFavorite($recVehicle->id());
//             break;
//     }
//     $_SESSION['last_message_text'] = $vehicleData->actionDataMessage;
//     if ($res === true) {
//         $_SESSION['last_message_type'] = "success";
//         header('Location: /vehicle/' . $recVehicle->id() . '/summary');
//         die();
//     } else {
//         $_SESSION['last_message_type'] = "danger";
//     }
// }

function returnPercentage($value, $min = 0, $max = 100)
{
    if ($max - $min > 0) {
        $interval = 100 / ($max - $min);
        $percent = ($value - $min) * $interval;
        return round($percent / 2, 2) / 100;
    }
    return 0;
}
