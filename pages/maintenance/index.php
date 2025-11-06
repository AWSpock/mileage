<div class="header">
	<h1>Vehicle Maintenances</h1>
</div>

<nav class="breadcrumbs">
	<ul>
		<li><a href="/">Vehicles</a></li>
		<li><a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/summary"><?php echo htmlentities($recVehicle->name()); ?></a></li>
		<li>Maintenances</li>
	</ul>
</nav>

<div class="content">
	<div class="row">
		<a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/maintenance/create" class="button primary"><i class="fa-solid fa-plus"></i>Add Maintenance</a>
	</div>
	<div class="row">
		<p>Record Count: <span id="data-table-count">?</span></p>
		<div class="data-table" id="data-table">
			<div class="data-table-row header-row">
				<div class="data-table-cell header-cell" data-id="date">
					<div class="data-table-cell-label">Date</div>
				</div>
				<div class="data-table-cell header-cell" data-id="odometer">
					<div class="data-table-cell-label">Odometer</div>
				</div>
				<div class="data-table-cell header-cell" data-id="price">
					<div class="data-table-cell-label">Price</div>
				</div>
				<div class="data-table-cell header-cell" data-id="description">
					<div class="data-table-cell-label">Description</div>
				</div>
				<div class="data-table-cell header-cell" data-id="garage">
					<div class="data-table-cell-label">Garage</div>
				</div>
				<div class="data-table-cell header-cell" data-id="created">
					<div class="data-table-cell-label">Created</div>
				</div>
				<div class="data-table-cell header-cell" data-id="updated">
					<div class="data-table-cell-label">Updated</div>
				</div>
			</div>
		</div>
	</div>
</div>

<template id="template">
	<a href="/vehicle/VEHICLE_ID/maintenance/FILLUP_ID/edit" class="data-table-row">
		<div class="data-table-cell" data-id="date">
			<div class="data-table-cell-label">Date</div>
			<div class="data-table-cell-content" data-dateonlyformatter></div>
		</div>
		<div class="data-table-cell" data-id="odometer">
			<div class="data-table-cell-label">Odometer</div>
			<div class="data-table-cell-content" data-numberformatter></div>
		</div>
		<div class="data-table-cell header-cell" data-id="price">
			<div class="data-table-cell-label">Price</div>
			<div class="data-table-cell-content" data-moneyformatter></div>
		</div>
		<div class="data-table-cell header-cell" data-id="description">
			<div class="data-table-cell-label">Description</div>
			<div class="data-table-cell-content"></div>
		</div>
		<div class="data-table-cell header-cell" data-id="garage">
			<div class="data-table-cell-label">Garage</div>
			<div class="data-table-cell-content"></div>
		</div>
		<div class="data-table-cell" data-id="created">
			<div class="data-table-cell-label">Create</div>
			<div class="data-table-cell-content" data-dateformatter></div>
		</div>
		<div class="data-table-cell" data-id="updated">
			<div class="data-table-cell-label">Updated</div>
			<div class="data-table-cell-content" data-dateformatter></div>
		</div>
	</a>
</template>