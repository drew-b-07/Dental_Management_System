<?php
require_once __DIR__.'/main.php'; 

header('Content-Type: application/json');

$main = new MAIN();

try {
    
    $fullName = urldecode($_GET['name'] ?? '');

    if (empty($fullName)) {
        throw new Exception('No name provided');
    }

    
    $stmt = $main->runQuery("SELECT * FROM appointments WHERE fullname = :fullname AND status = 'accepted'");
    $stmt->execute([':fullname' => $fullName]);
    $appointmentDetails = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($appointmentDetails) {
        echo json_encode($appointmentDetails);
    } else {
        throw new Exception('Appointment not found');
    }
} catch (Exception $e) {
    http_response_code(404);
    echo json_encode([
        'error' => $e->getMessage(),
        'fullname' => $fullName,
        'details' => 'Unable to retrieve appointment details'
    ]);
}
exit;