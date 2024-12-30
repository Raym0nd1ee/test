<?php
// Set CORS headers first, before any output
header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Max-Age: 86400'); // Cache preflight for 24 hours

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204); // No content needed for OPTIONS
    exit(0);
}

// Set content type for actual requests
header('Content-Type: application/json');

include_once 'db.php';

class RecruitmentRequest {
    public $conn;
    public $table = 'recruitment_requests';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($data) {
        try {
            // Validate input
            $validation = RecruitmentValidator::validate($data);
            if (!$validation['isValid']) {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => implode(', ', $validation['errors'])
                ]);
                exit();
            }

            // Create query
            $query = "INSERT INTO " . $this->table . "
                    (company_name, contact_person, email, phone, service, message, status)
                    VALUES
                    (:company_name, :contact_person, :email, :phone, :service, :message, :status)";

            $stmt = $this->conn->prepare($query);

            // Sanitize inputs
            $companyName = htmlspecialchars(strip_tags($data['companyName']));
            $contactPerson = htmlspecialchars(strip_tags($data['contactPerson']));
            $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
            $phone = htmlspecialchars(strip_tags($data['phone']));
            $service = htmlspecialchars(strip_tags($data['service']));
            $message = htmlspecialchars(strip_tags($data['message']));
            $status = "new";

            // Bind parameters
            $stmt->bindParam(':company_name', $companyName);
            $stmt->bindParam(':contact_person', $contactPerson);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':service', $service);
            $stmt->bindParam(':message', $message);
            $stmt->bindParam(':status', $status);

            if ($stmt->execute()) {
                return [
                    'success' => true,
                    'message' => 'Recruitment request submitted successfully',
                    'id' => $this->conn->lastInsertId()
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to submit recruitment request'
            ];

        } catch(PDOException $e) {
            return [
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
    }
}

try {
    // Get posted data
    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data) {
        throw new Exception('Invalid input data');
    }

    // Initialize database connection
    $database = new Database();
    $db = $database->connect();

    // Initialize recruitment request object and create request
    $request = new RecruitmentRequest($db);
    $result = $request->create($data);

    // Return response
    echo json_encode($result);

} catch(Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage()
    ]);
}