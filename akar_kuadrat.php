<?php
// Allow Cross-Origin Resource Sharing (CORS)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

// Retrieve database connection information from environment variables
$dbHost = getenv('DB_HOST');
$dbPort = getenv('DB_PORT');
$dbName = getenv('DB_NAME');
$dbUser = getenv('DB_USER');
$dbPassword = getenv('DB_PASSWORD');

// Function to calculate square root using PHP
function calculateSquareRoot($numbers) {
    return sqrt($numbers);
}

// Handle API requests
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get the 'numbers' parameter
    $jsonData = $_GET['numbers'];

    // Decode the JSON data
    $numbers = json_decode($jsonData, true);
    $numbers = floatval($numbers);

    echo json_encode(['square_root' => $numbers]);

    if ($numbers !== null) {
        $squareRoot = calculateSquareRoot($numbers);
        
        // Create a database connection
        $connection = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

        // Check if the connection was successful
        if ($connection->connect_error) {
            http_response_code(500); // Internal Server Error
            echo json_encode(['error' => 'Error connecting to the database']);
            exit; // Exit the script if there's an error
        }

        // Insert the numbers and square root into the database
        $insertSql = "INSERT INTO tb_sqnumbers (numbers, sqnumber) VALUES ($numbers, $squareRoot)";
        
        if ($connection->query($insertSql) !== TRUE) {
            http_response_code(500); // Internal Server Error
            echo json_encode(['error' => 'Error updating the database']);
            exit; // Exit the script if there's an error
        } else {
            echo json_encode(['square_root' => $squareRoot]);
        }

        // Close the database connection
        $connection->close();
    } else {
        http_response_code(400); // Bad Request
        echo json_encode(['error' => 'Missing or invalid "numbers" parameter']);
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Method not allowed']);
}
?>
