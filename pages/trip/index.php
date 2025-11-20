<div class="header">
	<h1>Vehicle Trips</h1>
</div>

<nav class="breadcrumbs">
	<ul>
		<li><a href="/">Vehicles</a></li>
		<li><a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/summary"><?php echo htmlentities($recVehicle->name()); ?></a></li>
		<li>Trips</li>
	</ul>
</nav>

<div class="content">
	<div class="row">
		<a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/trip/create" class="button primary"><i class="fa-solid fa-plus"></i>Add Trip</a>
	</div>
	<div class="row">
		<p>Record Count: <span id="data-table-count">?</span></p>
		<div class="data-table" id="data-table">
			<div class="data-table-row header-row">
				<div class="data-table-cell header-cell" data-id="name">
					<div class="data-table-cell-label">Name</div>
				</div>
				<div class="data-table-cell header-cell" data-id="description">
					<div class="data-table-cell-label">Description</div>
				</div>
				<div class="data-table-cell header-cell" data-id="start_date">
					<div class="data-table-cell-label">Start Date</div>
				</div>
				<div class="data-table-cell header-cell" data-id="end_date">
					<div class="data-table-cell-label">End Date</div>
				</div>
				<div class="data-table-cell header-cell" data-id="start_odometer">
					<div class="data-table-cell-label">Start Odometer</div>
				</div>
				<div class="data-table-cell header-cell" data-id="end_odometer">
					<div class="data-table-cell-label">End Odometer</div>
				</div>
				<div class="data-table-cell header-cell" data-id="days">
					<div class="data-table-cell-label">Total Days</div>
				</div>
				<div class="data-table-cell header-cell" data-id="miles">
					<div class="data-table-cell-label">Total Miles</div>
				</div>
				<!-- <div class="data-table-cell header-cell" data-id="gallons">
					<div class="data-table-cell-label">Estimated Gallons</div>
				</div>
				<div class="data-table-cell header-cell" data-id="price">
					<div class="data-table-cell-label">Estimated Price</div>
				</div>
				<div class="data-table-cell header-cell" data-id="mpg">
					<div class="data-table-cell-label">Average MPG</div>
				</div>
				<div class="data-table-cell header-cell" data-id="ppg">
					<div class="data-table-cell-label">Average PPG</div>
				</div> -->
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
	<a href="/vehicle/VEHICLE_ID/trip/TRIP_ID/summary" class="data-table-row">
		<div class="data-table-cell" data-id="name">
			<div class="data-table-cell-label">Name</div>
			<div class="data-table-cell-content"></div>
		</div>
		<div class="data-table-cell" data-id="description">
			<div class="data-table-cell-label">Description</div>
			<div class="data-table-cell-content"></div>
		</div>
		<div class="data-table-cell" data-id="start_date">
			<div class="data-table-cell-label">Start Date</div>
			<div class="data-table-cell-content" data-dateonlyformatter></div>
		</div>
		<div class="data-table-cell" data-id="end_date">
			<div class="data-table-cell-label">End Date</div>
			<div class="data-table-cell-content" data-dateonlyformatter></div>
		</div>
		<div class="data-table-cell" data-id="start_odometer">
			<div class="data-table-cell-label">Start Odometer</div>
			<div class="data-table-cell-content" data-numberformatter></div>
		</div>
		<div class="data-table-cell" data-id="end_odometer">
			<div class="data-table-cell-label">End Odometer</div>
			<div class="data-table-cell-content" data-numberformatter></div>
		</div>
		<div class="data-table-cell" data-id="days">
			<div class="data-table-cell-label">Total Days</div>
			<div class="data-table-cell-content" data-numberformatter></div>
		</div>
		<div class="data-table-cell" data-id="miles">
			<div class="data-table-cell-label">Total Miles</div>
			<div class="data-table-cell-content" data-numberformatter></div>
		</div>
		<!-- <div class="data-table-cell header-cell" data-id="gallons">
			<div class="data-table-cell-label">Estimated Gallons</div>
			<div class="data-table-cell-content" data-money3formatter></div>
		</div>
		<div class="data-table-cell header-cell" data-id="price">
			<div class="data-table-cell-label">Estimated Price</div>
			<div class="data-table-cell-content" data-moneyformatter></div>
		</div>
		<div class="data-table-cell" data-id="mpg">
			<div class="data-table-cell-label">Average MPG</div>
			<div class="data-table-cell-content" data-number3formatter></div>
		</div>
		<div class="data-table-cell header-cell" data-id="ppg">
			<div class="data-table-cell-label">Average PPG</div>
			<div class="data-table-cell-content" data-money3formatter></div>
		</div> -->
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