<?php
require_once 'document.php';

header('Content-Type: application/json');

if (isset($_GET['university_id']) && is_numeric($_GET['university_id'])) {
    $university_id = (int)$_GET['university_id'];
    $max_order_number = get_max_order_number($university_id);
    echo json_encode(['order_number' => $max_order_number]);
} else {
    echo json_encode(['error' => 'Invalid university_id']);
}
