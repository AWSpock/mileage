<div class="header">
    <h1>Edit Fillup</h1>
</div>

<nav class="breadcrumbs">
    <ul>
        <li><a href="/">Vehicles</a></li>
        <li><a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/summary"><?php echo htmlentities($recVehicle->name()); ?></a></li>
        <li><a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/fillup">Fillups</a></li>
        <li>Edit: <span data-dateonlyformatter><?php echo htmlentities($recFillup->date()); ?></span> - <span data-numberformatter><?php echo htmlentities($recFillup->odometer()); ?></span></li>
    </ul>
</nav>

<div class="content">
    <div class="row">
        <form method="post" action="" id="frm" class="form-group main-form">
            <h2>Details</h2>
            <input type="hidden" id="fillup.id" name="fillup.id" value="<?php echo htmlentities($recFillup->id()); ?>" />
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
                <a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/fillup/<?php echo htmlentities($recFillup->id()); ?>/delete" class="button remove"><i class="fa-solid fa-trash"></i>Delete?</a>
            </div>
            <div class="input-group updated">
                <label class="form-control">Updated</label>
                <div><samp data-dateformatter><?php echo htmlentities($recFillup->updated()); ?></samp></div>
            </div>
            <div class="input-group created">
                <label class="form-control">Created</label>
                <div><samp data-dateformatter><?php echo htmlentities($recFillup->created()); ?></samp></div>
            </div>
        </form>

        <div class="stats">
            <h2>Stats</h2>
            <div class="input-group days">
                <label for="fillup.days" class="form-control">Days</label>
                <div id="fillup.days" class="form-control" data-numberformatter><?php echo htmlentities($recFillup->days()); ?></div>
            </div>
            <div class="input-group miles">
                <label for="fillup.miles" class="form-control">Miles</label>
                <div id="fillup.miles" class="form-control" data-numberformatter><?php echo htmlentities($recFillup->miles()); ?></div>
            </div>
            <div class="input-group mpd">
                <label for="fillup.mpd" class="form-control">Miles Per Day</label>
                <div id="fillup.mpd" class="form-control" data-numberformatter><?php echo htmlentities($recFillup->days() > 0 ? $recFillup->miles() / $recFillup->days() : $recFillup->miles()); ?></div>
            </div>
            <div class="input-group price">
                <label for="fillup.price" class="form-control">Price</label>
                <div id="fillup.price" class="form-control" data-moneyformatter><?php echo htmlentities($recFillup->price()); ?></div>
            </div>
            <div class="input-group ppd">
                <label for="fillup.pppdpg" class="form-control">Price Per Day</label>
                <div id="fillup.ppd" class="form-control" data-moneyformatter><?php echo htmlentities($recFillup->days() > 0 ? $recFillup->price() / $recFillup->days() : $recFillup->price()); ?></div>
            </div>
            <div class="input-group gpd">
                <label for="fillup.gpd" class="form-control">Gallons Per Day</label>
                <div id="fillup.gpd" class="form-control" data-number2formatter><?php echo htmlentities($recFillup->days() > 0 ? $recFillup->gallon() / $recFillup->days() : $recFillup->gallon()); ?></div>
            </div>
            <div class="input-group mpg">
                <label for="fillup.mpg" class="form-control">MPG</label>
                <div id="fillup.mpg" class="form-control"><?php echo htmlentities($recFillup->mpg() !== null ? $recFillup->mpg() : "NULL"); ?></div>
            </div>
            <div class="input-group ptank">
                <label for="fillup.ptank" class="form-control">% of Tank</label>
                <div id="fillup.ptank" class="form-control" data-percent1formatter><?php echo htmlentities($recFillup->gallon() / $recVehicle->tank_capacity() * 100); ?></div>
            </div>
            <div class="input-group range">
                <label for="fillup.range" class="form-control">Range</label>
                <div id="fillup.range" class="form-control" data-numberformatter><?php echo htmlentities($recFillup->mpg() * $recVehicle->tank_capacity()); ?></div>
            </div>
        </div>
    </div>
</div>