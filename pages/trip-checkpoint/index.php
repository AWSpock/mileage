<div class="header">
	<h1>Vehicle Trip Checkpoints</h1>
</div>

<nav class="breadcrumbs">
	<ul>
		<li><a href="/">Vehicles</a></li>
        <li><a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/summary"><?php echo htmlentities($recVehicle->name()); ?></a></li>
        <li><a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/trip">Trips</a></li>
        <li><a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/trip/<?php echo htmlentities($recTrip->id()); ?>/summary">Trip: <span><?php echo htmlentities($recTrip->name()); ?></span></a></li>
        <li>Checkpoints</li>
	</ul>
</nav>

<div class="content">
	<div class="row">
		<a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/trip/<?php echo htmlentities($recTrip->id()); ?>/checkpoint/create" class="button primary"><i class="fa-solid fa-plus"></i>Add Checkpoint</a>
	</div>
	<div class="row">
		<p>Record Count: <span id="data-table-count">?</span></p>
		<div class="data-table" id="data-table">
			<div class="data-table-row header-row">
				<div class="data-table-cell header-cell" data-id="name">
					<div class="data-table-cell-label">Date</div>
				</div>
				<div class="data-table-cell header-cell" data-id="start_odometer">
					<div class="data-table-cell-label">Odometer</div>
				</div>
				<div class="data-table-cell header-cell" data-id="description">
					<div class="data-table-cell-label">Description</div>
				</div>
				<!-- <div class="data-table-cell header-cell" data-id="created">
					<div class="data-table-cell-label">Created</div>
				</div> -->
				<div class="data-table-cell header-cell" data-id="updated">
					<div class="data-table-cell-label">Updated</div>
				</div>
			</div>
		</div>
	</div>
</div>

<template id="template">
	<a href="/vehicle/VEHICLE_ID/trip/TRIP_ID/checkpoint/TRIP_CHECKPOINT_ID/edit" class="data-table-row">
		<div class="data-table-cell" data-id="date">
			<div class="data-table-cell-label">Date</div>
			<div class="data-table-cell-content" data-dateonlyformatter></div>
		</div>
		<div class="data-table-cell" data-id="odometer">
			<div class="data-table-cell-label">Odometer</div>
			<div class="data-table-cell-content" data-numberformatter></div>
		</div>
		<div class="data-table-cell" data-id="description">
			<div class="data-table-cell-label">Description</div>
			<div class="data-table-cell-content"></div>
		</div>
		<!-- <div class="data-table-cell" data-id="created">
			<div class="data-table-cell-label">Create</div>
			<div class="data-table-cell-content" data-dateformatter></div>
		</div> -->
		<div class="data-table-cell" data-id="updated">
			<div class="data-table-cell-label">Updated</div>
			<div class="data-table-cell-content" data-dateformatter></div>
		</div>
	</a>
</template>