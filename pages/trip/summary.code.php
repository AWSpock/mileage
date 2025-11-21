<?php

$vehicleData = $data->vehicles($userAuth->user()->id());

$recVehicle = $vehicleData->getRecordById($vehicle_id);
if ($recVehicle->id() < 0) {
    header('Location: /');
    die();
}
if (!($recVehicle->isOwner() || $recVehicle->isManager())) {
    header('Location: /vehicle/' . $recVehicle->id() . '/summary');
    die();
}

$tripData = $data->trips($recVehicle->id());
$recTrip = $tripData->getRecordById($trip_id);
if ($recTrip->id() < 0) {
    header('Location: /vehicle/' . $recVehicle->id() . '/trip');
    die();
}

// $tags = [];

$recTrip->store_trip_checkpoints($data->trip_checkpoints($recVehicle->id(), $recTrip->id())->getRecords());
$checkpoints = $recTrip->trip_checkpoints();

$fillupData = $data->fillups($recVehicle->id());
$fillups = $fillupData->getRecords();

usort($fillups, function ($a, $b) {
    return $a->odometer() > $b->odometer();
});

usort($checkpoints, function ($a, $b) {
    return $a->odometer() > $b->odometer();
});

$checkpointStats = [];
array_push($checkpointStats, null); // start with empty

$sTCOdom = null;
$sTCDate = null;
$tripHasMissed = false;
$tripFills = [];
$firstCP = null;
$lastCP = null;
foreach ($checkpoints as $recTripCheckpoint) {

    if (is_null($sTCOdom)) {
        $firstCP = $recTripCheckpoint;
    } else {
        $lastCP = $recTripCheckpoint;

        $fills = [];
        $useNext = false;
        $hasMissed = false;
        $oneMore = true;
        foreach ($fillups as $fillup) {
            if ($fillup->odometer() < $sTCOdom) {
                continue;
            }

            if ($fillup->missed()) {
                // can't determine stats
                $hasMissed = true;
                $tripHasMissed = true;
                break;
            }

            array_push($fills, $fillup);
            if (!in_array($fillup, $tripFills, true))
                array_push($tripFills, $fillup);

            if ($fillup->partial()) {
                $useNext = true;
                $oneMore = true;
            } else {
                $useNext = false;
            }

            if ($useNext === false && $fillup->odometer() > $recTripCheckpoint->odometer()) {
                if ($oneMore) {
                    $oneMore = false;
                } else {
                    break;
                }
            }
        }

        if ($hasMissed) {
            array_push($checkpointStats, null);
            continue;
        }

        $eTCOdom = $recTripCheckpoint->odometer();

        $gallons = 0;
        $price = 0;
        $ppg = [];
        $mpg = [];
        $prevMpgEmpty = false;
        foreach ($fills as $fill) {
            $start = $fill->odometer() - $fill->miles();
            $end = $fill->odometer();
            $miles = $fill->miles();

            $portion = 1;
            if ($start > $eTCOdom) {
                // echo "0";
                $portion = 0;
            } else if ($start < $sTCOdom && $end >= $eTCOdom) {
                // echo "1";
                $portion = ($eTCOdom - $sTCOdom) / $miles;
            } else if ($start < $sTCOdom && $end <= $eTCOdom) {
                // echo "2";
                $portion = ($end - $sTCOdom) / $miles;
            } else if ($start > $sTCOdom && $end > $eTCOdom) {
                // echo "3";
                $portion = ($eTCOdom - $start) / $miles;
            } else {
                // echo "5";
            }
            $gallons += $fill->gallon() * $portion;
            $price += $fill->price() * $portion;
            // echo "price: " . $price . " by " . ($fill->price() * $portion) . " and " . $fill->price() . "<br>";
            if ($portion > 0)
                array_push($ppg, $fill->ppg());
            if (!is_null($fill->mpg()) && ($portion == 0 && $prevMpgEmpty) || (!is_null($fill->mpg())  && $portion > 0)) {
                array_push($mpg, $fill->mpg());
                $prevMpgEmpty = false;
            } else {
                $prevMpgEmpty = true;
            }
        }

        $miles = $recTripCheckpoint->odometer() - $sTCOdom;
        $d1 = new DateTime($sTCDate);
        $d2 = new DateTime($recTripCheckpoint->date());
        $interval = $d1->diff($d2);
        $days = $interval->days;

        $estimated_gallons = $gallons;
        $estimated_price = $price;

        $average_ppg = 0;
        $average_mpg = 0;
        if (count($mpg) > 0)
            $average_mpg = array_sum($mpg) / count($mpg);
        if (count($ppg) > 0)
            $average_ppg = array_sum($ppg) / count($ppg);

        $stat = (object)[
            "miles" => $miles,
            "days" => $days,
            "gallons" => $estimated_gallons,
            "price" => $estimated_price,
            "mpg" => $average_mpg,
            "ppg" => $average_ppg
        ];

        array_push($checkpointStats, $stat);
    }

    $sTCOdom = $recTripCheckpoint->odometer();
    $sTCDate = $recTripCheckpoint->date();
}


$tripStats = null;

if (!$tripHasMissed) {
    $gallons = 0;
    $price = 0;
    $ppg = [];
    $mpg = [];
    $sTOdom = $firstCP->odometer();
    $eTOdom = $lastCP->odometer();
    $prevMpgEmpty = false;
    foreach ($tripFills as $fill) {
        $start = ($fill->odometer() - $fill->miles());
        $end = $fill->odometer();
        $miles = $fill->miles();

        $portion = 1;
        if ($start > $eTOdom) {
            // echo "0";
            $portion = 0;
        } else if ($start < $sTOdom && $end >= $eTOdom) {
            // echo "1";
            $portion = ($eTOdom - $sTOdom) / $miles;
        } else if ($start < $sTOdom && $end <= $eTOdom) {
            // echo "2";
            $portion = ($end - $sTOdom) / $miles;
        } else if ($start > $sTOdom && $end > $eTOdom) {
            // echo "3";
            $portion = ($eTOdom - $start) / $miles;
        } else {
            // echo "5";
        }
        $gallons += $fill->gallon() * $portion;
        $price += $fill->price() * $portion;
        // echo "price: " . $price . " by " . ($fill->price() * $portion) . " and " . $fill->price() . "<br>";
        if ($portion > 0)
            array_push($ppg, $fill->ppg());
        if (!is_null($fill->mpg()) && ($portion == 0 && $prevMpgEmpty) || (!is_null($fill->mpg())  && $portion > 0)) {
            array_push($mpg, $fill->mpg());
            $prevMpgEmpty = false;
        } else {
            $prevMpgEmpty = true;
        }
    }

    $miles = $lastCP->odometer() - $sTOdom;
    $d1 = new DateTime($firstCP->date());
    $d2 = new DateTime($lastCP->date());
    $interval = $d1->diff($d2);
    $days = $interval->days;

    $estimated_gallons = $gallons;
    $estimated_price = $price;

    $average_ppg = 0;
    $average_mpg = 0;
    if (count($ppg) > 0)
        $average_ppg = array_sum($ppg) / count($ppg);
    if (count($mpg) > 0)
        $average_mpg = array_sum($mpg) / count($mpg);

    $tripStats = (object)[
        "miles" => $miles,
        "days" => $days,
        "gallons" => $estimated_gallons,
        "price" => $estimated_price,
        "mpg" => $average_mpg,
        "ppg" => $average_ppg
    ];
}
