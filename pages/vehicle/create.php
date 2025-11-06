<div class="header">
    <h1>Add Vehicle</h1>
</div>

<nav class="breadcrumbs">
    <ul>
        <li><a href="/">Vehicles</a></li>
        <li>Add Vehicle</li>
    </ul>
</nav>

<div class="content">
    <form method="post" action="" id="frm" class="form-group full-form">
        <div class="group-one">
            <h2>Vehicle Info</h2>
            <div class="input-group">
                <label for="vehicle.name" class="form-control">Name</label>
                <input type="text" id="vehicle.name" name="vehicle.name" class="form-control" required="required" value="<?php echo htmlentities($recVehicle->name()); ?>" />
            </div>
            <div class="input-group">
                <label for="vehicle.make" class="form-control">Make</label>
                <input type="text" id="vehicle.make" name="vehicle.make" class="form-control" required="required" value="<?php echo htmlentities($recVehicle->make()); ?>" />
            </div>
            <div class="input-group">
                <label for="vehicle.model" class="form-control">Model</label>
                <input type="text" id="vehicle.model" name="vehicle.model" class="form-control" required="required" value="<?php echo htmlentities($recVehicle->model()); ?>" />
            </div>
            <div class="input-group">
                <label for="vehicle.year" class="form-control">Year</label>
                <input type="text" id="vehicle.year" name="vehicle.year" class="form-control" required="required" value="<?php echo htmlentities($recVehicle->year()); ?>" />
            </div>
            <div class="input-group">
                <label for="vehicle.color" class="form-control">Color</label>
                <input type="text" id="vehicle.color" name="vehicle.color" class="form-control" value="<?php echo htmlentities($recVehicle->color()); ?>" />
            </div>
            <div class="input-group">
                <label for="vehicle.tank_capacity" class="form-control">Tank Capacity</label>
                <input type="text" id="vehicle.tank_capacity" name="vehicle.tank_capacity" class="form-control" required="required" value="<?php echo htmlentities($recVehicle->tank_capacity()); ?>" />
            </div>
        </div>
        <div class="group-two">
            <h2>Purchase Info</h2>
            <div class="input-group">
                <label for="vehicle.purchase_date" class="form-control">Purchase Date</label>
                <input type="date" id="vehicle.purchase_date" name="vehicle.purchase_date" class="form-control" value="<?php echo htmlentities($recVehicle->purchase_date()); ?>" />
            </div>
            <div class="input-group">
                <label for="vehicle.purchase_price" class="form-control">Purchase Price</label>
                <input type="number" id="vehicle.purchase_price" name="vehicle.purchase_price" class="form-control" min="0" step=".01" value="<?php echo htmlentities($recVehicle->purchase_price()); ?>" />
            </div>
            <div class="input-group">
                <label for="vehicle.purchase_odometer" class="form-control">Purchase Odometer</label>
                <input type="number" id="vehicle.purchase_odometer" name="vehicle.purchase_odometer" class="form-control" min="0" step="1" value="<?php echo htmlentities($recVehicle->purchase_odometer()); ?>" />
            </div>
        </div>
        <div class="button-group">
            <button type="submit" class="button primary"><i class="fa-solid fa-save"></i>Save</button>
            <a href="/" class="button secondary"><i class="fa-solid fa-ban"></i>Cancel</a>
        </div>
    </form>
</div>