<div class="header">
    <h1>Vehicle Summary</h1>
</div>

<nav class="breadcrumbs">
    <ul>
        <li><a href="/">Vehicles</a></li>
        <li><?php echo htmlentities($recVehicle->name()); ?></li>
    </ul>
</nav>

<div class="content">
    <div class="row">
        <div class="options">
            <form method="post" action="" id="frm" class="inline">
                <?php
                if ($recVehicle->favorite() == "No") {
                ?>
                    <button type="submit" name="vehicle.favorite" value="Yes" class="link secondary" title="Add Favorite"><i class="fa-regular fa-star"></i></button>
                <?php
                } else {
                ?>
                    <button type="submit" name="vehicle.favorite" value="No" class="link secondary" title="Remove Favorite"><i class="fa-solid fa-star"></i></button>
                <?php
                }
                ?>
            </form>
            <?php
            if ($recVehicle->isOwner()) {
            ?>
                <a href="/vehicle/<?php echo htmlentities($vehicle_id); ?>/edit" class="button secondary"><i class="fa-solid fa-pencil"></i>Edit Vehicle</a>
            <?php
            }
            ?>
        </div>
    </div>

    <div class="row">
        <h2><?php echo $recVehicle->name(); ?></h2>
        <div class="vehicle-info">
            <div class="info">
                <label class="form-control">Make</label>
                <div><samp><?php echo htmlentities($recVehicle->make()); ?></samp></div>
            </div>
            <div class="info">
                <label class="form-control">Model</label>
                <div><samp><?php echo htmlentities($recVehicle->model()); ?></samp></div>
            </div>
            <div class="info">
                <label class="form-control">Color</label>
                <div><samp><?php echo htmlentities($recVehicle->color()); ?></samp></div>
            </div>
            <div class="info">
                <label class="form-control">Tank Capacity</label>
                <div><samp data-number1formatter><?php echo htmlentities($recVehicle->tank_capacity()); ?></samp></div>
            </div>
        </div>
        <h3>Purchase Information</h3>
        <div class="vehicle-purchase">
            <div class="info date">
                <label class="form-control">Date</label>
                <div><samp data-dateonlyformatter><?php echo htmlentities($recVehicle->purchase_date()); ?></samp></div>
            </div>
            <div class="info">
                <label class="form-control">Price</label>
                <div><samp data-moneyformatter><?php echo htmlentities($recVehicle->purchase_price()); ?></samp></div>
            </div>
            <div class="info">
                <label class="form-control">Odometer</label>
                <div><samp data-numberformatter><?php echo htmlentities($recVehicle->purchase_odometer()); ?></samp></div>
            </div>
        </div>
        <?php
        if ($recVehicle->sell_odometer() != null) {
        ?>
            <h3>Sell Information</h3>
            <div class="vehicle-sell">
                <div class="info date">
                    <label class="form-control">Date</label>
                    <div><samp data-dateonlyformatter><?php echo htmlentities($recVehicle->sell_date()); ?></samp></div>
                </div>
                <div class="info">
                    <label class="form-control">Price</label>
                    <div><samp data-moneyformatter><?php echo htmlentities($recVehicle->sell_price()); ?></samp></div>
                </div>
                <div class="info">
                    <label class="form-control">Odometer</label>
                    <div><samp data-numberformatter><?php echo htmlentities($recVehicle->sell_odometer()); ?></samp></div>
                </div>
            </div>
        <?php
        }
        ?>

        <h2>Fillup Stats</h2>
        <div class="fillup-stats">
            <div class="mpg stats">
                <h3>MPG</h3>
                <div class="gauges">
                    <div class="info__block selected" data-id="last">
                        <div class="gauge">
                            <div class="gauge__body">
                                <div class="gauge__fill" style="transform: rotate(<?php echo returnPercentage(end($summary->MPG), min($summary->MPG), max($summary->MPG)); ?>turn);"></div>
                                <div class="gauge__cover primary">
                                    <div class="gauge__mid"><span data-number3formatter><?php echo end($summary->MPG); ?></span></div>
                                </div>
                            </div>
                            <div class="gauge__title">Last</div>
                        </div>
                        <div class="gaugeLabelBottom">
                            <div><span data-number3formatter><?php echo min($summary->MPG); ?></span></div>
                            <div><span data-number3formatter><?php echo max($summary->MPG); ?></span></div>
                        </div>
                    </div>
                    <div class="info__block selected" data-id="avg">
                        <div class="gauge">
                            <div class="gauge__body">
                                <div class="gauge__fill" style="transform: rotate(<?php echo returnPercentage($summary->AvgMPG, min($summary->MPG), max($summary->MPG)); ?>turn);"></div>
                                <div class="gauge__cover primary">
                                    <div class="gauge__mid"><span data-number3formatter><?php echo $summary->AvgMPG; ?></span></div>
                                </div>
                            </div>
                            <div class="gauge__title">Avg</div>
                        </div>
                        <div class="gaugeLabelBottom">
                            <div><span data-number3formatter><?php echo min($summary->MPG); ?></span></div>
                            <div><span data-number3formatter><?php echo max($summary->MPG); ?></span></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="gallon stats">
                <h3>Price</h3>
                <div class="gauges">
                    <div class="info__block selected" data-id="last">
                        <div class="gauge">
                            <div class="gauge__body">
                                <div class="gauge__fill" style="transform: rotate(<?php echo returnPercentage(end($summary->PRI), min($summary->PRI), max($summary->PRI)); ?>turn);"></div>
                                <div class="gauge__cover primary">
                                    <div class="gauge__mid"><span data-moneyformatter><?php echo end($summary->PRI); ?></span></div>
                                </div>
                            </div>
                            <div class="gauge__title">Last</div>
                        </div>
                        <div class="gaugeLabelBottom">
                            <div><span data-moneyformatter><?php echo min($summary->PRI); ?></span></div>
                            <div><span data-moneyformatter><?php echo max($summary->PRI); ?></span></div>
                        </div>
                    </div>
                    <div class="info__block selected" data-id="avg">
                        <div class="gauge">
                            <div class="gauge__body">
                                <div class="gauge__fill" style="transform: rotate(<?php echo returnPercentage($summary->AvgPRI, min($summary->PRI), max($summary->PRI)); ?>turn);"></div>
                                <div class="gauge__cover primary">
                                    <div class="gauge__mid"><span data-moneyformatter><?php echo $summary->AvgPRI; ?></span></div>
                                </div>
                            </div>
                            <div class="gauge__title">Avg</div>
                        </div>
                        <div class="gaugeLabelBottom">
                            <div><span data-moneyformatter><?php echo min($summary->PRI); ?></span></div>
                            <div><span data-moneyformatter><?php echo max($summary->PRI); ?></span></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="gallon stats">
                <h3>Gallons</h3>
                <div class="gauges">
                    <div class="info__block selected" data-id="last">
                        <div class="gauge">
                            <div class="gauge__body">
                                <div class="gauge__fill" style="transform: rotate(<?php echo returnPercentage(end($summary->GAL), min($summary->GAL), max($summary->GAL)); ?>turn);"></div>
                                <div class="gauge__cover primary">
                                    <div class="gauge__mid"><span data-number3formatter><?php echo end($summary->GAL); ?></span></div>
                                </div>
                            </div>
                            <div class="gauge__title">Last</div>
                        </div>
                        <div class="gaugeLabelBottom">
                            <div><span data-number3formatter><?php echo min($summary->GAL); ?></span></div>
                            <div><span data-number3formatter><?php echo max($summary->GAL); ?></span></div>
                        </div>
                    </div>
                    <div class="info__block selected" data-id="avg">
                        <div class="gauge">
                            <div class="gauge__body">
                                <div class="gauge__fill" style="transform: rotate(<?php echo returnPercentage($summary->AvgGAL, min($summary->GAL), max($summary->GAL)); ?>turn);"></div>
                                <div class="gauge__cover primary">
                                    <div class="gauge__mid"><span data-number3formatter><?php echo $summary->AvgGAL; ?></span></div>
                                </div>
                            </div>
                            <div class="gauge__title">Avg</div>
                        </div>
                        <div class="gaugeLabelBottom">
                            <div><span data-number3formatter><?php echo min($summary->GAL); ?></span></div>
                            <div><span data-number3formatter><?php echo max($summary->GAL); ?></span></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ppg stats">
                <h3>PPG</h3>
                <div class="gauges">
                    <div class="info__block selected" data-id="last">
                        <div class="gauge">
                            <div class="gauge__body">
                                <div class="gauge__fill" style="transform: rotate(<?php echo returnPercentage(end($summary->PPG), min($summary->PPG), max($summary->PPG)); ?>turn);"></div>
                                <div class="gauge__cover primary">
                                    <div class="gauge__mid"><span data-money3formatter><?php echo end($summary->PPG); ?></span></div>
                                </div>
                            </div>
                            <div class="gauge__title">Last</div>
                        </div>
                        <div class="gaugeLabelBottom">
                            <div><span data-money3formatter><?php echo min($summary->PPG); ?></span></div>
                            <div><span data-money3formatter><?php echo max($summary->PPG); ?></span></div>
                        </div>
                    </div>
                    <div class="info__block selected" data-id="avg">
                        <div class="gauge">
                            <div class="gauge__body">
                                <div class="gauge__fill" style="transform: rotate(<?php echo returnPercentage($summary->AvgPPG, min($summary->PPG), max($summary->PPG)); ?>turn);"></div>
                                <div class="gauge__cover primary">
                                    <div class="gauge__mid"><span data-money3formatter><?php echo $summary->AvgPPG; ?></span></div>
                                </div>
                            </div>
                            <div class="gauge__title">Avg</div>
                        </div>
                        <div class="gaugeLabelBottom">
                            <div><span data-money3formatter><?php echo min($summary->PPG); ?></span></div>
                            <div><span data-money3formatter><?php echo max($summary->PPG); ?></span></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="day stats">
                <h3>Days Between Fills</h3>
                <div class="gauges">
                    <div class="info__block selected" data-id="last">
                        <div class="gauge">
                            <div class="gauge__body">
                                <div class="gauge__fill" style="transform: rotate(<?php echo returnPercentage(end($summary->DAY), min($summary->DAY), max($summary->DAY)); ?>turn);"></div>
                                <div class="gauge__cover primary">
                                    <div class="gauge__mid"><span data-numberformatter><?php echo end($summary->DAY); ?></span></div>
                                </div>
                            </div>
                            <div class="gauge__title">Last</div>
                        </div>
                        <div class="gaugeLabelBottom">
                            <div><span data-numberformatter><?php echo min($summary->DAY); ?></span></div>
                            <div><span data-numberformatter><?php echo max($summary->DAY); ?></span></div>
                        </div>
                    </div>
                    <div class="info__block selected" data-id="avg">
                        <div class="gauge">
                            <div class="gauge__body">
                                <div class="gauge__fill" style="transform: rotate(<?php echo returnPercentage($summary->AvgDAY, min($summary->DAY), max($summary->DAY)); ?>turn);"></div>
                                <div class="gauge__cover primary">
                                    <div class="gauge__mid"><span data-numberformatter><?php echo $summary->AvgDAY; ?></span></div>
                                </div>
                            </div>
                            <div class="gauge__title">Avg</div>
                        </div>
                        <div class="gaugeLabelBottom">
                            <div><span data-numberformatter><?php echo min($summary->DAY); ?></span></div>
                            <div><span data-numberformatter><?php echo max($summary->DAY); ?></span></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mile stats">
                <h3>Miles Between Fills</h3>
                <div class="gauges">
                    <div class="info__block selected" data-id="last">
                        <div class="gauge">
                            <div class="gauge__body">
                                <div class="gauge__fill" style="transform: rotate(<?php echo returnPercentage(end($summary->MIL), min($summary->MIL), max($summary->MIL)); ?>turn);"></div>
                                <div class="gauge__cover primary">
                                    <div class="gauge__mid"><span data-numberformatter><?php echo end($summary->MIL); ?></span></div>
                                </div>
                            </div>
                            <div class="gauge__title">Last</div>
                        </div>
                        <div class="gaugeLabelBottom">
                            <div><span data-numberformatter><?php echo min($summary->MIL); ?></span></div>
                            <div><span data-numberformatter><?php echo max($summary->MIL); ?></span></div>
                        </div>
                    </div>
                    <div class="info__block selected" data-id="avg">
                        <div class="gauge">
                            <div class="gauge__body">
                                <div class="gauge__fill" style="transform: rotate(<?php echo returnPercentage($summary->AvgMIL, min($summary->MIL), max($summary->MIL)); ?>turn);"></div>
                                <div class="gauge__cover primary">
                                    <div class="gauge__mid"><span data-numberformatter><?php echo $summary->AvgMIL; ?></span></div>
                                </div>
                            </div>
                            <div class="gauge__title">Avg</div>
                        </div>
                        <div class="gaugeLabelBottom">
                            <div><span data-numberformatter><?php echo min($summary->MIL); ?></span></div>
                            <div><span data-numberformatter><?php echo max($summary->MIL); ?></span></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mileperday stats">
                <h3>Miles Per Day</h3>
                <div class="mileperday-stats">
                    <div class="info">
                        <label class="form-control">Last</label>
                        <div><samp data-numberformatter><?php echo htmlentities($summary->MPD); ?></samp></div>
                    </div>
                    <div class="info">
                        <label class="form-control">Lifetime</label>
                        <div><samp data-numberformatter><?php echo htmlentities($summary->MPDLife); ?></samp></div>
                    </div>
                </div>
            </div>

            <div class="mileperyear stats">
                <h3>Miles Per Year</h3>
                <div class="mileperyear-stats">
                    <div class="info">
                        <label class="form-control">Last</label>
                        <div><samp data-numberformatter><?php echo htmlentities($summary->MPY); ?></samp></div>
                    </div>
                    <div class="info">
                        <label class="form-control">Avg</label>
                        <div><samp data-numberformatter><?php echo htmlentities($summary->MPYAvg); ?></samp></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="reminder-stats">
            <h2>Reminders</h2>
            <?php
            if (count($summary->reminders) > 0) {
            ?>
                <div class="reminders">
                    <?php
                    foreach ($summary->reminders as $reminder) {
                    ?>
                        <div class="reminder <?php echo $reminder->due; ?>">
                            <h3><?php echo $reminder->title; ?></h3>
                            <p><?php echo $reminder->description; ?></p>
                            <?php
                            if ($reminder->odom_due !== null) {
                            ?>
                                <p>Due @ <span data-numberformatter><?php echo $reminder->odom_due->due_odometer; ?></span> (in <span data-numberformatter><?php echo $reminder->odom_due->due_in; ?></span> <?php echo $reminder->odom_due->unit; ?>)</p>
                            <?php
                            }
                            if ($reminder->date_due !== null) {
                            ?>
                                <p>Due on <span data-dateonlyformatter><?php echo $reminder->date_due->due_date; ?></span> (in <span data-numberformatter><?php echo $reminder->date_due->due_in; ?></span> <?php echo $reminder->date_due->unit; ?>)</p>
                            <?php
                            }
                            ?>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            <?php
            } else {
            ?>
                <div class="alert alert-info">No Reminders Exist</div>
            <?php
            }
            ?>
        </div>
    </div>
</div>