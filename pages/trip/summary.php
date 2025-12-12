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
        <div class="options">
            <a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/trip/<?php echo htmlentities($recTrip->id()); ?>/edit" class="button secondary"><i class="fa-solid fa-pencil"></i>Edit Trip</a>
            <a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/trip/<?php echo htmlentities($recTrip->id()); ?>/checkpoint/create" class="button primary"><i class="fa-solid fa-plus"></i>Add Checkpoint</a>
            <a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/trip/<?php echo htmlentities($recTrip->id()); ?>/checkpoint" class="button secondary"><i class="fa-solid fa-location-pin"></i>All Checkpoints</a>
        </div>
    </div>
    <div class="row">

        <h2><?php echo htmlentities($recTrip->name()); ?></h2>
        <p><samp><?php echo htmlentities($recTrip->description()); ?></samp></p>

        <h2>Checkpoints</h2>
        <p>Count: <span data-numberformatter><?php echo count($checkpoints); ?></span></p>

        <div class="data-table">
            <?php

            $count = 0;
            foreach ($checkpoints as $recTripCheckpoint) {
                $stat = $checkpointStats[$count];
                if ($count == 0) {
            ?>
                    <div class="checkpoint data-table-row">
                        <h3>Initial Checkpoint</h3>
                        <div class="info">
                            <div class="date data-table-cell">
                                <div class="data-table-cell-label">Date</div>
                                <div class="data-table-cell-content"><span data-dateonlyformatter><?php echo htmlentities($recTripCheckpoint->date()); ?></span></div>
                            </div>
                            <div class="odometer data-table-cell">
                                <div class="data-table-cell-label">Odometer</div>
                                <div class="data-table-cell-content"><span data-numberformatter><?php echo htmlentities($recTripCheckpoint->odometer()); ?></span></div>
                            </div>
                            <div class="description data-table-cell">
                                <div class="data-table-cell-content"><span><?php echo htmlentities($recTripCheckpoint->description()); ?></span></div>
                            </div>
                        </div>
                    </div>
                <?php
                } else {
                ?>
                    <div class="checkpoint-stats data-table-row">
                        <h4>Leg Stats</h4>
                        <?php
                        if (is_null($stat)) {
                        ?>
                            <p>Can't determine stats due to a missed fillup</p>
                        <?php
                        } else {
                        ?>
                            <div class="info-stats">
                                <h4 class="title1">Actuals</h4>
                                <div class="miles data-table-cell">
                                    <div class="data-table-cell-label">Miles</div>
                                    <div class="data-table-cell-content"><span data-numberformatter><?php echo htmlentities($stat->miles); ?></span></div>
                                </div>
                                <div class="days data-table-cell">
                                    <div class="data-table-cell-label">Days</div>
                                    <div class="data-table-cell-content"><span data-numberformatter><?php echo htmlentities($stat->days); ?></span></div>
                                </div>
                                <h4 class="title2">Estimates</h4>
                                <div class="gallons data-table-cell">
                                    <div class="data-table-cell-label">Gallons</div>
                                    <div class="data-table-cell-content"><span data-number3formatter><?php echo htmlentities($stat->gallons); ?></span></div>
                                </div>
                                <div class="price data-table-cell">
                                    <div class="data-table-cell-label">Price</div>
                                    <div class="data-table-cell-content"><span data-moneyformatter><?php echo htmlentities($stat->price); ?></span></div>
                                </div>
                                <h4 class="title3">Averages</h4>
                                <div class="mpg data-table-cell">
                                    <div class="data-table-cell-label">MPG</div>
                                    <div class="data-table-cell-content"><span data-number3formatter><?php echo htmlentities($stat->mpg); ?></span></div>
                                </div>
                                <div class="ppg data-table-cell">
                                    <div class="data-table-cell-label">PPG</div>
                                    <div class="data-table-cell-content"><span data-money3formatter><?php echo htmlentities($stat->ppg); ?></span></div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>

                    <div class="checkpoint data-table-row">
                        <h3>Checkpoint</h3>
                        <div class="info">
                            <div class="date data-table-cell">
                                <div class="data-table-cell-label">Date</div>
                                <div class="data-table-cell-content"><span data-dateonlyformatter><?php echo htmlentities($recTripCheckpoint->date()); ?></span></div>
                            </div>
                            <div class="odometer data-table-cell">
                                <div class="data-table-cell-label">Odometer</div>
                                <div class="data-table-cell-content"><span data-numberformatter><?php echo htmlentities($recTripCheckpoint->odometer()); ?></span></div>
                            </div>
                            <div class="description data-table-cell">
                                <div class="data-table-cell-content"><span><?php echo htmlentities($recTripCheckpoint->description()); ?></span></div>
                            </div>
                        </div>
                    </div>
            <?php

                }
                $count++;
            }

            ?>
            <hr>
            <h2>Full Trip Stats</h2>
            <?php
            if (is_null($tripStats)) {
                echo "<p>Can't determine stats due to a missed fillup</p>";
            } else {
            ?>
                <div class="checkpoint-stats data-table-row">
                    <div class="info-stats">
                        <h4 class="title1">Actuals</h4>
                        <div class="miles data-table-cell">
                            <div class="data-table-cell-label">Miles</div>
                            <div class="data-table-cell-content"><span data-numberformatter><?php echo htmlentities($tripStats->miles); ?></span></div>
                        </div>
                        <div class="days data-table-cell">
                            <div class="data-table-cell-label">Days</div>
                            <div class="data-table-cell-content"><span data-numberformatter><?php echo htmlentities($tripStats->days); ?></span></div>
                        </div>
                        <h4 class="title2">Estimates</h4>
                        <div class="gallons data-table-cell">
                            <div class="data-table-cell-label">Gallons</div>
                            <div class="data-table-cell-content"><span data-number3formatter><?php echo htmlentities($tripStats->gallons); ?></span></div>
                        </div>
                        <div class="price data-table-cell">
                            <div class="data-table-cell-label">Price</div>
                            <div class="data-table-cell-content"><span data-moneyformatter><?php echo htmlentities($tripStats->price); ?></span></div>
                        </div>
                        <h4 class="title3">Averages</h4>
                        <div class="mpg data-table-cell">
                            <div class="data-table-cell-label">MPG</div>
                            <div class="data-table-cell-content"><span data-number3formatter><?php echo htmlentities($tripStats->mpg); ?></span></div>
                        </div>
                        <div class="ppg data-table-cell">
                            <div class="data-table-cell-label">PPG</div>
                            <div class="data-table-cell-content"><span data-money3formatter><?php echo htmlentities($tripStats->ppg); ?></span></div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>