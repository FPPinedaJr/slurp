<?php
require_once "includes/connect_db.php";

// Get orders with items in one query to minimize runtime
$stmt = $pdo->query("
    SELECT 
        u.f_name, u.l_name, c.created_at,
        GROUP_CONCAT(CONCAT_WS('|', p.name, c.qty, 
            CASE WHEN p.on_sale = 1 THEN p.sale_price ELSE p.price END
        ) SEPARATOR '||') AS items,
        SUM(
            CASE 
                WHEN p.on_sale = 1 THEN p.sale_price 
                ELSE p.price 
            END * c.qty
        ) AS total
    FROM cart c
    JOIN product p ON c.idproduct = p.idproduct
    JOIN user u ON c.iduser = u.iduser
    WHERE c.is_paid = 1
    GROUP BY c.iduser, c.created_at
    ORDER BY c.created_at DESC
");

$orderDetails = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $items = [];
    if (!empty($row['items'])) {
        foreach (explode('||', $row['items']) as $itemStr) {
            [$name, $qty, $price] = explode('|', $itemStr);
            $items[] = ['name' => $name, 'qty' => $qty, 'price' => $price];
        }
    }
    $orderDetails[] = [
        'user' => $row['f_name'] . ' ' . $row['l_name'],
        'date' => $row['created_at'],
        'total' => $row['total'],
        'items' => $items
    ];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>SendNoods | Orders</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/output.css?v=0.1">
    <link rel="stylesheet" href="./assets/css/fontawesome/all.min.css">
    <script src="./assets/js/jquery-3.7.1.min.js"></script>
</head>

<body class="min-h-screen text-red-500 bg-black">
    <?php include_once "includes/header.php"; ?>

    <div class="container max-w-2xl p-6 m-10 mx-auto mt-10 rounded-lg shadow-lg bg-neutral-900">
        <h1 class="mb-6 text-3xl font-bold text-red-500">Orders</h1>

        <?php if (count($orderDetails) > 0): ?>
            <div class="space-y-6">
                <?php foreach ($orderDetails as $index => $order): ?>
                    <div class="p-5 space-y-3 border border-red-500 shadow-sm bg-neutral-800 rounded-xl">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-lg font-semibold text-red-400"><?= htmlspecialchars($order['user']) ?></h2>
                                <p class="text-sm text-red-300"><?= date("F j, Y g:i A", strtotime($order['date'])) ?></p>
                            </div>
                            <div class="text-xl font-bold text-yellow-400 whitespace-nowrap">
                                ₱<?= number_format($order['total'], 2) ?>
                            </div>
                        </div>

                        <button
                            class="flex items-center px-3 py-1 mt-2 text-sm font-medium text-black bg-yellow-400 rounded hover:bg-yellow-500 toggle-details"
                            data-target="#details-<?= $index ?>">
                            <i class="mr-1 fas fa-box-open"></i> View Items
                            <i class="ml-2 fas fa-chevron-down"></i>
                        </button>

                        <div id="details-<?= $index ?>" class="hidden mt-3">
                            <ul class="pl-4 space-y-1 text-sm text-red-300 list-disc">
                                <?php foreach ($order['items'] as $item): ?>
                                    <li>
                                        <?= htmlspecialchars($item['name']) ?> -
                                        <?= $item['qty'] ?> × ₱<?= number_format($item['price'], 2) ?> =
                                        <span class="font-semibold text-yellow-400">
                                            ₱<?= number_format($item['qty'] * $item['price'], 2) ?>
                                        </span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-center text-red-400">No paid orders found.</p>
        <?php endif; ?>
    </div>

</body>

<script>
    $(document).ready(function () {
        $('.toggle-details').on('click', function () {
            const target = $(this).data('target');
            $(target).slideToggle();
            $(this).find('.fa-chevron-down, .fa-chevron-up').toggleClass('fa-chevron-down fa-chevron-up');
        });
    });
</script>

</html>