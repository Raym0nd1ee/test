<?php

include_once 'db.php';
require_once 'models/Message.php';
require_once 'validators/MessageValidator.php';

try {
    // Get posted data
    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data) {
        throw new Exception('Invalid input data');
    }

    // Validate input
    $validation = MessageValidator::validate($data);
    if (!$validation['isValid']) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => implode(', ', $validation['errors'])
        ]);
        exit();
    }

    // Initialize database connection
    $database = new Database();
    $db = $database->connect();

    // Initialize message object and create message
    $message = new Message($db);
    $result = $message->create($data);

    // Return response
    echo json_encode($result);

} catch(Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage()
    ]);
}