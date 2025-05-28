<?php
session_start();
require_once "../connect_db.php";

header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'error' => 'Not logged in']);
    exit();
}

$idcart = $_POST['idcart'] ?? null;

if (!$idcart || !is_numeric($idcart)) {
    echo json_encode(['success' => false, 'error' => 'Invalid cart ID']);
    exit();
}

$userid = $_SESSION['user']['userid'];

try {
    $stmt = $pdo->prepare("DELETE FROM cart WHERE idcart = ? AND iduser = ?");
    $stmt->execute([$idcart, $userid]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Item not found or unauthorized']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
