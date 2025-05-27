<?php
include_once "../connect_db.php";
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT idcategory, name FROM category WHERE idcategory = ?");
$stmt->execute([$id]);
echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
