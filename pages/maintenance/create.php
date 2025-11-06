<div class="header">
    <h1>Add Maintenance</h1>
</div>

<nav class="breadcrumbs">
    <ul>
        <li><a href="/">Vehiclees</a></li>
        <li><a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/summary"><?php echo htmlentities($recVehicle->name()); ?></a></li>
        <li><a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/maintenance">Maintenances</a></li>
        <li>Add</li>
    </ul>
</nav>

<div class="content">
    <form method="post" action="" id="frm" class="form-group main-form">
        <div class="input-group">
            <label for="maintenance.date" class="form-control">Date</label>
            <input type="date" id="maintenance.date" name="maintenance.date" class="form-control" required="required" value="<?php echo htmlentities($recMaintenance->date()); ?>" />
        </div>
        <div class="input-group">
            <label for="maintenance.odometer" class="form-control">Odometer</label>
            <input type="number" id="maintenance.odometer" name="maintenance.odometer" class="form-control" required="required" value="<?php echo htmlentities($recMaintenance->odometer()); ?>" min="1" step="1" />
        </div>
        <div class="input-group">
            <label for="maintenance.price" class="form-control">Price</label>
            <input type="number" id="maintenance.price" name="maintenance.price" class="form-control" required="required" value="<?php echo htmlentities($recMaintenance->price()); ?>" step=".01" min="0" />
        </div>
        <div class="input-group">
            <label for="maintenance.description" class="form-control">Description</label>
            <textarea id="maintenance.description" name="maintenance.description" class="form-control" required="required"><?php echo htmlentities($recMaintenance->description()); ?></textarea>
        </div>
        <div class="input-group">
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
        <div class="button-group">
            <button type="submit" class="button primary"><i class="fa-solid fa-save"></i>Save</button>
            <a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/maintenance" class="button secondary"><i class="fa-solid fa-ban"></i>Cancel</a>
        </div>
    </form>
</div>