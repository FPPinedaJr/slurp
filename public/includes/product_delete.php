<?php
include_once("connect_db.php");
header('Content-Type: application/json');

if (!isset($_POST['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'No product ID provided.']);
    exit;
}

$id = intval($_POST['id']);

try {
    $stmt = $pdo->prepare("DELETE FROM product WHERE idproduct = ?");
    $stmt->execute([$id]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Product not found or already deleted.']);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
