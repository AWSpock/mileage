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

// $recReminder->store_bills($data->bills($recVehicle->id(), $recReminder->id())->getRecords());

//

if (!empty($_POST)) {
    $res = $reminderData->deleteRecord($recReminder);
    $_SESSION['last_message_text'] = $reminderData->actionDataMessage;
    if ($res == 1) {
        $_SESSION['last_message_type'] = "success";
        header('Location: /vehicle/' . $recVehicle->id() . '/reminder');
        die();
    } else {
        $_SESSION['last_message_type'] = "danger";
    }
}
?>