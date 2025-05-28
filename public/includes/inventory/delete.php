<?php
include_once "../connect_db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;

    if ($id) {
        $stmt = $pdo->prepare("DELETE FROM ingredient WHERE idingredient = ?");
        $success = $stmt->execute([$id]);
        echo json_encode(['success' => $success]);
    } else {
        echo json_encode(['success' => false, 'error' => 'No ID provided.']);
    }
}
