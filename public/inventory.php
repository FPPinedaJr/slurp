<?php
// index.php
include_once "includes/connect_db.php";

$stmt = $pdo->query("SELECT idingredient, name, qty, image FROM ingredient");
$ingredients = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>SendNoods | Inventory Management</title>
</head>

<body class="flex justify-center bg-black md:p-4">
    <main class="w-11/12 my-10 h-vh md:w-4/5">

        <div class="flex items-center justify-between my-10">
            <h1 class="text-xl font-bold text-yellow-500 md:text-4xl">Inventory Management</h1>
            <button onclick="showAddModal()"
                class="px-4 py-2 font-semibold text-black rounded cursor-pointer bg-amber-500 hover:bg-amber-600">
                New
            </button>
        </div>


        <div id="ingredient-grid" class="grid grid-cols-2 gap-6 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
            <?php foreach ($ingredients as $ingredient):
                $img = $ingredient['image'] ? 'data:image/jpeg;base64,' . base64_encode($ingredient['image']) : 'https://via.placeholder.com/150';
                $id = $ingredient['idingredient'];
                $name = htmlspecialchars($ingredient['name']);
                $qty = (int) $ingredient['qty'];
                ?>
                <div id="tile-<?= $id ?>"
                    class="relative p-3 text-gray-200 transition-all bg-black border shadow-lg border-rose-500 shadow-rose-500 rounded-2xl ">

                    <div class="absolute z-10 flex items-center justify-end gap-2 px-2 top-2 left-2 right-2">
                        <button onclick="confirmDelete(<?= $ingredient['idingredient'] ?>)"
                            class="p-2 text-red-400 rounded-md shadow-md cursor-pointer bg-gray-800/70 hover:text-red-600 hover:bg-gray-700">
                            <i class="fas fa-trash"></i>
                        </button>
                        <button onclick="showEditModal(<?= $id ?>, '<?= $name ?>', <?= $qty ?>)"
                            class="p-2 text-yellow-400 rounded-md shadow-md cursor-pointer bg-gray-800/70 hover:text-yellow-500 hover:bg-gray-700">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>

                    <img src="<?= $img ?>" alt="<?= $name ?>"
                        class="object-cover w-full h-40 mb-3 border shadow-inner border-rose-500 rounded-xl">

                    <div class="text-lg font-bold text-center text-white truncate"><?= $name ?></div>

                    <div class="flex items-center justify-between pt-3 mt-4 border-t border-rose-500">
                        <button class="text-2xl text-red-400 cursor-pointer hover:text-red-300 btn-qty" data-id="<?= $id ?>"
                            data-action="minus">
                            <i class="fas fa-minus-circle"></i>
                        </button>

                        <span id="qty-<?= $id ?>" class="text-xl font-semibold text-white"><?= $qty ?></span>

                        <button class="text-2xl text-red-400 cursor-pointer hover:text-red-300 btn-qty" data-id="<?= $id ?>"
                            data-action="plus">
                            <i class="fas fa-plus-circle"></i>
                        </button>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>

    </main>


    <div id="add-ingredient-modal"
        class="fixed inset-0 z-40 flex items-center justify-center hidden backdrop-blur bg-black/80">
        <div class="p-6 bg-gray-900 rounded-lg shadow-lg w-96">
            <h2 class="mb-6 text-2xl font-bold text-amber-400">Add Ingredient</h2>
            <form id="addIngredientForm" class="space-y-6" enctype="multipart/form-data">
                <input type="text" name="name" placeholder="Ingredient Name"
                    class="w-full px-4 py-3 text-gray-200 bg-gray-800 border border-gray-700 rounded focus:outline-none focus:ring-2 focus:ring-amber-400"
                    required>
                <input hidden value="0" type="number" name="qty" placeholder="Quantity" min="0" required>

                <!-- File input label -->
                <label id="file-upload-label" for="file-upload"
                    class="flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-gray-300 bg-gray-800 border border-gray-700 rounded cursor-pointer hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-400">
                    <i class="mr-2 fas fa-upload text-amber-400"></i>
                    Choose Image
                </label>
                <input id="file-upload" type="file" name="image" accept="image/*" class="hidden" required>
            </form>
            <div class="mt-6 space-x-3 text-right">
                <button onclick="hideAddModal()"
                    class="px-5 py-2 font-semibold text-gray-300 bg-gray-700 rounded cursor-pointer hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Cancel
                </button>
                <button onclick="addIngredient()"
                    class="px-5 py-2 font-semibold text-black rounded cursor-pointer bg-amber-400 hover:bg-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-400">
                    Add
                </button>
            </div>
        </div>
    </div>




    <!-- Edit Ingredient Modal -->
    <div id="edit-ingredient-modal" class="fixed inset-0 z-40 flex items-center justify-center hidden bg-black/80">
        <div class="p-6 bg-gray-900 rounded-lg shadow-lg w-96">
            <h2 class="mb-6 text-2xl font-bold text-amber-400">Edit Ingredient</h2>
            <form id="editIngredientForm" class="space-y-6" enctype="multipart/form-data">
                <input type="hidden" name="id">
                <input type="text" name="name" placeholder="Ingredient Name"
                    class="w-full px-4 py-3 text-gray-200 bg-gray-800 border border-gray-700 rounded focus:outline-none focus:ring-2 focus:ring-amber-400"
                    required>
                <input hidden type="number" name="qty" min="0" required>

                <!-- File input label -->
                <label for="edit-file-upload"
                    class="flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-gray-300 bg-gray-800 border border-gray-700 rounded cursor-pointer hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-400">
                    <i class="mr-2 fas fa-upload text-amber-400"></i>
                    Replace Image
                </label>
                <input id="edit-file-upload" type="file" name="image" accept="image/*" class="hidden">
            </form>

            <div class="mt-6 space-x-3 text-right">
                <button onclick="hideEditModal()"
                    class="px-5 py-2 font-semibold text-gray-300 bg-gray-700 rounded cursor-pointer hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Cancel
                </button>
                <button onclick="editIngredient()"
                    class="px-5 py-2 font-semibold text-black rounded cursor-pointer bg-amber-400 hover:bg-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-400">
                    Save
                </button>
            </div>
        </div>
    </div>




    <!-- Message Modal -->
    <div id="message-modal"
        class="fixed inset-0 z-50 flex items-center justify-center hidden backdrop-blur-xl bg-black/70">
        <div class="p-6 text-center bg-gray-900 border rounded-lg shadow-lg w-96 border-amber-400">
            <h2 class="mb-3 text-2xl font-bold text-amber-400" id="message-title">Message</h2>
            <p id="message-text" class="text-gray-200"></p>
            <div class="mt-6 text-right">
                <button onclick="hideMessageModal()"
                    class="px-5 py-2 font-semibold text-black rounded cursor-pointer bg-amber-400 hover:bg-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-400">
                    OK
                </button>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="delete-confirm-modal"
        class="fixed inset-0 z-50 flex items-center justify-center hidden backdrop-blur-xl bg-black/70">
        <div class="p-6 text-center bg-gray-900 border border-red-600 rounded-lg shadow-lg">
            <h2 class="mb-3 text-2xl font-bold text-red-500">Delete Ingredient</h2>
            <p class="text-gray-200">Are you sure you want to delete this ingredient?</p>
            <div class="flex justify-end gap-2 mt-6">
                <button onclick="hideDeleteModal()"
                    class="px-5 py-2 font-semibold text-gray-200 bg-gray-700 rounded cursor-pointer hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Cancel
                </button>
                <button id="confirm-delete-btn"
                    class="px-5 py-2 font-semibold text-white bg-red-600 rounded cursor-pointer hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                    Delete
                </button>
            </div>
        </div>
    </div>


    <!-- Noodle Shop Loading Overlay -->
    <div id="loading-overlay"
        class="fixed inset-0 z-[999] flex items-center hidden justify-center bg-black/80 backdrop-blur">
        <div class="flex flex-col items-center">
            <img src="./assets/images/noodle-loader.gif" alt="Loading..." class="w-32 h-32 mb-4">
            <p class="text-lg font-semibold text-amber-400">Working on it...</p>
        </div>
    </div>

</body>
<script>

    function showLoading() {
        $('#loading-overlay').removeClass('hidden');
    }
    function hideLoading() {
        $('#loading-overlay').addClass('hidden');
    }

    let deleteTargetId = null;

    function confirmDelete(id) {
        deleteTargetId = id;
        $('#delete-confirm-modal').removeClass('hidden').addClass('flex');
    }

    function hideDeleteModal() {
        $('#delete-confirm-modal').addClass('hidden');
        deleteTargetId = null;
    }

    $('#confirm-delete-btn').on('click', function () {
        if (!deleteTargetId) return;
        showLoading();
        $.ajax({
            url: 'includes/inventory/delete.php',
            method: 'POST',
            data: { id: deleteTargetId },
            success: function (res) {
                const response = JSON.parse(res);
                if (response.success) {
                    location.reload();
                } else {
                    showMessage("Error", response.error || "Delete failed.");
                }
            }
        });
    });


    function editIngredient() {
        const form = $('#editIngredientForm')[0];
        const formData = new FormData(form);
        showLoading();

        $.ajax({
            url: 'includes/inventory/edit.php',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                const response = JSON.parse(res);
                if (response.success) {
                    location.reload();
                } else {
                    showMessage("Error", response.error || "Update failed.");
                }
            }
        });
    }


    function addIngredient() {
        const form = $('#addIngredientForm')[0];
        const formData = new FormData(form);
        showLoading();

        $.ajax({
            url: 'includes/inventory/create.php',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                const response = JSON.parse(res);
                if (response.success) {
                    location.reload();
                } else {
                    showMessage("Error", response.error || "Failed to add ingredient.");
                }
            }
        });
    }


    function showAddModal() {
        $('#add-ingredient-modal').removeClass('hidden').addClass('flex');
    }
    function hideAddModal() {
        $('#add-ingredient-modal').addClass('hidden').removeClass('flex');
    }

    function showEditModal(id, name, qty) {
        const modal = $('#edit-ingredient-modal');
        modal.find('input[name=id]').val(id);
        modal.find('input[name=name]').val(name);
        modal.find('input[name=qty]').val(qty);
        modal.removeClass('hidden').addClass('flex');
    }
    function hideEditModal() {
        $('#edit-ingredient-modal').addClass('hidden').removeClass('flex');
    }

    function showMessage(title, message) {
        $('#message-title').text(title);
        $('#message-text').text(message);
        $('#message-modal').removeClass('hidden').addClass('flex');
    }
    function hideMessageModal() {
        $('#message-modal').addClass('hidden').removeClass('flex');
    }


    $('#file-upload').on('change', function () {
        const label = $('#file-upload-label');
        if (this.files && this.files.length > 0) {
            label.html(`<i class="mr-2 fas fa-file-alt text-amber-400"></i> ${this.files[0].name}`);
        } else {
            label.html('<i class="mr-2 fas fa-upload text-amber-400"></i> Choose Image');
        }
    });


    $(document).ready(function () {
        const saveTimers = {};

        $(document).on('click', '.btn-qty', function () {
            const id = $(this).data('id');
            const action = $(this).data('action');
            const qtyElem = $("#qty-" + id);
            let qty = parseInt(qtyElem.text());

            qty = action === 'plus' ? qty + 1 : Math.max(0, qty - 1);
            qtyElem.text(qty);


            if (saveTimers[id]) {
                clearTimeout(saveTimers[id]);
            }

            saveTimers[id] = setTimeout(() => {
                $.ajax({
                    url: 'includes/inventory/update.php',
                    type: 'POST',
                    dataType: 'json',
                    data: { id: id, qty: qty },
                    success: function (response) {
                        if (response.success) {
                            return;
                        } else {
                            showMessage("Error", response.error || "Update failed.");
                        }
                    },
                });
                delete saveTimers[id];
            }, 1500);
        });
    });

</script>

</html>