<?php 

class MessageValidator {
    public static function validate($data) {
        $errors = [];

        // Required fields
        $requiredFields = ['name', 'email', 'subject', 'message'];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || empty(trim($data[$field]))) {
                $errors[] = "Missing required field: {$field}";
            }
        }

        // Email validation
        if (isset($data['email']) && !empty($data['email'])) {
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Invalid email format";
            }
        }

        // Message length validation
        if (isset($data['message']) && strlen($data['message']) < 10) {
            $errors[] = "Message must be at least 10 characters long";
        }

        return [
            'isValid' => empty($errors),
            'errors' => $errors
        ];
    }
}
