<?php
include_once "../connect_db.php";
$id = $_POST['id'];
$stmt = $pdo->prepare("DELETE FROM category WHERE idcategory = ?");
$stmt->execute([$id]);
