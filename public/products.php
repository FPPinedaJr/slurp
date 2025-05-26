<?php
include_once("includes/connect_db.php");






$stmt = $pdo->prepare("
        SELECT *
        FROM product 
        ORDER BY p.created_at DESC
    ");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);


$stmt = $pdo->prepare("
        SELECT *
        FROM category
        ORDER BY name
    ");
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/output.css?v=0.1">
    <link rel="stylesheet" href="./assets/css/fontawesome/all.min.css">
    <link rel="stylesheet" href="./assets/css/fontawesome/fontawesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <script src="./assets/js/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lozad"></script>
    <title>SendNoods - Products</title>
</head>

<body class="flex flex-col items-center w-screen min-h-screen overflow-x-hidden bg-slate-100">
    <main class="flex flex-col w-full h-full mb-10 md:flex-row">
        <aside class="w-full p-4 bg-white shadow md:w-1/5">
            <h2 class="mb-4 text-xl font-bold">Categories</h2>
            <ul id="categoryList" class="space-y-2">
                <!-- Populated by jQuery -->
            </ul>
        </aside>
        <section class="w-full p-4 md:w-4/5">
            <div id="productGrid" class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                <!-- Products will be populated here -->
            </div>
            <div class="flex justify-center mt-4">
                <button id="prevPage" class="px-4 py-2 bg-gray-200 rounded-l">&laquo; Prev</button>
                <button id="nextPage" class="px-4 py-2 bg-gray-200 rounded-r">Next &raquo;</button>
            </div>
        </section>
    </main>
</body>

<script>
    let currentCategory = 0;
    let currentPage = 1;

    function fetchCategories() {
        $.getJSON('includes/product_fetch.php?action=categories', function (res) {
            if (res.success) {
                $('#categoryList').html('<li><button class="w-full text-left category-btn" data-id="0">All</button></li>');
                res.data.forEach(cat => {
                    $('#categoryList').append(`<li><button class="w-full text-left category-btn" data-id="${cat.idcategory}">${cat.name}</button></li>`);
                });
            } else {
                alert(res.message);
            }
        });
    }

    function fetchProducts() {
        $.getJSON('includes/product_fetch.php', {
            action: 'products',
            category: currentCategory,
            page: currentPage
        }, function (res) {
            if (res.success) {
                $('#productGrid').empty();
                res.data.forEach(prod => {
                    $('#productGrid').append(`
                        <div class="flex flex-col items-center p-2 bg-white rounded shadow">
                            <img class="object-cover w-full h-40 mb-2" src="${prod.img}" alt="${prod.name}">
                            <h3 class="text-sm font-semibold">${prod.name}</h3>
                            <p class="text-gray-700">₱${prod.on_sale ? prod.sale_price : prod.price}</p>
                            <div class="flex mt-2 space-x-2">
                                <button class="text-blue-500 edit-btn" data-id="${prod.idproduct}"><i class="fas fa-edit"></i></button>
                                <button class="text-red-500 delete-btn" data-id="${prod.idproduct}"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    `);
                });
            } else {
                alert(res.message);
            }
        });
    }

    $(document).on('click', '.category-btn', function () {
        currentCategory = $(this).data('id');
        currentPage = 1;
        fetchProducts();
    });

    $(document).on('click', '.delete-btn', function () {
        const id = $(this).data('id');
        if (confirm("Are you sure you want to delete this product?")) {
            $.post('includes/product_delete.php', { id: id }, function (res) {
                const data = JSON.parse(res);
                if (data.success) {
                    fetchProducts();
                } else {
                    alert(data.message);
                }
            });
        }
    });

    $('#nextPage').click(() => {
        currentPage++;
        fetchProducts();
    });

    $('#prevPage').click(() => {
        if (currentPage > 1) {
            currentPage--;
            fetchProducts();
        }
    });

    fetchCategories();
    fetchProducts();
</script>

</html>