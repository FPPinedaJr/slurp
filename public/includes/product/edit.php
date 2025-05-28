<?php
include_once "../connect_db.php";

$id = $_POST['idproduct'] ?? 0;
$name = $_POST['name'] ?? '';
$description = $_POST['description'] ?? '';
$price = $_POST['price'] ?? 0;

// If image is uploaded, compress and update it
if (!empty($_FILES['img']['tmp_name'])) {
    $tmpFile = $_FILES['img']['tmp_name'];
    $imageInfo = getimagesize($tmpFile);
    $mime = $imageInfo['mime'];

    ob_start();
    switch ($mime) {
        case 'image/jpeg':
            $img = imagecreatefromjpeg($tmpFile);
            imagejpeg($img, null, 75); // outputs directly to buffer
            break;
        case 'image/png':
            $img = imagecreatefrompng($tmpFile);
            imagejpeg($img, null, 75);
            break;
        case 'image/webp':
            $img = imagecreatefromwebp($tmpFile);
            imagejpeg($img, null, 75);
            break;
        default:
            http_response_code(400);
            echo "Unsupported image format.";
            exit;
    }
    $compressedImage = ob_get_contents(); // Get actual binary
    ob_end_clean();
    imagedestroy($img);


    $stmt = $pdo->prepare("UPDATE product SET name=?, description=?, price=?, img=? WHERE idproduct=?");
    $stmt->execute([$name, $description, $price, $compressedImage, $id]);
} else {
    $stmt = $pdo->prepare("UPDATE product SET name=?, description=?, price=? WHERE idproduct=?");
    $stmt->execute([$name, $description, $price, $id]);
}

echo "OK";
