<?php
// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: http://localhost:5173');
    header('Access-Control-Allow-Methods: POST, INSERT, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
    header('Access-Control-Max-Age: 86400'); // Cache preflight for 24 hours
    exit(0);
}

header('Access-Control-Allow-Origin: http://localhost:5173');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, INSERT');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

include_once 'db.php';

class JobApplication {
    private $conn;
    private $table = 'job_applications';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function submit($data) {
        try {
            // Validate required fields
            if (!isset($data['jobId']) || !isset($data['fullName']) || !isset($data['email']) || !isset($data['phone'])) {
                return array(
                    'success' => false,
                    'message' => 'Missing required fields'
                );
            }

            // Handle file upload
            $resumePath = null;
            if (isset($_FILES['resume'])) {
                $uploadDir = '../uploads/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $fileName = uniqid() . '_' . basename($_FILES['resume']['name']);
                $targetPath = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['resume']['tmp_name'], $targetPath)) {
                    $resumePath = $fileName;
                } else {
                    return array(
                        'success' => false,
                        'message' => 'Failed to upload resume'
                    );
                }
            }

            // Create applications table if it doesn't exist
            $this->createTableIfNotExists();

            // Insert application
            $query = "INSERT INTO " . $this->table . "
                    (job_id, full_name, email, phone, resume_path, cover_letter, created_at)
                    VALUES
                    (:jobId, :fullName, :email, :phone, :resumePath, :coverLetter, NOW())";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':jobId', $data['jobId']);
            $stmt->bindParam(':fullName', $data['fullName']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':phone', $data['phone']);
            $stmt->bindParam(':resumePath', $resumePath);
            $stmt->bindParam(':coverLetter', $data['coverLetter']);

            if ($stmt->execute()) {
                return array(
                    'success' => true,
                    'message' => 'Application submitted successfully'
                );
            }

            return array(
                'success' => false,
                'message' => 'Failed to submit application'
            );

        } catch(PDOException $e) {
            return array(
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            );
        }
    }

    // private function createTableIfNotExists() {
    //     $query = "CREATE TABLE IF NOT EXISTS " . $this->table . " (
    //         id INT AUTO_INCREMENT PRIMARY KEY,
    //         job_id INT NOT NULL,
    //         full_name VARCHAR(255) NOT NULL,
    //         email VARCHAR(255) NOT NULL,
    //         phone VARCHAR(50) NOT NULL,
    //         resume_path VARCHAR(255),
    //         cover_letter TEXT,
    //         created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    //         FOREIGN KEY (job_id) REFERENCES jobs_search(id)
    //     )";

    //     $this->conn->exec($query);
    // }
}

try {
    // Initialize database connection
    $database = new Database();
    $db = $database->connect();

    // Initialize job application object
    $application = new JobApplication($db);

    // Get posted data
    $data = array_merge($_POST, array('coverLetter' => $_POST['coverLetter'] ?? ''));

    // Submit application
    $result = $application->submit($data);

    // Return response
    echo json_encode($result);
} catch(Exception $e) {
    http_response_code(500);
    echo json_encode(array(
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage()
    ));
}
?>