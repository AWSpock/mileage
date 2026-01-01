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

$recReminder = new Reminder();

// 

if (!empty($_POST)) {
    $recReminder = Reminder::fromPost($_POST);
    $record_id = $reminderData->insertRecord($recReminder);
    $_SESSION['last_message_text'] = $reminderData->actionDataMessage;
    if ($record_id > 0) {
        $_SESSION['last_message_type'] = "success";
        header('Location: /vehicle/' . $recVehicle->id() . '/reminder');
        die();
    } else {
        $_SESSION['last_message_type'] = "danger";
    }
}
