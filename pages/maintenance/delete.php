<div class="header">
    <h1>Delete Maintenance</h1>
</div>

<nav class="breadcrumbs">
    <ul>
        <li><a href="/">Vechiles</a></li>
        <li><a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/summary"><?php echo htmlentities($recVehicle->name()); ?></a></li>
        <li><a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/maintenance">Maintenances</a></li>
        <li><a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/maintenance/<?php echo htmlentities($recMaintenance->id()); ?>/edit">Edit: <span data-dateonlyformatter><?php echo htmlentities($recMaintenance->date()); ?></span> - <span data-numberformatter><?php echo htmlentities($recMaintenance->odometer()); ?></span></a></li>
        <li>Delete</li>
    </ul>
</nav>

<div class="content">
    <form method="post" action="" id="frm" class="form-group main-form">
        <input type="hidden" id="maintenance.id" name="maintenance.id" value="<?php echo htmlentities($recMaintenance->id()); ?>" />
        <p>Are you sure you wish to delete this Maintenance?</p>
        <div class="input-group">
            <label class="form-control">Date</label>
            <div><samp><?php echo htmlentities($recMaintenance->date()); ?></samp></div>
        </div>
        <div class="input-group">
            <label class="form-control">Odometer</label>
            <div><samp data-numberformatter><?php echo htmlentities($recMaintenance->odometer()); ?></samp></div>
        </div>
        <div class="input-group">
            <label class="form-control">Price</label>
            <div><samp data-moneyformatter><?php echo htmlentities($recMaintenance->price()); ?></samp></div>
        </div>
        <div class="input-group">
            <label class="form-control">Description</label>
            <div><samp><?php echo htmlentities($recMaintenance->description()); ?></samp></div>
        </div>
        <div class="input-group">
            <label class="form-control">Garage</label>
            <div><samp><?php echo htmlentities($recMaintenance->garage()); ?></samp></div>
        </div>
        <div class="button-group">
            <button type="submit" class="button remove"><i class="fa-solid fa-trash"></i>Confirm Delete</button>
            <a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/maintenance/<?php echo htmlentities($recMaintenance->id()); ?>/edit" class="button secondary"><i class="fa-solid fa-ban"></i>Cancel</a>
        </div>
    </form>
</div>