<?php
include_once("connect_db.php");
header('Content-Type: application/json');

$name = $_POST['name'] ?? '';
$price = $_POST['price'] ?? 0;
$on_sale = $_POST['on_sale'] ?? 0;
$sale_price = $_POST['sale_price'] ?? 0;
$category = $_POST['category'] ?? 0;
$image = $_FILES['img'] ?? null;

if (!$name || !$price || !$image) {
    echo json_encode(['status' => 'error', 'message' => 'Missing required fields.']);
    exit;
}

// Compress image with GD
function compressImage($file)
{
    $img = null;
    $type = mime_content_type($file['tmp_name']);

    if ($type === 'image/jpeg' || $type === 'image/jpg') {
        $img = imagecreatefromjpeg($file['tmp_name']);
    } elseif ($type === 'image/png') {
        $img = imagecreatefrompng($file['tmp_name']);
    }

    if (!$img)
        return false;

    ob_start();
    imagejpeg($img, null, 75); // Adjust quality as needed
    $data = ob_get_clean();
    imagedestroy($img);
    return $data;
}

$compressedImage = compressImage($image);
if (!$compressedImage) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid image format.']);
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO product (category, name, price, on_sale, sale_price, created_at, updated_at, img) VALUES (?, ?, ?, ?, ?, NOW(), NOW(), ?)");
    $stmt->execute([$category, $name, $price, $on_sale, $sale_price, $compressedImage]);

    echo json_encode(['status' => 'success']);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
