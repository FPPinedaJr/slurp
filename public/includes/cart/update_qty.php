<?php
session_start();
require_once "../connect_db.php";

header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'error' => 'Not logged in']);
    exit();
}

$idcart = $_POST['idcart'] ?? null;
$qty = $_POST['qty'] ?? null;

if (!$idcart || !$qty || !is_numeric($idcart) || !is_numeric($qty)) {
    echo json_encode(['success' => false, 'error' => 'Invalid input']);
    exit();
}

$qty = max(1, (int) $qty); // Prevent zero or negative quantities
$userid = $_SESSION['user']['userid'];

try {
    $stmt = $pdo->prepare("UPDATE cart SET qty = ? WHERE idcart = ? AND iduser = ?");
    $stmt->execute([$qty, $idcart, $userid]);

    if ($stmt->rowCount()) {
        echo json_encode(['success' => true, 'new_qty' => $qty]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Update failed or no change made']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
