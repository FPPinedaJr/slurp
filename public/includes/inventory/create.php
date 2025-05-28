<?php
include_once "../connect_db.php";

function compressImage($sourcePath, $quality = 75)
{
    $imgInfo = getimagesize($sourcePath);
    $mime = $imgInfo['mime'];

    switch ($mime) {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($sourcePath);
            break;
        case 'image/png':
            $image = imagecreatefrompng($sourcePath);
            break;
        case 'image/gif':
            $image = imagecreatefromgif($sourcePath);
            break;
        default:
            return false;
    }

    ob_start();
    imagejpeg($image, null, $quality);
    $data = ob_get_clean();

    imagedestroy($image);
    return $data;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $qty = $_POST['qty'] ?? 0;
    $imageTmp = $_FILES['image']['tmp_name'] ?? null;

    if ($name && is_numeric($qty) && $imageTmp) {
        $compressed = compressImage($imageTmp, 75); // Compress to 75% quality
        if (!$compressed) {
            echo json_encode(['success' => false, 'error' => 'Invalid image type.']);
            exit;
        }

        $stmt = $pdo->prepare("INSERT INTO ingredient (name, qty, image, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())");
        $success = $stmt->execute([$name, $qty, $compressed]);

        echo json_encode(['success' => $success]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid input.']);
    }
}
