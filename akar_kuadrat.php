<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode(['square_root' => 100]);
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Method not allowed']);
}
?>
