<div class="header">
    <h1>Delete Vehicle</h1>
</div>

<nav class="breadcrumbs">
    <ul>
        <li><a href="/">Vehicles</a></li>
        <li><a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/summary"><?php echo htmlentities($recVehicle->name()); ?></a></li>
        <li><a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/edit">Edit</a></li>
        <li>Delete</li>
    </ul>
</nav>

<div class="content">
    <form method="post" action="" id="frm" class="form-group main-form">
        <input type="hidden" id="vehicle.id" name="vehicle.id" value="<?php echo htmlentities($recVehicle->id()); ?>" />
        <p>Are you sure you wish to delete this Vehicle?</p>
        <div class="input-group">
            <label class="form-control">Name</label>
            <div><samp><?php echo htmlentities($recVehicle->name()); ?></samp></div>
        </div>
        <div class="input-group">
            <label class="form-control">Make</label>
            <div><samp><?php echo htmlentities($recVehicle->make()); ?></samp></div>
        </div>
        <div class="input-group">
            <label class="form-control">Model</label>
            <div><samp><?php echo htmlentities($recVehicle->model()); ?></samp></div>
        </div>
        <div class="input-group">
            <label class="form-control">Year</label>
            <div><samp><?php echo htmlentities($recVehicle->year()); ?></samp></div>
        </div>
        <div class="input-group">
            <label class="form-control">Color</label>
            <div><samp><?php echo htmlentities($recVehicle->color()); ?></samp></div>
        </div>
        <div class="input-group">
            <label class="form-control">Tank Capacity</label>
            <div><samp data-numberformatter><?php echo htmlentities($recVehicle->tank_capacity()); ?></samp></div>
        </div>
        <div class="input-group">
            <label class="form-control">Purchase Date</label>
            <div><samp data-dateonlyformatter><?php echo htmlentities($recVehicle->purchase_date()); ?></samp></div>
        </div>
        <div class="input-group">
            <label class="form-control">Purchase Price</label>
            <div><samp data-moneyformatter><?php echo htmlentities($recVehicle->purchase_price()); ?></samp></div>
        </div>
        <div class="input-group">
            <label class="form-control">Purchase Odometer</label>
            <div><samp data-numberformatter><?php echo htmlentities($recVehicle->purchase_odometer()); ?></samp></div>
        </div>
        <div class="input-group">
            <label class="form-control">Sell Date</label>
            <div><samp data-dateonlyformatter><?php echo htmlentities($recVehicle->sell_date()); ?></samp></div>
        </div>
        <div class="input-group">
            <label class="form-control">Sell Price</label>
            <div><samp data-moneyformatter><?php echo htmlentities($recVehicle->sell_price()); ?></samp></div>
        </div>
        <div class="input-group">
            <label class="form-control">Sell Odometer</label>
            <div><samp data-numberformatter><?php echo htmlentities($recVehicle->sell_odometer()); ?></samp></div>
        </div>
        <!--<div class="input-group">
            <label class="form-control">Bill Types</label>
            <div><samp><?php //echo htmlentities(count($recVehicle->bill_types())); ?></samp></div>
        </div>-->
        <div class="button-group">
            <button type="submit" class="button remove"><i class="fa-solid fa-trash"></i>Confirm Delete</button>
            <a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/edit" class="button secondary"><i class="fa-solid fa-ban"></i>Cancel</a>
        </div>
    </form>
</div>