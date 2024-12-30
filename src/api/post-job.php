<?php

include_once 'db.php';

class JobPost {
    private $conn;
    private $table = 'jobs_search';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($data) {
        try {
            // Validate required fields
            $requiredFields = ['title', 'company', 'location', 'type', 'description', 'salary'];
            foreach ($requiredFields as $field) {
                if (!isset($data[$field]) || empty(trim($data[$field]))) {
                    return [
                        'success' => false,
                        'message' => "Missing required field: {$field}"
                    ];
                }
            }

            // Create query
            $query = "INSERT INTO " . $this->table . "
                    (title, company, location, type, description, salary)
                    VALUES
                    (:title, :company, :location, :type, :description, :salary)";

            $stmt = $this->conn->prepare($query);

            // Clean and bind data
            $title = htmlspecialchars(strip_tags($data['title']));
            $company = htmlspecialchars(strip_tags($data['company']));
            $location = htmlspecialchars(strip_tags($data['location']));
            $type = htmlspecialchars(strip_tags($data['type']));
            $description = htmlspecialchars(strip_tags($data['description']));
            $salary = htmlspecialchars(strip_tags($data['salary']));

            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':company', $company);
            $stmt->bindParam(':location', $location);
            $stmt->bindParam(':type', $type);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':salary', $salary);

            if ($stmt->execute()) {
                return [
                    'success' => true,
                    'message' => 'Job posted successfully',
                    'jobId' => $this->conn->lastInsertId()
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to post job'
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

    // Initialize job post object
    $jobPost = new JobPost($db);

    // Create job post
    $result = $jobPost->create($data);

    // Return response
    echo json_encode($result);
} catch(Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage()
    ]);
}
?>