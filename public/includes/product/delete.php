<?php
include_once "../connect_db.php";

$id = $_POST['id'] ?? 0;
$stmt = $pdo->prepare("DELETE FROM product WHERE idproduct=?");
$stmt->execute([$id]);

echo "OK";
