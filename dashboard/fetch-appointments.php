<?php
require_once __DIR__.'/main.php'; 

header('Content-Type: application/json');

$main = new MAIN();

try {
    $appointments = $main->getAcceptedAppointments();

    $events = [];
    foreach ($appointments as $appointment) {
        $datetime = $appointment['pref_appointment']; 

        $events[] = [
            'title' => $appointment['fullname'],
            'start' => $datetime, 
            'allDay' => false 
        ];
    }

    echo json_encode($events); 
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
exit;
