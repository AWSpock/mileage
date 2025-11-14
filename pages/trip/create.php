<div class="header">
    <h1>Add Trip</h1>
</div>

<nav class="breadcrumbs">
    <ul>
        <li><a href="/">Vehiclees</a></li>
        <li><a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/summary"><?php echo htmlentities($recVehicle->name()); ?></a></li>
        <li><a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/trip">Trips</a></li>
        <li>Add</li>
    </ul>
</nav>

<div class="content">
    <form method="post" action="" id="frm" class="form-group main-form">
        <div class="input-group name">
            <label for="trip.name" class="form-control">Name</label>
            <input type="text" id="trip.name" name="trip.name" class="form-control" required="required" value="<?php echo htmlentities($recTrip->name()); ?>" />
        </div>
        <div class="input-group description">
            <label for="trip.description" class="form-control">Description</label>
            <textarea id="trip.description" name="trip.description" class="form-control" required="required"><?php echo htmlentities($recTrip->description()); ?></textarea>
        </div>
        <!-- <div class="input-group tag">
            <label for="trip.tag" class="form-control">Station</label>
            <input type="text" id="trip.tag" name="trip.tag" class="form-control" required="required" value="<?php //echo htmlentities($recTrip->tag()); ?>" list="tag-list" />
            <datalist id="tag-list">
                <?php
                /* foreach ($tags as $tag) {
                ?>
                    <option value="<?php echo htmlentities($tag); ?>"></option>
                <?php
                } */
                ?>
            </datalist>
        </div> -->
        <div class="button-group">
            <button type="submit" class="button primary"><i class="fa-solid fa-save"></i>Save</button>
            <a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/trip" class="button secondary"><i class="fa-solid fa-ban"></i>Cancel</a>
        </div>
    </form>
</div>