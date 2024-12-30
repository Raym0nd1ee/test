<?php

class Message {
    private $conn;
    private $table = 'messages';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($data) {
        try {
            $query = "INSERT INTO " . $this->table . "
                    (name, email, subject, message)
                    VALUES
                    (:name, :email, :subject, :message)";

            $stmt = $this->conn->prepare($query);

            // Sanitize inputs
            $name = htmlspecialchars(strip_tags($data['name']));
            $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
            $subject = htmlspecialchars(strip_tags($data['subject']));
            $message = htmlspecialchars(strip_tags($data['message']));

            // Bind parameters
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':subject', $subject);
            $stmt->bindParam(':message', $message);

            if ($stmt->execute()) {
                return [
                    'success' => true,
                    'message' => 'Message sent successfully',
                    'id' => $this->conn->lastInsertId()
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to send message'
            ];

        } catch(PDOException $e) {
            return [
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
    }
}