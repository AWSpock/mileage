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

$summary = (object)[
    "MPD" => null,
    "MPDLife" => null,
    "MPY" => null,
    "MPYLife" => null,
    "MPG" => [],
    "GAL" => [],
    "PRI" => [],
    "PPG" => [],
    "AvgMPG" => 0,
    "AvgGAL" => 0,
    "AvgPRI" => 0,
    "AvgPPG" => 0,
    "DAY" => [],
    "MIL" => [],
    "AvgDAY" => 0,
    "AvgMIL" => 0,
    "reminders" => [],
];

$fillups = $data->fillups($recVehicle->id())->getRecords();

// MILES PER DAY

$firstDate = null;
$firstOdom = null;
$lastDate = null;
$lastOdom = null;

foreach ($fillups as $fillup) {
    if (!is_null($summary->MPD)) {
        $lastDate = $fillup->date();
        $lastOdom = $fillup->odometer();
        continue;
    }
    if (is_null($firstDate)) {
        $firstDate = $fillup->date();
        $firstOdom = $fillup->odometer();
        continue;
    }
    if ($firstDate == $fillup->date()) {
        continue;
    }

    $dt1 = new DateTime($fillup->date());
    $dt2 = new DateTime($firstDate);
    $interval = $dt1->diff($dt2);

    $day = $interval->format('%a');
    $summary->MPD = ($firstOdom - $fillup->odometer()) / $day;
}
if (!(is_null($firstDate) && is_null($lastDate) && is_null($firstOdom) && is_null($lastOodom))) {
    $dt1 = new DateTime($lastDate);
    $dt2 = new DateTime($firstDate);
    $interval = $dt1->diff($dt2);

    $day = $interval->format('%a');
    $summary->MPDLife = ($firstOdom - $lastOdom) / $day;
}

// MILES PER YEAR

$yrago = new DateTime($firstDate);
$yrago = $yrago->modify("-1 year");

foreach ($fillups as $fillup) {
    $dt1 = new DateTime($fillup->date());
    if ($yrago >= $dt1) {
        $dt2 = new DateTime($firstDate);
        $interval = $dt1->diff($dt2);

        $days = $interval->format('%a');
        $year = $days / 365.25;
        $summary->MPY = ($firstOdom - $fillup->odometer()) / $year;
        break;
    }
}
if (!(is_null($firstDate) && is_null($lastDate) && is_null($firstOdom) && is_null($lastOodom))) {
    $dt1 = new DateTime($lastDate);
    $dt2 = new DateTime($firstDate);
    $interval = $dt1->diff($dt2);

    $days = $interval->format('%a');
    $year = $days / 365.25;
    $summary->MPYAvg = ($firstOdom - $lastOdom) / $year;
}

//

usort($fillups, function ($a, $b) {
    return $a->odometer() > $b->odometer();
});

// MPG, GALLON, PRICE, PPG

foreach ($fillups as $fillup) {
    if (!is_null($fillup->mpg()))
        array_push($summary->MPG, $fillup->mpg());

    if ($fillup->gallon() > 0)
        array_push($summary->GAL, $fillup->gallon());

    if ($fillup->price() > 0)
        array_push($summary->PRI, $fillup->price());

    if ($fillup->ppg() > 0)
        array_push($summary->PPG, $fillup->ppg());
}

if (count($summary->MPG) > 0)
    $summary->AvgMPG = array_sum($summary->MPG) / count($summary->MPG);

if (count($summary->GAL) > 0)
    $summary->AvgGAL = array_sum($summary->GAL) / count($summary->GAL);

if (count($summary->PRI) > 0)
    $summary->AvgPRI = array_sum($summary->PRI) / count($summary->PRI);

if (count($summary->PPG) > 0)
    $summary->AvgPPG = array_sum($summary->PPG) / count($summary->PPG);


// DAYS and MILES

foreach ($fillups as $fillup) {
    // if ($fillup->missed()) {
    //     continue;
    // }

    if (!is_null($fillup->days()))
        array_push($summary->DAY, $fillup->days());

    if (!is_null($fillup->miles()))
        array_push($summary->MIL, $fillup->miles());
}

if (count($summary->DAY) > 0)
    $summary->AvgDAY = array_sum($summary->DAY) / count($summary->DAY);

if (count($summary->MIL) > 0)
    $summary->AvgMIL = array_sum($summary->MIL) / count($summary->MIL);

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

$reminderRecs = $data->reminders($vehicle_id)->getRecords();

$max_odometer = 0;

foreach ($fillups as $fillup) {
    if ($max_odometer < $fillup->odometer())
        $max_odometer = $fillup->odometer();
}

foreach ($data->maintenances($vehicle_id)->getRecords() as $maintenance) {
    if ($max_odometer < $maintenance->odometer())
        $max_odometer = $maintenance->odometer();
}

$today = new DateTime();
foreach ($reminderRecs as $reminder) {
    $rem = (object)[
        "due" => "",
        "title" => "",
        "description" => "",
        "odom_due" => null,
        "date_due" => null
    ];

    $due = "";
    if ($reminder->due_odometer() !== null && $reminder->due_odometer() <= $max_odometer)
        $due = "overdue";
    if ($reminder->due_date() !== null) {
        $dt = new DateTime($reminder->due_date());
        if ($dt <= $today)
            $due = "overdue";
    }
    $rem->due = $due;

    $title = $reminder->name();
    if ($due == "overdue")
        $title .= " is DUE!";
    $rem->title = $title;

    $description = str_replace("\n", "<br>", htmlentities($reminder->description()));
    $rem->description = $description;

    if ($reminder->due_odometer() !== null) {
        $odom_due = (object)[
            "due_odometer" => $reminder->due_odometer(),
            "due_in" => 0,
            "unit" => "mile"
        ];
        $due_in = $reminder->due_odometer() - $max_odometer;
        $odom_due->due_in = $due_in;
        if ($due_in !== 1)
            $odom_due->unit .= "s";
        $rem->odom_due = $odom_due;
    }
    if ($reminder->due_date() !== null) {
        $date_due = (object)[
            "due_date" => $reminder->due_date(),
            "due_in" => 0,
            "unit" => "day"
        ];
        $dt = new DateTime($reminder->due_date());
        $due_in = $dt->diff($today)->days;
        $date_due->due_in = $due_in;
        if ($due_in !== 1)
            $date_due->unit .= "s";
        $rem->date_due = $date_due;
    }

    array_push($summary->reminders, $rem);
}
