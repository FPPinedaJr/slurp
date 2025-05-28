<?php
session_start();
require_once "includes/connect_db.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$userid = $_SESSION['user']['userid'];
$stmt = $pdo->query("SELECT c.idcart, c.qty, p.idproduct, p.name, p.price, p.sale_price, p.on_sale, p.img
                            FROM cart c 
                            JOIN product p ON c.idproduct = p.idproduct 
                            WHERE c.iduser = $userid AND c.is_paid = 0");

$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/output.css?v=0.1">
    <link rel="stylesheet" href="./assets/css/fontawesome/all.min.css">
    <script src="./assets/js/jquery-3.7.1.min.js"></script>
    <title>Checkout</title>
</head>

<body class="bg-black">
    <?php include_once "includes/header.php"; ?>

    <div class="grid grid-cols-1 gap-6 p-6 text-white md:grid-cols-3">
        <!-- Left: Items -->
        <div class="space-y-4 md:col-span-2">
            <h1 class="mb-4 text-4xl font-bold text-yellow-400">Your Cart</h1>
            <div id="cart-items">
                <?php foreach ($items as $item): ?>
                    <div class="flex items-center justify-between p-4 bg-red-600 rounded shadow">
                        <div class="flex items-center gap-4">
                            <img src="data:image/jpeg;base64,<?= base64_encode($item['img']) ?>"
                                class="object-cover w-20 h-20 rounded">
                            <div>
                                <h2 class="text-lg font-bold text-white"><?= htmlspecialchars($item['name']) ?></h2>
                                <p class="text-sm text-yellow-300">₱<?= number_format($item['price']) ?></p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <button class="px-2 py-1 text-black bg-yellow-400 rounded btn-qty"
                                data-id="<?= $item['idcart'] ?>" data-action="minus">-</button>
                            <span class="w-8 text-center" id="qty-<?= $item['idcart'] ?>"><?= $item['qty'] ?></span>
                            <button class="px-2 py-1 text-black bg-yellow-400 rounded btn-qty"
                                data-id="<?= $item['idcart'] ?>" data-action="plus">+</button>
                        </div>
                        <button class="px-3 py-1 text-white bg-black rounded remove-btn" data-id="<?= $item['idcart'] ?>">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Right: Summary -->
        <div class="sticky p-4 text-black bg-yellow-400 rounded shadow top-20 h-fit">
            <h2 class="mb-4 text-2xl font-bold">Order Summary</h2>
            <div class="mb-4 text-lg">Total: ₱<span id="total-price">0.00</span></div>
            <button onclick="checkoutCart()"
                class="w-full px-4 py-2 font-bold text-white bg-red-600 rounded hover:bg-red-700">Checkout</button>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            const saveTimers = {};

            function calculateTotal() {
                let total = 0;
                $('#cart-items > div').each(function () {
                    const price = parseFloat($(this).find('p').text().replace('₱', ''));
                    const qty = parseInt($(this).find('span[id^=qty-]').text());
                    total += price * qty;
                });
                $('#total-price').text(total.toFixed(2));
            }

            calculateTotal();

            $(document).on('click', '.btn-qty', function () {
                const id = $(this).data('id');
                const action = $(this).data('action');
                const qtyElem = $('#qty-' + id);
                let qty = parseInt(qtyElem.text());
                qty = action === 'plus' ? qty + 1 : Math.max(1, qty - 1);
                qtyElem.text(qty);
                calculateTotal();

                if (saveTimers[id]) {
                    clearTimeout(saveTimers[id]);
                }

                saveTimers[id] = setTimeout(() => {
                    $.post('includes/cart/update_qty.php', { idcart: id, qty }, function (res) {
                        if (!res.success) alert('Failed to update quantity');
                    }, 'json');
                    delete saveTimers[id];
                }, 1000);
            });

            $(document).on('click', '.remove-btn', function () {
                const id = $(this).data('id');
                $.post('includes/cart/delete_item.php', { idcart: id }, function (res) {
                    if (res.success) location.reload();
                    else alert('Failed to remove item.');
                }, 'json');
            });
        });

        function checkoutCart() {
            if (!confirm('Are you sure you want to checkout?')) return;

            $.post("includes/cart/checkout.php", {}, function (res) {
                if (res.success) {
                    alert("Checkout successful!");
                    location.reload();
                } else {
                    alert("Checkout failed.");
                }
            }, 'json');
        }
    </script>
</body>

</html>