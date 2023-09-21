<?php
// Allow Cross-Origin Resource Sharing (CORS)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

// Function to calculate square root using PHP
function calculateSquareRoot($numbers) {
    return sqrt($numbers);
}

// Handle API requests
if($_SERVER['REQUEST_METHOD'] === 'POST'){
        // Parse JSON request data
        $requestData = json_decode(file_get_contents('php://input'), true);
        
        if (isset($requestData['number'])) {
            $number = floatval($requestData['number']);
            $squareRoot = sqrt($number);
            $response = ['square_root' => $squareRoot];
            echo json_encode($response);
        } else {
            http_response_code(400); // Bad Request
            echo json_encode(['error' => 'Missing "number" parameter']);
        }   
}
else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Method not allowed']);
}
?>
