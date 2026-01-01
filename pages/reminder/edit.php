<div class="header">
    <h1>Edit Reminder</h1>
</div>

<nav class="breadcrumbs">
    <ul>
        <li><a href="/">Vehicles</a></li>
        <li><a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/summary"><?php echo htmlentities($recVehicle->name()); ?></a></li>
        <li><a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/reminder">Reminders</a></li>
        <li>Edit: <span><?php echo htmlentities($recReminder->name()); ?></span></li>
    </ul>
</nav>

<div class="content">
    <form method="post" action="" id="frm" class="form-group main-form">
        <input type="hidden" id="reminder.id" name="reminder.id" value="<?php echo htmlentities($recReminder->id()); ?>" />
        <div class="input-group name">
            <label for="reminder.name" class="form-control">Name</label>
            <input type="text" id="reminder.name" name="reminder.name" class="form-control" required="required" value="<?php echo htmlentities($recReminder->name()); ?>" />
        </div>
        <div class="input-group description">
            <label for="reminder.description" class="form-control">Description</label>
            <textarea id="reminder.description" name="reminder.description" class="form-control" required="required"><?php echo htmlentities($recReminder->description()); ?></textarea>
        </div>
        <div class="input-group due_months">
            <label for="reminder.due_months" class="form-control">Due Months</label>
            <input type="number" id="reminder.due_months" name="reminder.due_months" class="form-control" value="<?php echo htmlentities($recReminder->due_months()); ?>" min="0" step="1" />
        </div>
        <div class="input-group due_miles">
            <label for="reminder.due_miles" class="form-control">Due Miles</label>
            <input type="number" id="reminder.due_miles" name="reminder.due_miles" class="form-control" value="<?php echo htmlentities($recReminder->due_miles()); ?>" min="0" step="1" />
        </div>
        <div class="input-group due_date">
            <label for="reminder.due_date" class="form-control">Due Date</label>
            <input type="date" id="reminder.due_date" name="reminder.due_date" class="form-control" value="<?php echo htmlentities($recReminder->due_date()); ?>" />
        </div>
        <div class="input-group due_odometer">
            <label for="reminder.due_odometer" class="form-control">Due Odometer</label>
            <input type="number" id="reminder.due_odometer" name="reminder.due_odometer" class="form-control" value="<?php echo htmlentities($recReminder->due_odometer()); ?>" min="0" step="1" />
        </div>
        <div class="button-group">
            <button type="submit" class="button primary"><i class="fa-solid fa-save"></i>Save</button>
            <?php
            if ($maintenance_id !== null) {
            ?>
                <a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/maintenance/<?php echo htmlentities($maintenance_id); ?>/edit" class="button secondary"><i class="fa-solid fa-ban"></i>Cancel</a>
            <?php
            } else {
            ?>
                <a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/reminder" class="button secondary"><i class="fa-solid fa-ban"></i>Cancel</a>
                <a href="/vehicle/<?php echo htmlentities($recVehicle->id()); ?>/reminder/<?php echo htmlentities($recReminder->id()); ?>/delete" class="button remove"><i class="fa-solid fa-trash"></i>Delete?</a>
            <?php
            }
            ?>
        </div>
        <div class="input-group updated">
            <label class="form-control">Updated</label>
            <div><samp data-dateformatter><?php echo htmlentities($recReminder->updated()); ?></samp></div>
        </div>
        <div class="input-group created">
            <label class="form-control">Created</label>
            <div><samp data-dateformatter><?php echo htmlentities($recReminder->created()); ?></samp></div>
        </div>
    </form>
</div>