<?php
include_once "../connect_db.php";

$name = $_POST['name'] ?? '';
$description = $_POST['description'] ?? '';
$price = $_POST['price'] ?? 0;
$category = $_POST['category'] ?? 0;

$image = null;

if (!empty($_FILES['img']['tmp_name'])) {
    $tmpFile = $_FILES['img']['tmp_name'];
    $imageInfo = getimagesize($tmpFile);
    $mime = $imageInfo['mime'];

    ob_start(); // Start output buffering
    switch ($mime) {
        case 'image/jpeg':
            $img = imagecreatefromjpeg($tmpFile);
            imagejpeg($img, null, 75); // Compress to 75% quality
            break;
        case 'image/png':
            $img = imagecreatefrompng($tmpFile);
            imagejpeg($img, null, 75); // Convert to JPEG with compression
            break;
        case 'image/webp':
            $img = imagecreatefromwebp($tmpFile);
            imagejpeg($img, null, 75); // Convert to JPEG with compression
            break;
        default:
            http_response_code(400);
            echo "Unsupported image format.";
            exit;
    }

    $image = ob_get_clean(); // Get binary image and clean buffer
    imagedestroy($img);      // Free memory
}

$stmt = $pdo->prepare("INSERT INTO product (name, description, price, category, created_at, img) 
VALUES (?, ?, ?, ?, NOW(), ?)");

$stmt->execute([$name, $description, $price, $category, $image]);

echo "OK";
