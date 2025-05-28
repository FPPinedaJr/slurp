<?php
session_start();
include_once "../connect_db.php";
$iduser = $_POST['iduser'];
$idproduct = $_POST['idproduct'];
$qty = $_POST['qty'];

// Insert or update cart
$stmt = $pdo->prepare("SELECT * FROM cart WHERE iduser = ? AND idproduct = ?");
$stmt->execute([$iduser, $idproduct]);
$exists = $stmt->fetch();

if ($exists) {
    $pdo->prepare("UPDATE cart SET qty = qty + ? WHERE iduser = ? AND idproduct = ?")
        ->execute([$qty, $iduser, $idproduct]);
} else {
    $pdo->prepare("INSERT INTO cart (iduser, idproduct, qty, created_at) VALUES (?, ?, ?, NOW())")
        ->execute([$iduser, $idproduct, $qty]);
}

// Get total cart info
$totalItemsStmt = $pdo->prepare("SELECT SUM(qty) AS total_items FROM cart WHERE iduser = ?");
$totalItemsStmt->execute([$iduser]);
$totalItems = $totalItemsStmt->fetch()['total_items'];

$totalAmountStmt = $pdo->prepare("
    SELECT SUM(p.price * c.qty) AS total_amount
    FROM cart c
    JOIN product p ON c.idproduct = p.idproduct
    WHERE c.iduser = ?");
$totalAmountStmt->execute([$iduser]);
$totalAmount = $totalAmountStmt->fetch()['total_amount'];

echo json_encode([
    'success' => true,
    'totalItems' => $totalItems,
    'totalAmount' => number_format($totalAmount, 2)
]);
