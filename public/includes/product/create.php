<?php
include_once "../connect_db.php";

$name = $_POST['name'] ?? '';
$description = $_POST['description'] ?? '';
$price = $_POST['price'] ?? 0;
$sale_price = $_POST['sale_price'] ?? 0;
$on_sale = isset($_POST['on_sale']) ? 1 : 0;
$category = $_POST['category'] ?? 0;

if (!empty($_FILES['img']['tmp_name'])) {
    $image = file_get_contents($_FILES['img']['tmp_name']);
} else {
    $image = null;
}


$stmt = $pdo->prepare("INSERT INTO product (name, description, price, sale_price, on_sale, category, created_at, img) 
VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)", );

$stmt->execute([$name, $description, $price, $sale_price, $on_sale, $category, $image]);

echo "OK";
