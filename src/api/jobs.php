<?php
// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: http://localhost:5173');
    header('Access-Control-Allow-Methods: GET, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
    header('Access-Control-Max-Age: 86400'); // Cache preflight for 24 hours
    exit(0);
}

header('Access-Control-Allow-Origin: http://localhost:5173');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

include_once 'db.php';

class Jobs {
    private $conn;
    private $table = 'jobs_search';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function search($keyword = '', $location = '') {
        try {
            $query = "SELECT 
                        id, title, company, location, type, description, salary,
                        DATE_FORMAT(posted_date, '%Y-%m-%d') as posted_date
                    FROM " . $this->table . "
                    WHERE (title LIKE :keyword 
                        OR company LIKE :keyword2 
                        OR description LIKE :keyword3)
                    AND location LIKE :location
                    ORDER BY posted_date DESC";

            $stmt = $this->conn->prepare($query);

            $keyword = "%{$keyword}%";
            $location = "%{$location}%";

            $stmt->bindParam(':keyword', $keyword);
            $stmt->bindParam(':keyword2', $keyword);
            $stmt->bindParam(':keyword3', $keyword);
            $stmt->bindParam(':location', $location);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            http_response_code(500);
            return array('message' => 'Database error: ' . $e->getMessage());
        }
    }
}

try {
    // Initialize database connection
    $database = new Database();
    $db = $database->connect();

    // Initialize jobs object
    $jobs = new Jobs($db);

    // Get search parameters
    $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
    $location = isset($_GET['location']) ? $_GET['location'] : '';

    // Search jobs
    $result = $jobs->search($keyword, $location);

    // Check if we got an error message
    if (isset($result['message'])) {
        http_response_code(500);
        echo json_encode($result);
    } else {
        echo json_encode($result);
    }
} catch(Exception $e) {
    http_response_code(500);
    echo json_encode(array('message' => 'Server error: ' . $e->getMessage()));
}
?>