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
    $id = $_POST['id'] ?? null;
    $name = $_POST['name'] ?? '';
    $qty = $_POST['qty'] ?? 0;

    if (!$id || !$name || !is_numeric($qty)) {
        echo json_encode(['success' => false, 'error' => 'Missing required fields.']);
        exit;
    }

    $imageData = null;

    if (!empty($_FILES['image']['tmp_name'])) {
        $imageTmp = $_FILES['image']['tmp_name'];
        $imageData = compressImage($imageTmp, 75);
        if (!$imageData) {
            echo json_encode(['success' => false, 'error' => 'Invalid image.']);
            exit;
        }
    }

    if ($imageData) {
        $stmt = $pdo->prepare("UPDATE ingredient SET name = ?, qty = ?, image = ?, updated_at = NOW() WHERE idingredient = ?");
        $success = $stmt->execute([$name, $qty, $imageData, $id]);
    } else {
        $stmt = $pdo->prepare("UPDATE ingredient SET name = ?, qty = ?, updated_at = NOW() WHERE idingredient = ?");
        $success = $stmt->execute([$name, $qty, $id]);
    }

    echo json_encode(['success' => $success]);
}
