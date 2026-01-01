<?php

$vehicleData = $data->vehicles($userAuth->user()->id());

$recVehicle = $vehicleData->getRecordById($vehicle_id);
if ($recVehicle->id() < 0) {
    header('Location: /');
    die();
}
if (!($recVehicle->isOwner() || $recVehicle->isManager())) {
    header('Location: /vehicle/' . $recVehicle->id() . '/summary');
    die();
}

$reminderData = $data->reminders($recVehicle->id());
$recReminder = $reminderData->getRecordById($record_id);
if ($recReminder->id() < 0) {
    header('Location: /vehicle/' . $recVehicle->id() . '/reminder');
    die();
}

$maintenance_id = null;

//

if (!empty($_POST)) {
    $recReminder = Reminder::fromPost($_POST);
    $res = $reminderData->updateRecord($recReminder);
    $_SESSION['last_message_text'] = $reminderData->actionDataMessage;
    if ($res == 1 || $res == 2) {
        $_SESSION['last_message_type'] = "success";
        if (isset($_GET['maintenance_id'])) {
            header('Location: /vehicle/' . $recVehicle->id() . '/maintenance/' . $_GET['maintenance_id'] . '/edit');
        } else {
            header('Location: /vehicle/' . $recVehicle->id() . '/reminder');
        }
        die();
    } else {
        $_SESSION['last_message_type'] = "danger";
    }
} else {
    if (isset($_GET['maintenance_id'])) {
        $maintenance_id = $_GET['maintenance_id'];
        $recMaintenance = $data->maintenances($vehicle_id)->getRecordById($maintenance_id);
        if ($recMaintenance->id() > 0) {
            $due_date = null;
            if ($recReminder->due_months() !== null) {
                $dt = new DateTime($recMaintenance->date());
                $dt->modify("+" . $recReminder->due_months() . " month");
                $due_date = $dt->format("Y-m-d");
            }
            $recReminder->set_due_date($due_date);

            $due_odometer = null;
            if ($recReminder->due_miles() !== null) {
                $due_odometer = $recMaintenance->odometer() + $recReminder->due_miles();
            }
            $recReminder->set_due_odometer($due_odometer);
        }
    }
}
