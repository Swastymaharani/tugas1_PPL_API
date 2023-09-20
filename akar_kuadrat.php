<?php
// Allow Cross-Origin Resource Sharing (CORS)
header("Access-Control-Allow-Origin: https://tugas1-ezykjtri3-swastymaharani.vercel.app");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

// Retrieve database connection information from environment variables
$dbHost = getenv('DB_HOST');
$dbPort = getenv('DB_PORT');
$dbName = getenv('DB_NAME');
$dbUser = getenv('DB_USER');
$dbPassword = getenv('DB_PASSWORD');

// Create a database connection
$connection = new mysqli($dbHost, $dbUser, $dbPassword, $dbName, $dbPort);

// Check if the connection was successful
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Function to calculate square root using PHP
function calculateSquareRoot($number) {
    return sqrt($number);
}

// Handle API requests
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get the 'number' parameter from the query string
    $number = isset($_GET['number']) ? floatval($_GET['number']) : null;

    if ($number !== null) {
        $squareRoot = calculateSquareRoot($number);
        
        // Insert the SQL database with the square root result
        $insertSql = "INSERT INTO tb_sqnumbers (numbers, sqnumber) VALUES ($number, $squareRoot)";
        if ($connection->query($insertSql) !== TRUE) {
            http_response_code(500); // Internal Server Error
            echo json_encode(['error' => 'Error updating the database']);
            exit; // Exit the script if there's an error
        }
        else {
            echo json_encode(['square_root' => $squareRoot]);
        }
    } else {
        http_response_code(400); // Bad Request
        echo json_encode(['error' => 'Missing or invalid "number" parameter']);
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Method not allowed']);
}

// Close the database connection
$connection->close();
?>

