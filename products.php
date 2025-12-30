<?php

require_once 'db.php';

// Set response headers
header('Content-Type: application/json; charset=utf-8');

// Check connection
if (!$conn) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Database connection failed: " . mysqli_connect_error()
    ]);
    exit;
}

$sql = "SELECT id, title, description, brand, price_cents, currency, stock, img_location, rating, created_at, updated_at 
        FROM product";

$result = mysqli_query($conn, $sql);

if ($result) {
    $products = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }

    echo json_encode([
        "status" => "success",
        "data" => $products
    ], JSON_PRETTY_PRINT);
} else {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => mysqli_error($conn)
    ]);
}

mysqli_close($conn);



?>