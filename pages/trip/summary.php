<div class="header">
    <h1>Trip Summary</h1>
</div>

<nav class="breadcrumbs">
    <ul>
        <li><a href="/">Vehicles</a></li>
        <li><a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/summary"><?php echo htmlentities($recVehicle->name()); ?></a></li>
        <li><a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/trip">Trips</a></li>
        <li>Trip: <span><?php echo htmlentities($recTrip->name()); ?></span></li>
    </ul>
</nav>

<div class="content">
    <div class="row">
        <a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/trip/<?php echo htmlentities($recTrip->id()); ?>/edit" class="button secondary"><i class="fa-solid fa-pencil"></i>Edit Trip</a>
        <a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/trip/<?php echo htmlentities($recTrip->id()); ?>/checkpoint/create" class="button primary"><i class="fa-solid fa-plus"></i>Add Checkpoint</a>
        <a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/trip/<?php echo htmlentities($recTrip->id()); ?>/checkpoint" class="button secondary"><i class="fa-solid fa-location-pin"></i>All Checkpoints</a>
    </div>
    <div class="row">

        <h2><?php echo htmlentities($recTrip->name()); ?></h2>
        <p><samp><?php echo htmlentities($recTrip->description()); ?></samp></p>

        <h2>Checkpoints</h2>
        <p>Count: <span data-numberformatter><?php echo count($checkpoints); ?></span></p>
        <?php

        $sTCOdom = null;
        $sTCDate = null;
        $tripHasMissed = false;
        $tripFills = [];
        $firstCP = null;
        $lastCP = null;
        foreach ($checkpoints as $recTripCheckpoint) {

            if (is_null($sTCOdom)) {
                $firstCP = $recTripCheckpoint;
        ?>

                <div class="checkpoint">
                    <h3>Initial Checkpoint</h3>
                    <div class="info">
                        <div class="date">Date: <span data-dateonlyformatter><?php echo htmlentities($recTripCheckpoint->date()); ?></span></div>
                        <div class="odometer">Odometer: <span data-numberformatter><?php echo htmlentities($recTripCheckpoint->odometer()); ?></span></div>
                        <div class="description"><span><?php echo htmlentities($recTripCheckpoint->description()); ?></span></div>
                    </div>
                </div>

            <?php
            } else {
                $lastCP = $recTripCheckpoint;
            ?>

                <div class="checkpoint-stats">
                    <?php

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

                    ?>
                    <h4>Leg Stats</h4>
                    <?php
                    if ($hasMissed) {
                    ?>
                        <p>Can't determine stats due to a missed fillup</p>
                    <?php
                        continue;
                    }

                    // echo "<pre>";
                    // print_r($fills);
                    // echo "</pre>";
                    // echo "<p>Start: " . $startOdom . "<br>End: " . $endOdom . "</p>";
                    // echo "<p>Checkpoint Start: " . $sTCOdom . "<br>Checkpoint End: " . $recTripCheckpoint->odometer() . "</p>";

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

                    ?>
                    <div class="info-stats">
                        <h4 class="title1">Actuals</h4>
                        <div class="miles">Miles: <span data-numberformatter><?php echo htmlentities($miles); ?></span></div>
                        <div class="days">Days: <span data-numberformatter><?php echo htmlentities($days); ?></span></div>
                        <h4 class="title2">Estimates</h4>
                        <div class="gallons">Gallons: <span data-number3formatter><?php echo htmlentities($estimated_gallons); ?></span></div>
                        <div class="price">Price: <span data-moneyformatter><?php echo htmlentities($estimated_price); ?></span></div>
                        <h4 class="title3">Averages</h4>
                        <div class="mpg">MPG: <span data-number3formatter><?php echo htmlentities($average_mpg); ?></span></div>
                        <div class="ppg">PPG: <span data-money3formatter><?php echo htmlentities($average_ppg); ?></span></div>
                    </div>
                </div>

                <div class="checkpoint">
                    <h3>Checkpoint</h3>
                    <div class="info">
                        <div class="date">Date: <span data-dateonlyformatter><?php echo htmlentities($recTripCheckpoint->date()); ?></span></div>
                        <div class="odometer">Odometer: <span data-numberformatter><?php echo htmlentities($recTripCheckpoint->odometer()); ?></span></div>
                        <div class="description"><span><?php echo htmlentities($recTripCheckpoint->description()); ?></span></div>
                    </div>
                </div>
        <?php

            }

            $sTCOdom = $recTripCheckpoint->odometer();
            $sTCDate = $recTripCheckpoint->date();
        }

        ?>
        <hr>
        <h2>Full Trip Stats</h2>
        <?php
        if ($tripHasMissed) {
            echo "<p>Can't determine stats due to a missed fillup</p>";
        } else {

            // echo "<pre>";
            // print_r($tripFills);
            // echo "</pre>";
            // echo "<p>Start: " . $startOdom . "<br>End: " . $endOdom . "</p>";
            // echo "<p>Checkpoint Start: " . $sTCOdom . "<br>Checkpoint End: " . $recTripCheckpoint->odometer() . "</p>";

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

        ?>
            <div class="info-stats">
                <h4 class="title1">Actuals</h4>
                <div class="miles">Miles: <span data-numberformatter><?php echo htmlentities($miles); ?></span></div>
                <div class="days">Days: <span data-numberformatter><?php echo htmlentities($days); ?></span></div>
                <h4 class="title2">Estimates</h4>
                <div class="gallons">Gallons: <span data-number3formatter><?php echo htmlentities($estimated_gallons); ?></span></div>
                <div class="price">Price: <span data-moneyformatter><?php echo htmlentities($estimated_price); ?></span></div>
                <h4 class="title3">Averages</h4>
                <div class="mpg">MPG: <span data-number3formatter><?php echo htmlentities($average_mpg); ?></span></div>
                <div class="ppg">PPG: <span data-money3formatter><?php echo htmlentities($average_ppg); ?></span></div>
            </div>
        <?php
        }
        ?>
    </div>
</div>