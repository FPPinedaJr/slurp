<?php
session_start();
require_once "../connect_db.php";

header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'error' => 'Not logged in']);
    exit();
}

$userid = $_SESSION['user']['userid'];

try {
    $stmt = $pdo->prepare("UPDATE cart SET is_paid = 1 WHERE iduser = ? AND is_paid = 0");
    $stmt->execute([$userid]);
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
