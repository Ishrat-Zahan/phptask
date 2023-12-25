<?php

require 'dbConnection/db.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Authorization');


header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = json_decode(file_get_contents('php://input'), true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(['error' => 'Invalid JSON data']);
        exit();
    }


    if (isset($data['product_id']) && isset($data['user_id']) && isset($data['review_text'])) {


        $product_id = $data['product_id'];
        $user_id = $data['user_id'];
        $review_text = $data['review_text'];

        if (empty($product_id) || empty($user_id) || empty($review_text)) {
            echo json_encode(array('error' => 'All fields must be filled.'));

        } else {

            $query = "INSERT INTO review (user_id, product_id,review_text) VALUES ('$user_id','$product_id','$review_text')";

            if (mysqli_query($conn, $query)) {
                echo json_encode(['message' => 'Review Created successful']);
            } else {
                echo json_encode(['error' => 'Failed to create']);
            }

        }
    } else {
        echo json_encode(array('error' => 'Missing required fields.'));
    }
} else {

    echo json_encode(array('error' => 'Invalid request method. Only POST requests are allowed.'));
}

mysqli_close($conn);
