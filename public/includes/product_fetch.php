<?php
include_once("connect_db.php");
header('Content-Type: application/json');

$category = isset($_GET['category']) ? intval($_GET['category']) : 0;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 8;
$offset = ($page - 1) * $limit;

try {
    $stmt = $pdo->prepare("
        SELECT p.*, c.name AS category_name
        FROM product p
        JOIN category c ON p.category = c.idcategory
        WHERE (:category = 0 OR p.category = :category)
        ORDER BY p.created_at DESC
        LIMIT :offset, :limit
    ");
    $stmt->bindParam(':category', $category, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Count total
    $countStmt = $pdo->prepare("
        SELECT COUNT(*) FROM product WHERE (:category = 0 OR category = :category)
    ");
    $countStmt->bindParam(':category', $category, PDO::PARAM_INT);
    $countStmt->execute();
    $total = $countStmt->fetchColumn();

    echo json_encode([
        'status' => 'success',
        'products' => $products,
        'total' => $total,
        'limit' => $limit
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
