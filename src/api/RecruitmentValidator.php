<?php
class RecruitmentValidator {
    public static function validate($data) {
        $errors = [];

        // Required fields
        $requiredFields = [
            'companyName' => 'Company Name',
            'contactPerson' => 'Contact Person',
            'email' => 'Email',
            'phone' => 'Phone',
            'service' => 'Service',
            'message' => 'Message'
        ];

        foreach ($requiredFields as $field => $label) {
            if (!isset($data[$field]) || empty(trim($data[$field]))) {
                $errors[] = "{$label} is required";
            }
        }

        // Email validation
        if (isset($data['email']) && !empty($data['email'])) {
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Invalid email format";
            }
        }

        // Service validation
        $validServices = [
            'full-recruitment',
            'candidate-screening',
            'headhunting',
            'consultation'
        ];

        if (isset($data['service']) && !in_array($data['service'], $validServices)) {
            $errors[] = "Invalid service selected";
        }

        // Message length validation
        if (isset($data['message']) && strlen($data['message']) < 20) {
            $errors[] = "Message must be at least 20 characters long";
        }

        return [
            'isValid' => empty($errors),
            'errors' => $errors
        ];
    }
}