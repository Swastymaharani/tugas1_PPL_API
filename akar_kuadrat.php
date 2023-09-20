<?php
// Database connection parameters
// $servername = "localhost";
// $username = "root";
// $password = "";
// $database = "bilangan_kuadrat";

// Create a database connection
// $conn = new mysqli($servername, $username, $password, $database);

// Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

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
        $insertSql = "INSERT INTO tb_sqnumbers (numbers, sqnumber) VALUES ($number, $squareRoot);";
        if ($conn->query($insertSql) !== TRUE) {
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

// // Handle API requests
// if($_SERVER['REQUEST_METHOD'] === 'GET'){
//     // Parse JSON request data
//     $requestData = json_decode(file_get_contents('php://input'), true);
    
//     if (isset($requestData['number'])) {
//         $number = floatval($requestData['number']);
//         $squareRoot = sqrt($number);
//         $response = ['square_root' => $squareRoot];
//         echo json_encode($response);

//         // Update the SQL database with the square root result
//         $updateSql = "INSERT INTO tb_sqnumbers (numbers, sqnumber) VALUES ($number, $squareRoot);";
//         if ($conn->query($updateSql) !== TRUE) {
//             http_response_code(500); // Internal Server Error
//             echo json_encode(['error' => 'Error updating the database']);
//             exit; // Exit the script if there's an error
//         }
//         else {
//             http_response_code(500); // Internal Server Error
//             echo json_encode(['error' => 'Error fetching data from the database']);
//         }
//     } else {
//         http_response_code(400); // Bad Request
//         echo json_encode(['error' => 'Missing "number" parameter']);
//     }
// }
// else {
//     http_response_code(405); // Method Not Allowed
//     echo json_encode(['error' => 'Method not allowed']);
// }

// Close the database connection
// $conn->close();
?>

