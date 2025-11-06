<div class="header">
    <h1>Delete Fillup</h1>
</div>

<nav class="breadcrumbs">
    <ul>
        <li><a href="/">Vechiles</a></li>
        <li><a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/summary"><?php echo htmlentities($recVehicle->name()); ?></a></li>
        <li><a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/fillup">Fillups</a></li>
        <li><a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/fillup/<?php echo htmlentities($recFillup->id()); ?>/edit">Edit: <span data-dateonlyformatter><?php echo htmlentities($recFillup->date()); ?></span> - <span data-numberformatter><?php echo htmlentities($recFillup->odometer()); ?></span></a></li>
        <li>Delete</li>
    </ul>
</nav>

<div class="content">
    <form method="post" action="" id="frm" class="form-group main-form">
        <input type="hidden" id="fillup.id" name="fillup.id" value="<?php echo htmlentities($recFillup->id()); ?>" />
        <p>Are you sure you wish to delete this Fillup?</p>
        <div class="input-group">
            <label class="form-control">Date</label>
            <div><samp><?php echo htmlentities($recFillup->date()); ?></samp></div>
        </div>
        <div class="input-group">
            <label class="form-control">Odometer</label>
            <div><samp data-numberformatter><?php echo htmlentities($recFillup->odometer()); ?></samp></div>
        </div>
        <div class="input-group">
            <label class="form-control">PPG</label>
            <div><samp data-money3formatter><?php echo htmlentities($recFillup->ppg()); ?></samp></div>
        </div>
        <div class="input-group">
            <label class="form-control">Gallon</label>
            <div><samp data-number3formatter><?php echo htmlentities($recFillup->gallon()); ?></samp></div>
        </div>
        <div class="input-group">
            <label class="form-control">Price</label>
            <div><samp data-moneyformatter><?php echo htmlentities($recFillup->price()); ?></samp></div>
        </div>
        <div class="input-group">
            <label class="form-control">Station</label>
            <div><samp><?php echo htmlentities($recFillup->station()); ?></samp></div>
        </div>
        <div class="input-group">
            <label class="form-control">Partial</label>
            <div><samp><?php echo htmlentities($recFillup->partial() ? "Yes" : "No"); ?></samp></div>
        </div>
        <div class="input-group">
            <label class="form-control">Missed</label>
            <div><samp><?php echo htmlentities($recFillup->missed() ? "Yes" : "No"); ?></samp></div>
        </div>
        <div class="button-group">
            <button type="submit" class="button remove"><i class="fa-solid fa-trash"></i>Confirm Delete</button>
            <a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/fillup/<?php echo htmlentities($recFillup->id()); ?>/edit" class="button secondary"><i class="fa-solid fa-ban"></i>Cancel</a>
        </div>
    </form>
</div>