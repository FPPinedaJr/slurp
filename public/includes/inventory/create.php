<?php
include_once '/../connect_db.php';

header('Content-Type: application/json');

try {
    $name = $_POST['item-name'];
    $image = $_FILES['item-img-file'];

    if (!empty($profile_pic["tmp_name"])) {
        $source = $profile_pic["tmp_name"];
        list($width, $height) = getimagesize($source);

        $max_dimension = 200; // max resolution 
        $resize_ratio = min($max_dimension / $width, $max_dimension / $height);

        $new_width = $width * $resize_ratio;
        $new_height = $height * $resize_ratio;

        $info = getimagesize($source);
        if ($info['mime'] == 'image/jpeg') {
            $image = imagecreatefromjpeg($source);
        } elseif ($info['mime'] == 'image/png') {
            $image = imagecreatefrompng($source);
        }

        $tn = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($tn, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

        ob_start();
        imagejpeg($tn, NULL, 60);
        $img_content = ob_get_clean();
    }


    $stmt = $pdo->prepare("INSERT INTO ingredient (name, image) VALUES (?, ?)");
    $stmt->execute([$name, $image]);

    echo json_encode(['success' => true, 'message' => 'Ingredient added successfully']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
