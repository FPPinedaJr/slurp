<?php
include_once "../connect_db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['name']) || !isset($_FILES['image'])) {
        http_response_code(400);
        echo "Missing data";
        exit;
    }

    $name = trim($_POST['name']);
    $image = $_FILES['image'];

    if ($image['error'] !== UPLOAD_ERR_OK) {
        http_response_code(400);
        echo "Image upload failed";
        exit;
    }

    $imageData = file_get_contents($image['tmp_name']);

    $stmt = $pdo->prepare("INSERT INTO category (name, image) VALUES (?, ?)");
    $stmt->execute([$name, $imageData]);

    echo "Category inserted";
} else {
    http_response_code(405);
    echo "Invalid request method";
}
