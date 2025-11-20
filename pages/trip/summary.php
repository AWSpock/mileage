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
        foreach ($recTrip->trip_checkpoints() as $recTripCheckpoint) {
            // $totalUnit = 0;
        }
        echo "Trip Checkpoints: " . count($recTrip->trip_checkpoints()) . "<br>";
        echo "Fillups: " . count($fillups);
        ?>
    </div>
</div>