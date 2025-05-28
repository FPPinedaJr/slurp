<?php

include_once "includes/connect_db.php";

$stmt = $pdo->query("SELECT * FROM category");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

$selectedCategoryId = isset($_GET['category']) ? intval($_GET['category']) : ($categories[0]['idcategory'] ?? 0);

$stmt = $pdo->query("SELECT * FROM product");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    <title>Document</title>
</head>

<body class="bg-gray-100">
    <?php include_once "includes/header.php"; ?>

    <div class="flex h-screen">
        <!-- Sidebar Categories -->
        <div class="flex flex-col w-24 p-2 space-y-2 overflow-y-auto text-white bg-gray-900">
            <div id="categories" class="space-y-2">
                <?php foreach ($categories as $category): ?>
                    <?php $isSelected = $category['idcategory'] == $selectedCategoryId; ?>
                    <div class="relative group">
                        <button class="w-full h-20 overflow-hidden rounded-lg shadow cursor-pointer 
                       hover:ring-2 hover:ring-red-400 focus:outline-none category-btn
                       <?= $isSelected ? 'ring-4 ring-red-500' : '' ?>" data-id="<?= $category['idcategory'] ?>"
                            data-name="<?= htmlspecialchars($category['name']) ?>">
                            <?php if (!empty($category['image'])): ?>
                                <img src="data:image/jpeg;base64,<?= base64_encode($category['image']) ?>"
                                    class="object-cover w-full h-full" alt="Category">
                            <?php else: ?>
                                <div class="flex items-center justify-center w-full h-full text-gray-500 bg-gray-200">No
                                    Image</div>
                            <?php endif; ?>
                        </button>
                        <!-- Edit/Delete Buttons -->
                        <div class="absolute top-0 right-0 flex gap-1 p-1 opacity-0 group-hover:opacity-100">
                            <button onclick="ShowEditCategoryModal(this)" data-id="<?= $category['idcategory'] ?>"
                                data-name="<?= htmlspecialchars($category['name']) ?>"
                                class="px-2 text-white bg-yellow-500 rounded cursor-pointer"><i
                                    class="fas fa-edit"></i></button>
                            <button onclick="DeleteCategory(<?= $category['idcategory'] ?>)"
                                class="px-2 text-white bg-red-500 rounded cursor-pointer"><i
                                    class="fas fa-trash-alt"></i></button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button onclick="ShowAddCategoryModal()"
                class="flex items-center justify-center w-full h-20 text-xl font-bold text-white bg-red-600 rounded-lg">+</button>
        </div>







        <!-- Products Display -->
        <div class="relative w-full p-4 text-white bg-gray-800 rounded-lg shadow">
            <h2 id="selected-category-title" class="mb-4 text-2xl font-bold text-yellow-400"></h2>

            <div id="products" class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-5 p-15">
                <?php foreach ($products as $product): ?>
                    <div onclick="ShowProductDetailModal(this)"
                        class="relative flex flex-col items-center p-4 transition-transform duration-200 bg-white rounded-lg shadow cursor-pointer hover:scale-105"
                        data-id="<?= $product['idproduct'] ?>"
                        data-name="<?= htmlspecialchars($product['name'], ENT_QUOTES) ?>"
                        data-description="<?= htmlspecialchars($product['description'], ENT_QUOTES) ?>"
                        data-price="<?= $product['price'] ?>" data-category="<?= $product['category'] ?>"
                        data-image="data:image/jpeg;base64,<?= base64_encode($product['img']) ?>">

                        <img src="data:image/jpeg;base64,<?= base64_encode($product['img']) ?>" alt="Product Image"
                            class="object-cover w-full h-64 mb-2 rounded" />
                        <h3 class="w-full text-base font-bold text-center text-gray-800 truncate">
                            <?= htmlspecialchars($product['name']) ?>
                        </h3>
                        <p class="text-sm text-gray-600">₱<?= number_format($product['price']) ?></p>
                    </div>
                <?php endforeach; ?>

                <button onclick="ShowAddProductModal()"
                    class="flex items-center justify-center p-4 text-xl font-bold text-white bg-green-600 rounded-lg shadow hover:bg-green-700">
                    +
                </button>
            </div>
        </div>

    </div>




    <!-- Add Category Modal -->
    <div id="add-category-modal"
        class="fixed inset-0 z-40 flex items-center justify-center hidden backdrop-blur bg-black/80">
        <div class="p-6 bg-gray-900 rounded-lg shadow-lg w-96">
            <h2 class="mb-6 text-2xl font-bold text-amber-400">Add Category</h2>
            <form id="addCategoryForm" class="space-y-6" enctype="multipart/form-data">
                <input type="text" name="name" placeholder="Category Name"
                    class="w-full px-4 py-3 text-gray-200 bg-gray-800 border border-gray-700 rounded focus:outline-none focus:ring-2 focus:ring-amber-400"
                    required>
                <label for="add-category-image"
                    class="flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-gray-300 bg-gray-800 border border-gray-700 rounded cursor-pointer hover:bg-gray-700 focus:ring-2 focus:ring-amber-400">
                    <i class="mr-2 fas fa-upload text-amber-400"></i> Choose Image
                </label>
                <input id="add-category-image" type="file" name="image" accept="image/*" class="hidden" required>
            </form>
            <div class="mt-6 space-x-3 text-right">
                <button onclick="HideAddCategoryModal()"
                    class="px-5 py-2 font-semibold text-gray-300 bg-gray-700 rounded hover:bg-gray-600 focus:ring-2 focus:ring-gray-500">
                    Cancel
                </button>
                <button onclick="AddCategory()"
                    class="px-5 py-2 font-semibold text-black rounded bg-amber-400 hover:bg-amber-500 focus:ring-2 focus:ring-amber-400">
                    Add
                </button>
            </div>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div id="edit-category-modal"
        class="fixed inset-0 z-40 flex items-center justify-center hidden backdrop-blur bg-black/80">
        <div class="p-6 bg-gray-900 rounded-lg shadow-lg w-96">
            <h2 class="mb-6 text-2xl font-bold text-amber-400">Edit Category</h2>
            <form id="editCategoryForm" class="space-y-6" enctype="multipart/form-data">
                <input type="hidden" name="idcategory">
                <input type="text" name="name" placeholder="Category Name"
                    class="w-full px-4 py-3 text-gray-200 bg-gray-800 border border-gray-700 rounded focus:outline-none focus:ring-2 focus:ring-amber-400"
                    required>
                <label for="edit-category-image"
                    class="flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-gray-300 bg-gray-800 border border-gray-700 rounded cursor-pointer hover:bg-gray-700 focus:ring-2 focus:ring-amber-400">
                    <i class="mr-2 fas fa-upload text-amber-400"></i> Choose Image
                </label>
                <input id="edit-category-image" type="file" name="image" accept="image/*" class="hidden">
            </form>
            <div class="mt-6 space-x-3 text-right">
                <button onclick="HideEditCategoryModal()"
                    class="px-5 py-2 font-semibold text-gray-300 bg-gray-700 rounded hover:bg-gray-600 focus:ring-2 focus:ring-gray-500">
                    Cancel
                </button>
                <button onclick="EditCategory()"
                    class="px-5 py-2 font-semibold text-black rounded bg-amber-400 hover:bg-amber-500 focus:ring-2 focus:ring-amber-400">
                    Save
                </button>
            </div>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div id="add-product-modal"
        class="fixed inset-0 z-40 flex items-center justify-center hidden backdrop-blur bg-black/80">
        <div class="p-6 bg-gray-900 rounded-lg shadow-lg w-96">
            <h2 class="mb-6 text-2xl font-bold text-amber-400">Add Product</h2>
            <form id="addProductForm" class="space-y-6" enctype="multipart/form-data">
                <input type="hidden" name="category">
                <input type="text" name="name" placeholder="Product Name"
                    class="w-full px-4 py-3 text-gray-200 bg-gray-800 border border-gray-700 rounded focus:outline-none focus:ring-2 focus:ring-amber-400"
                    required>
                <textarea name="description" placeholder="Description"
                    class="w-full px-4 py-3 text-gray-200 bg-gray-800 border border-gray-700 rounded focus:outline-none focus:ring-2 focus:ring-amber-400"></textarea>
                <input type="number" name="price" placeholder="Price" min="0"
                    class="w-full px-4 py-3 text-gray-200 bg-gray-800 border border-gray-700 rounded focus:outline-none focus:ring-2 focus:ring-amber-400"
                    required>
                <label for="add-product-image"
                    class="flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-gray-300 bg-gray-800 border border-gray-700 rounded cursor-pointer hover:bg-gray-700 focus:ring-2 focus:ring-amber-400">
                    <i class="mr-2 fas fa-upload text-amber-400"></i> Choose Image
                </label>
                <input id="add-product-image" type="file" name="img" accept="image/*" class="hidden" required>
            </form>
            <div class="mt-6 space-x-3 text-right">
                <button onclick="HideAddProductModal()"
                    class="px-5 py-2 font-semibold text-gray-300 bg-gray-700 rounded hover:bg-gray-600 focus:ring-2 focus:ring-gray-500">
                    Cancel
                </button>
                <button onclick="AddProduct()"
                    class="px-5 py-2 font-semibold text-black rounded bg-amber-400 hover:bg-amber-500 focus:ring-2 focus:ring-amber-400">
                    Add
                </button>
            </div>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div id="edit-product-modal"
        class="fixed inset-0 z-40 flex items-center justify-center hidden backdrop-blur bg-black/80">
        <div class="p-6 bg-gray-900 rounded-lg shadow-lg w-96">
            <h2 class="mb-6 text-2xl font-bold text-amber-400">Edit Product</h2>
            <form id="editProductForm" class="space-y-6" enctype="multipart/form-data">
                <input type="hidden" name="idproduct">
                <input type="hidden" name="category">
                <input type="text" name="name" placeholder="Product Name"
                    class="w-full px-4 py-3 text-gray-200 bg-gray-800 border border-gray-700 rounded focus:outline-none focus:ring-2 focus:ring-amber-400"
                    required>
                <textarea name="description" placeholder="Description"
                    class="w-full px-4 py-3 text-gray-200 bg-gray-800 border border-gray-700 rounded focus:outline-none focus:ring-2 focus:ring-amber-400"></textarea>
                <input type="number" name="price" placeholder="Price" min="0"
                    class="w-full px-4 py-3 text-gray-200 bg-gray-800 border border-gray-700 rounded focus:outline-none focus:ring-2 focus:ring-amber-400"
                    required>
                <label for="edit-product-image"
                    class="flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-gray-300 bg-gray-800 border border-gray-700 rounded cursor-pointer hover:bg-gray-700 focus:ring-2 focus:ring-amber-400">
                    <i class="mr-2 fas fa-upload text-amber-400"></i> Choose Image
                </label>
                <input id="edit-product-image" type="file" name="img" accept="image/*" class="hidden">
            </form>
            <div class="mt-6 space-x-3 text-right">
                <button onclick="HideEditProductModal()"
                    class="px-5 py-2 font-semibold text-gray-300 bg-gray-700 rounded hover:bg-gray-600 focus:ring-2 focus:ring-gray-500">
                    Cancel
                </button>
                <button onclick="EditProduct()" type="button"
                    class="px-5 py-2 font-semibold text-black rounded bg-amber-400 hover:bg-amber-500 focus:ring-2 focus:ring-amber-400">
                    Update
                </button>
            </div>
        </div>
    </div>


    <!-- Product Detail Modal -->
    <div id="product-detail-modal"
        class="fixed inset-0 z-50 items-center justify-center hidden bg-black/80 backdrop-blur">
        <div class="relative w-11/12 max-w-sm p-6 bg-white rounded-lg shadow-xl">
            <button onclick="HideProductDetailModal()" class="absolute text-gray-600 top-4 left-4 hover:text-black">
                <i class="fas fa-arrow-left"></i>
            </button>

            <img id="detail-image" src="" alt="Product Image"
                class="object-cover w-40 h-40 mx-auto mb-4 rounded-full" />

            <h2 id="detail-name" class="mb-2 text-xl font-bold text-center text-gray-800"></h2>
            <p id="detail-description" class="mb-4 text-sm text-center text-gray-600"></p>
            <p id="detail-price" class="mb-6 text-xl font-semibold text-center text-green-600"></p>

            <button onclick="OrderProduct()"
                class="block w-full px-4 py-2 text-white rounded bg-amber-500 hover:bg-amber-600">
                Order
            </button>
        </div>
    </div>


    <!-- Loading Overlay -->
    <div id="loading-overlay"
        class="fixed inset-0 z-[999] flex items-center hidden justify-center bg-black/80 backdrop-blur">
        <div class="flex flex-col items-center">
            <img src="./assets/images/noodle-loader.gif" alt="Loading..." class="w-32 h-32 mb-4">
            <p class="text-lg font-semibold text-amber-400">Working on it...</p>
        </div>
    </div>

    <!-- Message Modal -->
    <div id="message-modal" class="fixed inset-0 z-50 items-center justify-center hidden bg-black/70">
        <div class="p-4 text-center bg-white rounded-lg w-96">
            <h2 class="mb-2 text-xl font-bold" id="message-title">Message</h2>
            <p id="message-text"></p>
            <div class="mt-4 text-right">
                <button onclick="HideMessageModal()" class="px-4 py-2 text-white bg-red-600 rounded">OK</button>
            </div>
        </div>
    </div>

</body>
<script>
    function ShowAddCategoryModal() {
        $('#add-category-modal').removeClass('hidden').addClass('flex');
    }

    function HideAddCategoryModal() {
        $('#add-category-modal').addClass('hidden').removeClass('flex');
    }

    function ShowEditCategoryModal(btn) {
        const id = $(btn).data('id');
        const name = $(btn).data('name');

        $('#editCategoryForm [name="idcategory"]').val(id);
        $('#editCategoryForm [name="name"]').val(name);

        $('#edit-category-modal').removeClass('hidden').addClass('flex');
    }

    function HideEditCategoryModal() {
        $('#edit-category-modal').addClass('hidden').removeClass('flex');
    }

    function ShowLoading() {
        $('#loading-overlay').removeClass('hidden').addClass('flex');
    }
    function HideLoading() {
        $('#loading-overlay').addClass('hidden').removeClass('flex');
    }

    function ShowMessageModal(title, message) {
        $('#message-title').text(title);
        $('#message-text').text(message);
        $('#message-modal').removeClass('hidden').addClass('flex');
    }
    function HideMessageModal() {
        $('#message-modal').addClass('hidden').removeClass('flex');
        location.reload();
    }

    function AddCategory() {
        ShowLoading();
        const formData = new FormData($('#addCategoryForm')[0]);
        $.ajax({
            url: 'includes/category/create.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: () => {
                HideAddCategoryModal();
                HideLoading();
                ShowMessageModal('Success', 'Category added successfully!');
            },
            error: () => {
                HideLoading();
                ShowMessageModal('Error', 'Failed to add category.');
            }
        });
    }

    function EditCategory() {
        ShowLoading();
        const formData = new FormData($('#editCategoryForm')[0]);
        $.ajax({
            url: 'includes/category/edit.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: () => {
                HideEditCategoryModal();
                HideLoading();
                ShowMessageModal('Success', 'Category updated successfully!');
            },
            error: () => {
                HideLoading();
                ShowMessageModal('Error', 'Failed to update category.');
            }
        });
    }

    function DeleteCategory(id) {
        if (!confirm("Are you sure you want to delete this category?")) return;
        ShowLoading();
        $.post('includes/category/delete.php', { id }, function () {
            HideLoading();
            ShowMessageModal('Deleted', 'Category deleted successfully!');
        }).fail(() => {
            HideLoading();
            ShowMessageModal('Error', 'Failed to delete category.');
        });
    }



    function ShowAddProductModal() {
        $('#add-product-modal').removeClass('hidden').addClass('flex');
    }
    function HideAddProductModal() {
        $('#add-product-modal').addClass('hidden').removeClass('flex');
    }

    function ShowEditProductModal(tile) {
        const form = $('#editProductForm')[0];


        form.idproduct.value = tile.dataset.id;
        form.name.value = tile.dataset.name;
        form.description.value = tile.dataset.description;
        form.price.value = tile.dataset.price;
        form.category.value = tile.dataset.category;
        $('#edit-product-modal').removeClass('hidden').addClass('flex');
    }

    function HideEditProductModal() {
        $('#edit-product-modal').addClass('hidden').removeClass('flex');
    }



    function AddProduct() {
        ShowLoading();
        const formData = new FormData($('#addProductForm')[0]);

        let redirectId = $('input[name="category"]').val();
        $.ajax({
            url: 'includes/product/create.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: () => {
                window.location.href = 'product.php?category=' + redirectId;

            },
            error: () => {
                HideLoading();
                ShowMessageModal('Error', 'Failed to add product.');
            }
        });
    }

    function EditProduct() {
        ShowLoading();
        const formData = new FormData($('#editProductForm')[0]);


        let redirectId = $('input[name="category"]').val();

        $.ajax({
            url: 'includes/product/edit.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: () => {
                window.location.href = 'product.php?category=' + redirectId;
            },
            error: () => {
                HideLoading();
                ShowMessageModal('Error', 'Failed to update product.');
            }
        });
    }




    function DeleteProduct(id) {
        if (!confirm("Are you sure you want to delete this product?")) return;

        $.post("includes/product/delete.php", { id }, () => {
            location.reload();
        }).fail(() => {
            ShowMessageModal('Error', 'Failed to delete product.');
        });
    }



    function ShowProductDetailModal(el) {
        const $el = $(el);
        const $modal = $('#product-detail-modal');

        $('#detail-name').text($el.data('name'));
        $('#detail-description').text($el.data('description'));
        $('#detail-price').text(`₱${parseFloat($el.data('price')).toFixed(2)}`);
        $('#detail-image').attr('src', $el.data('image'));

        $modal.removeClass('hidden').hide().fadeIn(200);
    }

    function HideProductDetailModal() {
        $('#product-detail-modal').fadeOut(200, function () {
            $(this).addClass('hidden');
        });
    }

    function OrderProduct() {
        alert('Order placed! (implement logic here)');
    }




    const selectedCategoryId = <?= json_encode($selectedCategoryId) ?>;

    $(document).ready(function () {
        $('input[type="file"]').on('change', function () {
            const fileInput = $(this);
            const label = $(`label[for="${fileInput.attr('id')}"]`);
            const fileName = this.files?.[0]?.name;

            if (fileName) {
                label.html(`<i class="mr-2 fas fa-file-alt text-amber-400"></i> ${fileName}`);
            } else {
                label.html('<i class="mr-2 fas fa-upload text-amber-400"></i> Choose Image');
            }
        });



        $('.category-btn').on('click', function () {
            let categoryId = $(this).data('id');

            $('.category-btn').removeClass('ring-4 ring-red-500');
            $(this).addClass('ring-4 ring-red-500');

            $('#selected-category-title').text($(this).data('name'));
            $('input[name="category"]').val(categoryId);

            $('#products > div[data-category]').each(function () {
                const productCategory = $(this).data('category');
                if (productCategory == categoryId) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        $(`.category-btn[data-id="${selectedCategoryId}"]`).trigger('click');


        $('.category-btn').on('click', function () {
            selectedCategoryId = $(this).data('id');

            $('.category-btn').removeClass('ring-4 ring-red-500');
            $(this).addClass('ring-4 ring-red-500');


            $('#selected-category-title').text($(this).data('name'));

            $('input[name="category"]').val(selectedCategoryId);

            $('#products > div').each(function () {
                const productCategory = $(this).data('category');
                if (productCategory == selectedCategoryId) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });



    });
</script>

</html>