<div class="header">
    <h1>Edit Maintenance</h1>
</div>

<nav class="breadcrumbs">
    <ul>
        <li><a href="/">Vehicles</a></li>
        <li><a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/summary"><?php echo htmlentities($recVehicle->name()); ?></a></li>
        <li><a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/maintenance">Maintenances</a></li>
        <li>Edit: <span data-dateonlyformatter><?php echo htmlentities($recMaintenance->date()); ?></span> - <span data-numberformatter><?php echo htmlentities($recMaintenance->odometer()); ?></span></li>
    </ul>
</nav>

<div class="content">
    <form method="post" action="" id="frm" class="form-group main-form">
        <input type="hidden" id="maintenance.id" name="maintenance.id" value="<?php echo htmlentities($recMaintenance->id()); ?>" />
        <div class="input-group date">
            <label for="maintenance.date" class="form-control">Date</label>
            <input type="date" id="maintenance.date" name="maintenance.date" class="form-control" required="required" value="<?php echo htmlentities($recMaintenance->date()); ?>" />
        </div>
        <div class="input-group odometer">
            <label for="maintenance.odometer" class="form-control">Odometer</label>
            <input type="number" id="maintenance.odometer" name="maintenance.odometer" class="form-control" required="required" value="<?php echo htmlentities($recMaintenance->odometer()); ?>" min="1" step="1" />
        </div>
        <div class="input-group garage">
            <label for="maintenance.garage" class="form-control">Garage</label>
            <input type="text" id="maintenance.garage" name="maintenance.garage" class="form-control" required="required" value="<?php echo htmlentities($recMaintenance->garage()); ?>" list="garage-list" />
            <datalist id="garage-list">
                <?php
                foreach ($garages as $garage) {
                ?>
                    <option value="<?php echo htmlentities($garage); ?>"></option>
                <?php
                }
                ?>
            </datalist>
        </div>
        <div class="input-group price">
            <label for="maintenance.price" class="form-control">Price</label>
            <input type="number" id="maintenance.price" name="maintenance.price" class="form-control" required="required" value="<?php echo htmlentities($recMaintenance->price()); ?>" step=".01" min="0" />
        </div>
        <div class="input-group description">
            <label for="maintenance.description" class="form-control">Description</label>
            <textarea id="maintenance.description" name="maintenance.description" class="form-control" required="required"><?php echo htmlentities($recMaintenance->description()); ?></textarea>
        </div>
        <div class="button-group">
            <button type="submit" class="button primary"><i class="fa-solid fa-save"></i>Save</button>
            <a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/maintenance" class="button secondary"><i class="fa-solid fa-ban"></i>Cancel</a>
            <a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/maintenance/<?php echo htmlentities($recMaintenance->id()); ?>/delete" class="button remove"><i class="fa-solid fa-trash"></i>Delete?</a>
        </div>
        <div class="input-group updated">
            <label class="form-control">Updated</label>
            <div><samp data-dateformatter><?php echo htmlentities($recMaintenance->updated()); ?></samp></div>
        </div>
        <div class="input-group created">
            <label class="form-control">Created</label>
            <div><samp data-dateformatter><?php echo htmlentities($recMaintenance->created()); ?></samp></div>
        </div>
    </form>
</div>