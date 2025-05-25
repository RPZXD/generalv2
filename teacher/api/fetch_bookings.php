<?php
require_once __DIR__ . '/../../classes/DatabaseGeneral.php';
require_once __DIR__ . '/../../models/Booking.php';
require_once __DIR__ . '/../../controllers/BookingController.php';
require_once __DIR__ . '/../../models/TermPee.php';

use Controllers\BookingController;

header('Content-Type: application/json');

try {
    $teach_id = isset($_GET['teach_id']) ? $_GET['teach_id'] : null;

    if (!$teach_id) {
        echo json_encode(['list' => []]);
        exit;
    }

    $termPee = \TermPee::getCurrent();
    $term = $termPee->term;
    $pee = $termPee->pee;

    $controller = new BookingController();
    $list = $controller->getByTeacher($teach_id, $term, $pee);

    echo json_encode([
        'list' => $list,
        'term' => $term,
        'pee' => $pee
    ]);
} catch (\Throwable $e) {
    error_log("Error in fetch_bookings.php: " . $e->getMessage());
    echo json_encode(['list' => [], 'error' => $e->getMessage()]);
}
