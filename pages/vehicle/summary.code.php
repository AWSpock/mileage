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

// MILES PER DAY

$firstDate = null;
$firstOdom = null;
$lastDate = null;
$lastOdom = null;
$startDate = null;
$startOdom = null;
$MPD = null;
$MPDLife = null;

foreach ($fillups as $fillup) {
    if (!is_null($MPD)) {
        $lastDate = $fillup->date();
        $lastOdom = $fillup->odometer();
        continue;
    }
    if (is_null($startDate)) {
        $firstDate = $fillup->date();
        $firstOdom = $fillup->odometer();
        $startDate = $fillup->date();
        $startOdom = $fillup->odometer();
        continue;
    }
    if ($startDate == $fillup->date()) {
        continue;
    }

    $dt1 = new DateTime($fillup->date());
    $dt2 = new DateTime($startDate);
    $interval = $dt1->diff($dt2);

    $day = $interval->format('%a');
    $MPD = ($startOdom - $fillup->odometer()) / $day;
}
if (!(is_null($firstDate) && is_null($lastDate) && is_null($firstOdom) && is_null($lastOodom))) {
    $dt1 = new DateTime($lastDate);
    $dt2 = new DateTime($firstDate);
    $interval = $dt1->diff($dt2);

    $day = $interval->format('%a');
    $MPDLife = ($firstOdom - $lastOdom) / $day;
}

//

usort($fillups, function ($a, $b) {
    return $a->odometer() > $b->odometer();
});

// MPG, GALLON, PRICE, PPG

$MPG = [];
$GAL = [];
$PRI = [];
$PPG = [];

foreach ($fillups as $fillup) {
    if (!is_null($fillup->mpg()))
        array_push($MPG, $fillup->mpg());

    if ($fillup->gallon() > 0)
        array_push($GAL, $fillup->gallon());

    if ($fillup->price() > 0)
        array_push($PRI, $fillup->price());

    if ($fillup->ppg() > 0)
        array_push($PPG, $fillup->ppg());
}

$AvgMPG = 0;
$AvgGAL = 0;
$AvgPRI = 0;
$AvgPPG = 0;

if (count($MPG) > 0)
    $AvgMPG = array_sum($MPG) / count($MPG);

if (count($GAL) > 0)
    $AvgGAL = array_sum($GAL) / count($GAL);

if (count($PRI) > 0)
    $AvgPRI = array_sum($PRI) / count($PRI);

if (count($PPG) > 0)
    $AvgPPG = array_sum($PPG) / count($PPG);


// DAYS and MILES

$DAY = [];
$MIL = [];

foreach ($fillups as $fillup) {
    // if ($fillup->missed()) {
    //     continue;
    // }

    if (!is_null($fillup->days()))
        array_push($DAY, $fillup->days());

    if (!is_null($fillup->miles()))
        array_push($MIL, $fillup->miles());
}

$AvgDAY = 0;
$AvgMIL = 0;

if (count($DAY) > 0)
    $AvgDAY = array_sum($DAY) / count($DAY);

if (count($MIL) > 0)
    $AvgMIL = array_sum($MIL) / count($MIL);

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

// REMINDER STUFF

$reminders = $data->reminders($vehicle_id)->getRecords();

$max_odometer = 0;

foreach ($fillups as $fillup) {
    if ($max_odometer < $fillup->odometer())
        $max_odometer = $fillup->odometer();
}

foreach ($data->maintenances($vehicle_id)->getRecords() as $maintenance) {
    if ($max_odometer < $maintenance->odometer())
        $max_odometer = $maintenance->odometer();
}
