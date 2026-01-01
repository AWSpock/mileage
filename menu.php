<?php

if ($userAuth->checkToken()) {
    $favorite = null;
    foreach ($data->vehicles($userAuth->user()->id())->getRecords() as $vehicle) {
        if (is_null($favorite)) {
            $favorite = true;
?>
            <div class="menu-title">Favorites</div>
        <?php
        }
        if ($vehicle->favorite() === "No" && $favorite) {
            $favorite = false;
        ?>
            <div class="menu-title">Others</div>
        <?php
        }
        ?>
        <li>
            <a href="/vehicle/<?php echo $vehicle->id(); ?>/summary"><i class="fa-solid fa-car-side"></i><?php echo htmlentities($vehicle->name()); ?></a>
        </li>
        <?php
            if (isset($vehicle_id) && $vehicle->id() == $vehicle_id) {
            ?>
                <!-- <ul> -->
                    <li class="menu-sub"><a href="/vehicle/<?php echo $vehicle->id(); ?>/fillup"><i class="fa-solid fa-gas-pump"></i>Fillups</a></li>
                    <li class="menu-sub"><a href="/vehicle/<?php echo $vehicle->id(); ?>/maintenance"><i class="fa-solid fa-screwdriver-wrench"></i>Maintenance</a></li>
                    <li class="menu-sub"><a href="/vehicle/<?php echo $vehicle->id(); ?>/reminder"><i class="fa-solid fa-alarm-clock"></i>Reminders</a></li>
                    <li class="menu-sub"><a href="/vehicle/<?php echo $vehicle->id(); ?>/trip"><i class="fa-solid fa-suitcase"></i>Trips</a></li>
                <!-- </ul> -->
            <?php
            }
            ?>
<?php
    }
}
