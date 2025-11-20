<div class="header">
    <h1>Delete Trip Checkpoint</h1>
</div>

<nav class="breadcrumbs">
    <ul>
        <li><a href="/">Vechiles</a></li>
        <li><a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/summary"><?php echo htmlentities($recVehicle->name()); ?></a></li>
        <li><a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/trip">Trips</a></li>
        <li><a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/trip/<?php echo htmlentities($recVehicle->id()); ?>/summary">Trip: <span><?php echo htmlentities($recTrip->name()); ?></span></a></li>
        <li><a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/trip/<?php echo htmlentities($recTrip->id()); ?>/checkpoint">Checkpoints</a></li>
        <li><a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/trip/<?php echo htmlentities($recTrip->id()); ?>/checkpoint/<?php echo htmlentities($recTripCheckpoint->id()); ?>/edit">Edit</a></li>
        <li>Delete</li>
    </ul>
</nav>

<div class="content">
    <form method="post" action="" id="frm" class="form-group main-form">
        <input type="hidden" id="trip_checkpoint.id" name="trip_checkpoint.id" value="<?php echo htmlentities($recTripCheckpoint->id()); ?>" />
        <p>Are you sure you wish to delete this Trip Checkpoint?</p>
        <div class="input-group">
            <label class="form-control">Date</label>
            <div><samp data-dateonlyformatter><?php echo htmlentities($recTripCheckpoint->date()); ?></samp></div>
        </div>
        <div class="input-group">
            <label class="form-control">Odometer</label>
            <div><samp data-numberformatter><?php echo htmlentities($recTripCheckpoint->odometer()); ?></samp></div>
        </div>
        <div class="input-group">
            <label class="form-control">Description</label>
            <div><samp><?php echo htmlentities($recTripCheckpoint->description()); ?></samp></div>
        </div>
        <div class="input-group">
            <label class="form-control">Updated</label>
            <div><samp data-dateformatter><?php echo htmlentities($recTripCheckpoint->updated()); ?></samp></div>
        </div>
        <div class="input-group">
            <label class="form-control">Created</label>
            <div><samp data-dateformatter><?php echo htmlentities($recTripCheckpoint->created()); ?></samp></div>
        </div>
        <div class="button-group">
            <button type="submit" class="button remove"><i class="fa-solid fa-trash"></i>Confirm Delete</button>
            <a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/trip/<?php echo htmlentities($recTrip->id()); ?>/checkpoint/<?php echo htmlentities($recTripCheckpoint->id()); ?>/edit" class="button secondary"><i class="fa-solid fa-ban"></i>Cancel</a>
        </div>
    </form>
</div>