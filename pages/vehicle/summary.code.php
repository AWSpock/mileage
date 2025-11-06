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

if (!empty($_POST['vehicle_favorite'])) {
    $res = 0;
    switch ($_POST['vehicle_favorite']) {
        case "Yes":
            $res = $vehicleData->setFavorite($recVehicle->id());
            break;
        case "No":
            $res = $vehicleData->removeFavorite($recVehicle->id());
            break;
    }
    $_SESSION['last_message_text'] = $vehicleData->actionDataMessage;
    if ($res === true) {
        $_SESSION['last_message_type'] = "success";
        header('Location: /vehicle/' . $recVehicle->id() . '/summary');
        die();
    } else {
        $_SESSION['last_message_type'] = "danger";
    }
}

$fillups = $data->fillups($recVehicle->id())->getRecords();

usort($fillups, function ($a, $b) {
    return $a->odometer() > $b->odometer();
});

// MPG

$MPG = [];
$startOdom = null;
$totalGallon = 0;

foreach ($fillups as $fillup) {
    if (is_null($startOdom)) {
        $startOdom = $fillup->odometer();
        $totalGallon = 0;
        continue;
    }
    if ($fillup->missed()) {
        $startOdom = null;
        $totalGallon = 0;
        continue;
    }

    $totalGallon += $fillup->gallon();
    if ($fillup->partial()) {
        continue;
    }
    array_push($MPG, ($fillup->odometer() - $startOdom) / $totalGallon);
    $totalGallon = 0;
    $startOdom = $fillup->odometer();
}

$AvgMPG = 0;
if (count($MPG) > 0) {
    $AvgMPG = array_sum($MPG) / count($MPG);
}

// GALLON

$GAL = [];

foreach ($fillups as $fillup) {
    if ($fillup->gallon() > 0)
        array_push($GAL, $fillup->gallon());
}

$AvgGAL = 0;
if (count($GAL) > 0) {
    $AvgGAL = array_sum($GAL) / count($GAL);
}

// PRICE

$PRI = [];

foreach ($fillups as $fillup) {
    if ($fillup->price() > 0)
        array_push($PRI, $fillup->price());
}

$AvgPRI = 0;
if (count($PRI) > 0) {
    $AvgPRI = array_sum($PRI) / count($PRI);
}

// PPG

$PPG = [];

foreach ($fillups as $fillup) {
    if ($fillup->ppg() > 0)
        array_push($PPG, $fillup->ppg());
}

$AvgPPG = 0;
if (count($PPG) > 0) {
    $AvgPPG = array_sum($PPG) / count($PPG);
}

// DAYS

$DAY = [];
$startDate = null;

foreach ($fillups as $fillup) {
    if (is_null($startDate)) {
        $startDate = $fillup->date();
        continue;
    }
    if ($fillup->missed()) {
        $startDate = null;
        continue;
    }

    $d1 = new DateTime($startDate);
    $d2 = new DateTime($fillup->date());
    $interval = $d1->diff($d2);

    array_push($DAY, $interval->format('%a'));
    $startDate = $fillup->date();
}

$AvgDAY = 0;
if (count($DAY) > 0) {
    $AvgDAY = array_sum($DAY) / count($DAY);
}

// MILES

$MIL = [];
$startOdom = null;

foreach ($fillups as $fillup) {
    if (is_null($startOdom)) {
        $startOdom = $fillup->odometer();
        continue;
    }
    if ($fillup->missed()) {
        $startOdom = null;
        continue;
    }

    array_push($MIL, $fillup->odometer() - $startOdom);
    $startOdom = $fillup->odometer();
}

$AvgMIL = 0;
if (count($MIL) > 0) {
    $AvgMIL = array_sum($MIL) / count($MIL);
}

//

function returnPercentage($value, $min = 0, $max = 100)
{
    if ($max - $min > 0) {
        $interval = 100 / ($max - $min);
        $percent = ($value - $min) * $interval;
        return round($percent / 2, 2) / 100;
    }
    return 0;
}
