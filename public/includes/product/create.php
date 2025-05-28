<?php
include_once "../connect_db.php";

$name = $_POST['name'] ?? '';
$description = $_POST['description'] ?? '';
$price = $_POST['price'] ?? 0;
$category = $_POST['category'] ?? 0;

if (!empty($_FILES['img']['tmp_name'])) {
    $image = file_get_contents($_FILES['img']['tmp_name']);
} else {
    $image = null;
}


$stmt = $pdo->prepare("INSERT INTO product (name, description, price, category, created_at, img) 
VALUES (?, ?, ?, ?, NOW(), ?)", );

$stmt->execute([$name, $description, $price, $category, $image]);

echo "OK";
