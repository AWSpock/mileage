<div class="header">
    <h1>Add Fillup</h1>
</div>

<nav class="breadcrumbs">
    <ul>
        <li><a href="/">Vehiclees</a></li>
        <li><a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/summary"><?php echo htmlentities($recVehicle->name()); ?></a></li>
        <li><a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/fillup">Fillups</a></li>
        <li>Add</li>
    </ul>
</nav>

<div class="content">
    <form method="post" action="" id="frm" class="form-group main-form">
        <div class="input-group date">
            <label for="fillup.date" class="form-control">Date</label>
            <input type="date" id="fillup.date" name="fillup.date" class="form-control" required="required" value="<?php echo htmlentities($recFillup->date()); ?>" />
        </div>
        <div class="input-group odometer">
            <label for="fillup.odometer" class="form-control">Odometer</label>
            <input type="number" id="fillup.odometer" name="fillup.odometer" class="form-control" required="required" value="<?php echo htmlentities($recFillup->odometer()); ?>" min="1" step="1" />
        </div>
        <div class="input-group station">
            <label for="fillup.station" class="form-control">Station</label>
            <input type="text" id="fillup.station" name="fillup.station" class="form-control" required="required" value="<?php echo htmlentities($recFillup->station()); ?>" list="station-list" />
            <datalist id="station-list">
                <?php
                foreach ($stations as $station) {
                ?>
                    <option value="<?php echo htmlentities($station); ?>"></option>
                <?php
                }
                ?>
            </datalist>
        </div>
        <div class="input-group ppg">
            <label for="fillup.ppg" class="form-control">PPG</label>
            <input type="number" id="fillup.ppg" name="fillup.ppg" class="form-control" required="required" value="<?php echo htmlentities($recFillup->ppg()); ?>" step=".001" min="0" />
        </div>
        <div class="input-group gallon">
            <label for="fillup.gallon" class="form-control">Gallon</label>
            <input type="number" id="fillup.gallon" name="fillup.gallon" class="form-control" required="required" value="<?php echo htmlentities($recFillup->gallon()); ?>" step=".001" min="0" />
        </div>
        <div class="input-group partial">
            <label for="fillup.partial" class="form-control">Partial</label>
            <select id="fillup.partial" name="fillup.partial" class="form-control" required="required">
                <option value="0" <?php echo ($recFillup->partial() ? "" : "selected"); ?>>No</option>
                <option value="1" <?php echo ($recFillup->partial() ? "selected" : ""); ?>>Yes</option>
            </select>
        </div>
        <div class="input-group missed">
            <label for="fillup.missed" class="form-control">Missed</label>
            <select id="fillup.missed" name="fillup.missed" class="form-control" required="required">
                <option value="0" <?php echo ($recFillup->missed() ? "" : "selected"); ?>>No</option>
                <option value="1" <?php echo ($recFillup->missed() ? "selected" : ""); ?>>Yes</option>
            </select>
        </div>
        <div class="button-group">
            <button type="submit" class="button primary"><i class="fa-solid fa-save"></i>Save</button>
            <a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/fillup" class="button secondary"><i class="fa-solid fa-ban"></i>Cancel</a>
        </div>
    </form>
</div>