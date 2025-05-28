<?php
include_once "../connect_db.php";

$id = $_POST['idcategory'];
$name = $_POST['name'] ?? '';
$image = null;

if (isset($_FILES['image']) && $_FILES['image']['tmp_name']) {
    $image = file_get_contents($_FILES['image']['tmp_name']);
    $stmt = $pdo->prepare("UPDATE category SET name = ?, image = ? WHERE idcategory = ?");
    $stmt->execute([$name, $image, $id]);
} else {
    $stmt = $pdo->prepare("UPDATE category SET name = ? WHERE idcategory = ?");
    $stmt->execute([$name, $id]);
}
