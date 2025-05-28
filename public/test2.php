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
    <div class="flex h-screen">
        <!-- Sidebar Categories -->
        <div class="flex flex-col w-24 p-2 space-y-2 overflow-y-auto bg-white">
            <div id="categories" class="space-y-2">
                <?php foreach ($categories as $category): ?>
                    <?php $isSelected = $category['idcategory'] == $selectedCategoryId; ?>
                    <div class="relative group">
                        <button class="w-full h-20 overflow-hidden rounded-lg shadow cursor-pointer 
                       hover:ring-2 hover:ring-blue-400 focus:outline-none category-btn
                       <?= $isSelected ? 'ring-4 ring-blue-500' : '' ?>" data-id="<?= $category['idcategory'] ?>"
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
                class="flex items-center justify-center w-full h-20 text-xl font-bold text-white bg-green-500 rounded-lg">+</button>
        </div>

        <!-- Products Display -->
        <div class="flex-1 p-4 overflow-y-auto">
            <h2 id="selected-category-title" class="mb-4 text-2xl font-bold text-gray-700"></h2>
            <div id="products" class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4">
                <?php foreach ($products as $product): ?>
                    <div class="relative p-4 bg-white rounded-lg shadow" data-id="<?= $product['idproduct'] ?>"
                        data-name="<?= htmlspecialchars($product['name'], ENT_QUOTES) ?>"
                        data-description="<?= htmlspecialchars($product['description'], ENT_QUOTES) ?>"
                        data-price="<?= $product['price'] ?>" data-category="<?= $product['category'] ?>">

                        <img src="data:image/jpeg;base64,<?= base64_encode($product['img']) ?>" alt="Product Image"
                            class="object-cover w-32 h-32 rounded" />

                        <h3 class="text-lg font-semibold"><?= htmlspecialchars($product['name']) ?></h3>
                        <p class="text-sm text-gray-600">₱<?= number_format($product['price']) ?></p>

                        <div class="absolute space-x-2 top-2 right-2">
                            <button onclick="ShowEditProductModal(this.parentElement.parentElement)" class="text-blue-600">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="DeleteProduct(<?= $product['idproduct'] ?>)" class="text-red-600">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
                <button onclick="ShowAddProductModal()" class="px-4 py-2 mt-4 text-white bg-green-600 rounded">
                    + Add Product
                </button>

            </div>
        </div>

    </div>

    <!-- modals -->
    <div id="add-category-modal" class="fixed inset-0 items-center justify-center hidden bg-black/70 ">
        <div class="p-4 bg-white rounded-lg w-96">
            <h2 class="mb-4 text-xl font-bold">Add Category</h2>
            <form id="addCategoryForm" class="space-y-4" enctype="multipart/form-data">
                <input type="text" name="name" placeholder="Category Name" class="w-full px-4 py-2 border rounded">
                <input type="file" name="image" accept="image/*" class="w-full">
            </form>
            <div class="space-x-2 text-right">
                <button onclick="HideAddCategoryModal()"
                    class="px-4 py-2 text-white bg-gray-500 rounded">Cancel</button>
                <button onclick="AddCategory()" class="px-4 py-2 text-white bg-blue-600 rounded">Add</button>
            </div>
        </div>
    </div>

    <div id="edit-category-modal" class="fixed inset-0 items-center justify-center hidden bg-black/70 ">
        <div class="p-4 bg-white rounded-lg w-96">
            <h2 class="mb-4 text-xl font-bold">Edit Category</h2>
            <form id="editCategoryForm" class="space-y-4" enctype="multipart/form-data">
                <input type="hidden" name="idcategory">
                <input type="text" name="name" placeholder="Category Name" class="w-full px-4 py-2 border rounded">
                <input type="file" name="image" accept="image/*" class="w-full">
            </form>
            <div class="space-x-2 text-right">
                <button onclick="HideEditCategoryModal()"
                    class="px-4 py-2 text-white bg-gray-500 rounded">Cancel</button>
                <button onclick="EditCategory()" class="px-4 py-2 text-white bg-blue-600 rounded">Save</button>
            </div>
        </div>
    </div>


    <div id="add-product-modal" class="fixed inset-0 items-center justify-center hidden bg-black/70">
        <div class="p-4 bg-white rounded-lg w-96">
            <h2 class="mb-4 text-xl font-bold">Add Product</h2>
            <form id="addProductForm" class="space-y-4" enctype="multipart/form-data">
                <input type="hidden" name="category" value="<?= $selectedCategoryId ?>">
                <input type="text" name="name" placeholder="Product Name" class="w-full px-4 py-2 border rounded">
                <textarea name="description" placeholder="Description"
                    class="w-full px-4 py-2 border rounded"></textarea>
                <input type="number" name="price" placeholder="Price" class="w-full px-4 py-2 border rounded">
                <input type="file" name="img" accept="image/*" required>
            </form>
            <div class="space-x-2 text-right">
                <button onclick="HideAddProductModal()" class="px-4 py-2 text-white bg-gray-500 rounded">Cancel</button>
                <button onclick="AddProduct()" class="px-4 py-2 text-white bg-blue-600 rounded">Add</button>
            </div>
        </div>
    </div>


    <div id="edit-product-modal" class="fixed inset-0 items-center justify-center hidden bg-black/70">
        <div class="p-4 bg-white rounded-lg w-96">
            <h2 class="mb-4 text-xl font-bold">Edit Product</h2>
            <form id="editProductForm" class="space-y-4" enctype="multipart/form-data">
                <input type="hidden" name="idproduct">
                <input type="text" name="name" placeholder="Product Name" class="w-full px-4 py-2 border rounded">
                <textarea name="description" placeholder="Description"
                    class="w-full px-4 py-2 border rounded"></textarea>
                <input type="number" name="price" placeholder="Price" class="w-full px-4 py-2 border rounded">
                <input type="file" name="img" accept="image/*">
            </form>
            <div class="space-x-2 text-right">
                <button onclick="HideEditProductModal()"
                    class="px-4 py-2 text-white bg-gray-500 rounded">Cancel</button>
                <button onclick="EditProduct()" type="button" class="px-4 py-2 text-white bg-blue-600 rounded">Update</button>
            </div>
        </div>
    </div>


    <!-- Loading Overlay -->
    <div id="loading-overlay" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/70 ">
        <div class="w-16 h-16 border-4 border-blue-500 rounded-full border-t-transparent animate-spin"></div>
    </div>

    <!-- Message Modal -->
    <div id="message-modal" class="fixed inset-0 z-50 items-center justify-center hidden bg-black/70">
        <div class="p-4 text-center bg-white rounded-lg w-96">
            <h2 class="mb-2 text-xl font-bold" id="message-title">Message</h2>
            <p id="message-text"></p>
            <div class="mt-4 text-right">
                <button onclick="HideMessageModal()" class="px-4 py-2 text-white bg-blue-600 rounded">OK</button>
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
        form.id.value = tile.dataset.id;
        form.name.value = tile.dataset.name;
        form.description.value = tile.dataset.description;
        form.price.value = tile.dataset.price;
        $('#edit-product-modal').removeClass('hidden').addClass('flex');
    }

    function HideEditProductModal() {
        $('#edit-product-modal').addClass('hidden').removeClass('flex');
    }



    function AddProduct() {
        ShowLoading();
        const formData = new FormData($('#addProductForm')[0]);

        let redirectId = $('input[name="category"]').val();
        alert(redirectId);
        $.ajax({
            url: 'includes/product/create.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: () => {
                window.location.href = 'test2.php?category=' + redirectId;

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

        console.log(formData);
        alert(formData);

        $.ajax({
            url: 'includes/product/edit.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: () => {
                location.reload();
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

    const selectedCategoryId = <?= json_encode($selectedCategoryId) ?>;

    $(document).ready(function () {

        // Attach click handler
        $('.category-btn').on('click', function () {
            let categoryId = $(this).data('id');

            // Highlight the selected category
            $('.category-btn').removeClass('ring-4 ring-blue-500');
            $(this).addClass('ring-4 ring-blue-500');

            // Set title and form input
            $('#selected-category-title').text($(this).data('name'));
            $('input[name="category"]').val(categoryId);

            // Show only products with matching data-category
            $('#products > div[data-category]').each(function () {
                const productCategory = $(this).data('category');
                if (productCategory == categoryId) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // 🔥 Trigger click on the selected category to filter products on load
        $(`.category-btn[data-id="${selectedCategoryId}"]`).trigger('click');


        // Filter products on category click
        $('.category-btn').on('click', function () {
            selectedCategoryId = $(this).data('id'); // Save selected category ID

            $('.category-btn').removeClass('ring-4 ring-blue-500');
            $(this).addClass('ring-4 ring-blue-500');


            $('#selected-category-title').text($(this).data('name'));

            // Update hidden input value for the form
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