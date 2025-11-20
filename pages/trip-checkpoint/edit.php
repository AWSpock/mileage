<div class="header">
    <h1>Edit Trip Checkpoint</h1>
</div>

<nav class="breadcrumbs">
    <ul>
        <li><a href="/">Vehicles</a></li>
        <li><a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/summary"><?php echo htmlentities($recVehicle->name()); ?></a></li>
        <li><a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/trip">Trips</a></li>
        <li><a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/trip/<?php echo htmlentities($recTrip->id()); ?>/summary">Trip: <span><?php echo htmlentities($recTrip->name()); ?></span></a></li>
        <li><a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/trip/<?php echo htmlentities($recTrip->id()); ?>/checkpoint">Checkpoints</a></li>
        <li>Edit</li>
    </ul>
</nav>

<div class="content">
    <form method="post" action="" id="frm" class="form-group main-form">
        <input type="hidden" id="trip_checkpoint.id" name="trip_checkpoint.id" value="<?php echo htmlentities($recTripCheckpoint->id()); ?>" />
        <div class="input-group date">
            <label for="trip_checkpoint.date" class="form-control">Date</label>
            <input type="date" id="trip_checkpoint.date" name="trip_checkpoint.date" class="form-control" required="required" value="<?php echo htmlentities($recTripCheckpoint->date()); ?>" />
        </div>
        <div class="input-group odometer">
            <label for="trip_checkpoint.odometer" class="form-control">Odometer</label>
            <input type="number" id="trip_checkpoint.odometer" name="trip_checkpoint.odometer" class="form-control" required="required" value="<?php echo htmlentities($recTripCheckpoint->odometer()); ?>" min="0" step="1" />
        </div>
        <div class="input-group description">
            <label for="trip_checkpoint.description" class="form-control">Description</label>
            <textarea id="trip_checkpoint.description" name="trip_checkpoint.description" class="form-control" required="required"><?php echo htmlentities($recTripCheckpoint->description()); ?></textarea>
        </div>
        <div class="button-group">
            <button type="submit" class="button primary"><i class="fa-solid fa-save"></i>Save</button>
            <a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/trip/<?php echo htmlentities($recTrip->id()); ?>/checkpoint" class="button secondary"><i class="fa-solid fa-ban"></i>Cancel</a>
            <a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/trip/<?php echo htmlentities($recTrip->id()); ?>/checkpoint/<?php echo htmlentities($recTripCheckpoint->id()); ?>/delete" class="button remove"><i class="fa-solid fa-trash"></i>Delete?</a>
        </div>
        <div class="input-group updated">
            <label class="form-control">Updated</label>
            <div><samp data-dateformatter><?php echo htmlentities($recTrip->updated()); ?></samp></div>
        </div>
        <div class="input-group created">
            <label class="form-control">Created</label>
            <div><samp data-dateformatter><?php echo htmlentities($recTrip->created()); ?></samp></div>
        </div>
    </form>
</div>