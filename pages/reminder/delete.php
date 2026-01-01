<div class="header">
    <h1>Delete Reminder</h1>
</div>

<nav class="breadcrumbs">
    <ul>
        <li><a href="/">Vechiles</a></li>
        <li><a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/summary"><?php echo htmlentities($recVehicle->name()); ?></a></li>
        <li><a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/reminder">Reminders</a></li>
        <li><a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/reminder/<?php echo htmlentities($recReminder->id()); ?>/edit">Edit: <span><?php echo htmlentities($recReminder->name()); ?></span></a></li>
        <li>Delete</li>
    </ul>
</nav>

<div class="content">
    <form method="post" action="" id="frm" class="form-group main-form">
        <input type="hidden" id="reminder.id" name="reminder.id" value="<?php echo htmlentities($recReminder->id()); ?>" />
        <p>Are you sure you wish to delete this Reminder?</p>
        <div class="input-group">
            <label class="form-control">Name</label>
            <div><samp><?php echo htmlentities($recReminder->name()); ?></samp></div>
        </div>
        <div class="input-group">
            <label class="form-control">Description</label>
            <div><samp><?php echo htmlentities($recReminder->description()); ?></samp></div>
        </div>
        <div class="input-group">
            <label class="form-control">Due Months</label>
            <div><samp <?php echo ($recReminder->due_date() !== NULL) ? "data-numberformatter" : ""; ?>><?php echo ($recReminder->due_date() !== NULL) ? htmlentities($recReminder->due_months()) : "NULL"; ?></samp></div>
        </div>
        <div class="input-group">
            <label class="form-control">Due Miles</label>
            <div><samp <?php echo ($recReminder->due_date() !== NULL) ? "data-numberformatter" : ""; ?>><?php echo ($recReminder->due_date() !== NULL) ? htmlentities($recReminder->due_miles()) : "NULL"; ?></samp></div>
        </div>
        <div class="input-group">
            <label class="form-control">Due Date</label>
            <div><samp <?php echo ($recReminder->due_date() !== NULL) ? "data-dateonlyformatter" : ""; ?>><?php echo ($recReminder->due_date() !== NULL) ? htmlentities($recReminder->due_date()) : "NULL"; ?></samp></div>
        </div>
        <div class="input-group">
            <label class="form-control">Due Odometer</label>
            <div><samp <?php echo ($recReminder->due_odometer() !== NULL) ? "data-numberformatter" : ""; ?>><?php echo ($recReminder->due_odometer() !== NULL) ? htmlentities($recReminder->due_odometer()) : "NULL"; ?></samp></div>
        </div>
        <div class="input-group">
            <label class="form-control">Updated</label>
            <div><samp data-dateformatter><?php echo htmlentities($recReminder->updated()); ?></samp></div>
        </div>
        <div class="input-group">
            <label class="form-control">Created</label>
            <div><samp data-dateformatter><?php echo htmlentities($recReminder->created()); ?></samp></div>
        </div>
        <div class="button-group">
            <button type="submit" class="button remove"><i class="fa-solid fa-trash"></i>Confirm Delete</button>
            <a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/reminder/<?php echo htmlentities($recReminder->id()); ?>/edit" class="button secondary"><i class="fa-solid fa-ban"></i>Cancel</a>
        </div>
    </form>
</div>