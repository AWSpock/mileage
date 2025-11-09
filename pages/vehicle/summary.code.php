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

// DAYS and MILES

$DAY = [];
$startDate = null;
$MIL = [];
$startOdom = null;
$MPD = 0;
$mpdDStart = null;
$mpdOStart = null;
$MPDLife = 0;

foreach ($fillups as $fillup) {
    if (is_null($startDate)) {
        $startDate = $fillup->date();
        $startOdom = $fillup->odometer();
        $mpdDStart = $startDate;
        $mpdOStart = $startOdom;
        continue;
    }
    if ($fillup->missed()) {
        $startDate = null;
        $startOdom = null;
        continue;
    }

    $d1 = new DateTime($startDate);
    $d2 = new DateTime($fillup->date());
    $interval = $d1->diff($d2);

    $day = $interval->format('%a');
    array_push($DAY, $day);
    $startDate = $fillup->date();

    $mile = $fillup->odometer() - $startOdom;
    array_push($MIL, $mile);
    $startOdom = $fillup->odometer();

    if ($day > 0)
        $MPD = $mile / $day;

    $dt1 = new DateTime($mpdDStart);
    $dt2 = new DateTime($fillup->date());
    $intervalt = $dt1->diff($dt2);

    $dayt = $intervalt->format('%a');
    if ($dayt > 0)
        $MPDLife = ($fillup->odometer() - $mpdOStart) / $dayt;
}

$AvgDAY = 0;
if (count($DAY) > 0) {
    $AvgDAY = array_sum($DAY) / count($DAY);
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
