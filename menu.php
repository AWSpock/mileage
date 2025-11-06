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
            <?php
            if (isset($vehicle_id) && $vehicle->id() == $vehicle_id) {
            ?>
                <ul>
                    <li><a href="/vehicle/<?php echo $vehicle->id(); ?>/fillup"><i></i>Fillups</a></li>
                    <li><a href="/vehicle/<?php echo $vehicle->id(); ?>/maintenance"><i></i>Maintenance</a></li>
                    <li><a href="/vehicle/<?php echo $vehicle->id(); ?>/trip"><i></i>Trips</a></li>
                </ul>
            <?php
            }
            ?>
        </li>
<?php
    }
}
