<?php
// includes/inventory/edit.php
header('Content-Type: application/json');

// Include your database connection
include_once '../connect_db.php';

if (!isset($_POST['id']) || !isset($_POST['qty'])) {
    echo json_encode(['success' => false, 'error' => 'Missing required fields: id or qty']);
    exit;
}

$id = (int) $_POST['id'];
$qty = (int) $_POST['qty'];

// Optional: Validate qty is non-negative
if ($qty < 0) {
    echo json_encode(['success' => false, 'error' => 'Quantity cannot be negative']);
    exit;
}

try {
    // Prepare update statement
    $stmt = $pdo->prepare("UPDATE ingredient SET qty = :qty WHERE idingredient = :id");
    $stmt->bindParam(':qty', $qty, PDO::PARAM_INT);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true]);
    } else {
        // No rows updated - maybe id does not exist
        echo json_encode(['success' => false, 'error' => 'Ingredient not found or qty unchanged']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
}
