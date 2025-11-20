<div class="header">
    <h1>Edit Trip</h1>
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
        <?php

        echo "<p>Trip Checkpoints: " . count($checkpoints) . "<br>";
        echo "Fillups: " . count($fillups) . "</p>";

        ?>
        <h2>Checkpoints</h2>
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

                <h3>Initial Checkpoint</h3>
                <div class="info">
                    <div class="date">Date: <span data-dateonlyformatter><?php echo htmlentities($recTripCheckpoint->date()); ?></span></div>
                    <div class="odometer">Odometer: <span data-numberformatter><?php echo htmlentities($recTripCheckpoint->odometer()); ?></span></div>
                    <div class="description">Description: <span><?php echo htmlentities($recTripCheckpoint->description()); ?></span></div>
                </div>

            <?php
            } else {
                $lastCP = $recTripCheckpoint;
            ?>

                <h3>Checkpoint</h3>
                <div class="info">
                    <div class="date">Date: <span data-dateonlyformatter><?php echo htmlentities($recTripCheckpoint->date()); ?></span></div>
                    <div class="odometer">Odometer: <span data-numberformatter><?php echo htmlentities($recTripCheckpoint->odometer()); ?></span></div>
                    <div class="description">Description: <span><?php echo htmlentities($recTripCheckpoint->description()); ?></span></div>
                </div>

                <?php

                $startOdom = null;
                $endOdom = null;
                $fills = [];
                $useNext = false;
                $hasMissed = false;
                foreach ($fillups as $fillup) {
                    if ($fillup->odometer() <= $sTCOdom) {
                        $startOdom = $fillup->odometer();
                        continue;
                    }

                    if ($fillup->missed()) {
                        // can't determine stats
                        $hasMissed = true;
                        $tripHasMissed = true;
                        break;
                    }

                    $endOdom = $fillup->odometer();
                    array_push($fills, $fillup);
                    if (!in_array($fillup, $tripFills, true))
                        array_push($tripFills, $fillup);

                    if ($fillup->partial()) {
                        $useNext = true;
                    } else {
                        $useNext = false;
                    }

                    if ($useNext === false && $fillup->odometer() > $recTripCheckpoint->odometer()) {
                        break;
                    }
                }

                ?>
                <h4 class="indent">Checkpoint Stats</h4>
                <?php
                if ($hasMissed) {
                ?>
                    <p class="indent">Can't determine stats due to a missed fillup</p>
                <?php
                    continue;
                }

                // echo "<pre>";
                // print_r($fills);
                // echo "</pre>";
                // echo "<p>Start: " . $startOdom . "<br>End: " . $endOdom . "</p>";
                // echo "<p>Checkpoint Start: " . $sTCOdom . "<br>Checkpoint End: " . $recTripCheckpoint->odometer() . "</p>";

                $gallons = 0;
                $price = 0;
                $ppg = 0;
                $mpg = 0;
                foreach ($fills as $fill) {
                    $gallons += $fill->gallon();
                    $price += $fill->price();
                    $ppg += $fill->ppg();
                    if (!is_null($fill->mpg()))
                        $mpg += $fill->mpg();

                    $endOdom = $fill->odometer();
                }

                $miles = $recTripCheckpoint->odometer() - $sTCOdom;
                $d1 = new DateTime($sTCDate);
                $d2 = new DateTime($recTripCheckpoint->date());
                $interval = $d1->diff($d2);
                $days = $interval->days + 1;

                $portion = $miles / ($endOdom - $startOdom);

                $estimated_gallons = $gallons * $portion;
                $estimated_price = $price * $portion;

                $average_ppg = 0;
                $average_mpg = 0;
                if (count($fills) > 0) {
                    $average_ppg = $ppg / count($fills);
                    $average_mpg = $mpg / count($fills);
                }

                ?>
                <div class="info-stats indent">
                    <div class="miles">Miles: <span data-numberformatter><?php echo htmlentities($miles); ?></span></div>
                    <div class="days">Days: <span data-numberformatter><?php echo htmlentities($days); ?></span></div>
                    <div class="gallons">Estimated Gallons: <span data-number3formatter><?php echo htmlentities($estimated_gallons); ?></span></div>
                    <div class="price">Estimated Price: <span data-moneyformatter><?php echo htmlentities($estimated_price); ?></span></div>
                    <div class="mpg">Average MPG: <span data-number3formatter><?php echo htmlentities($average_mpg); ?></span></div>
                    <div class="ppg">Average PPG: <span data-moneyformatter><?php echo htmlentities($average_ppg); ?></span></div>
                </div>
        <?php

            }

            $sTCOdom = $recTripCheckpoint->odometer();
            $sTCDate = $recTripCheckpoint->date();
        }

        ?>
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
            $ppg = 0;
            $mpg = 0;
            foreach ($fills as $fill) {
                $gallons += $fill->gallon();
                $price += $fill->price();
                $ppg += $fill->ppg();
                if (!is_null($fill->mpg()))
                    $mpg += $fill->mpg();

                $endOdom = $fill->odometer();
            }

            $miles = $lastCP->odometer() - $firstCP->odometer();
            $d1 = new DateTime($firstCP->date());
            $d2 = new DateTime($lastCP->date());
            $interval = $d1->diff($d2);
            $days = $interval->days + 1;

            $portion = $miles / ($endOdom - $startOdom);

            $estimated_gallons = $gallons * $portion;
            $estimated_price = $price * $portion;

            $average_ppg = 0;
            $average_mpg = 0;
            if (count($fills) > 0) {
                $average_ppg = $ppg / count($fills);
                $average_mpg = $mpg / count($fills);
            }

        ?>
            <div class="info-stats">
                <div class="miles">Miles: <span data-numberformatter><?php echo htmlentities($miles); ?></span></div>
                <div class="days">Days: <span data-numberformatter><?php echo htmlentities($days); ?></span></div>
                <div class="gallons">Estimated Gallons: <span data-number3formatter><?php echo htmlentities($estimated_gallons); ?></span></div>
                <div class="price">Estimated Price: <span data-moneyformatter><?php echo htmlentities($estimated_price); ?></span></div>
                <div class="mpg">Average MPG: <span data-number3formatter><?php echo htmlentities($average_mpg); ?></span></div>
                <div class="ppg">Average PPG: <span data-moneyformatter><?php echo htmlentities($average_ppg); ?></span></div>
            </div>
        <?php
        }
        ?>
    </div>
</div>