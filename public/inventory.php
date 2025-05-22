<?php
require_once __DIR__ . "/includes/connect_db.php";

// Fetch idingredient, name, qty, and image blob from DB
$stmt = $pdo->query("SELECT idingredient, name, qty, image FROM ingredient");
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Convert BLOB image to base64 for each item (or use placeholder)
foreach ($items as &$item) {
    if (!empty($item['image'])) {
        $item['img'] = 'data:image/jpeg;base64,' . base64_encode($item['image']);
    } else {
        $item['img'] = './assets/images/default.png'; // fallback image path
    }
}
// Free the reference
unset($item);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>SendNoods Menu</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black p-6 text-white">

  <div class="max-w-7xl mx-auto">
    <h1 class="text-3xl font-bold mb-6 text-red-600 text-center">Ramen Inventory</h1>

    <!-- Add Ingredient Button -->
    <div class="flex justify-center mb-6">
      <button id="add-ingredient-btn" class="bg-yellow-500 hover:bg-yellow-600 px-6 py-3 rounded text-black font-bold text-lg transition">+ Add Ingredient</button>
    </div>

    <div id="menu-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      <!-- Cards will be generated here -->
    </div>
  </div>

  <!-- Modal -->
  <div id="modal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-50 px-4">
    <div class="bg-gray-900 rounded-lg p-10 w-full max-w-5xl max-h-[90vh] overflow-auto text-white relative">
      <button id="modal-close" class="absolute top-3 right-4 text-red-600 hover:text-red-800 font-bold text-3xl leading-none">&times;</button>
      
      <h2 id="modal-item-name" class="text-4xl font-bold mb-6 text-red-600"></h2>

      <label for="item-name" class="block mb-2 font-semibold text-white text-lg">Name</label>
      <input id="item-name" type="text" class="w-full p-3 rounded bg-black border border-red-600 text-white mb-4" placeholder="Enter ingredient name" />

      <label for="item-qty" class="block mb-2 font-semibold text-white text-lg">Quantity</label>
      <input id="item-qty" type="number" min="0" class="w-full p-3 rounded bg-black border border-red-600 text-white mb-4" placeholder="Enter quantity" />

      <label for="item-img-file" class="block mb-2 font-semibold text-white text-lg">Image Upload</label>
      <input type="file" id="item-img-file" accept="image/*" class="w-full p-3 rounded bg-black border border-red-600 text-white mb-4" />

      <img id="img-preview" src="" alt="Image Preview" class="mx-auto mb-6 rounded-lg max-h-48 border border-red-600 hidden" />

      <label for="item-description" class="block mb-2 font-semibold text-white text-lg">Ingredients / Description</label>
      <textarea id="item-description" rows="8" class="w-full p-4 rounded bg-black border border-red-600 text-white resize-none mb-10 text-lg" placeholder="Enter description or ingredients..."></textarea>

      <div class="flex justify-center space-x-4">
        <button id="save-btn" class="bg-yellow-500 hover:bg-yellow-600 px-6 py-3 rounded text-black font-bold text-lg transition">Save</button>
        <button id="delete-btn" class="bg-red-600 hover:bg-red-700 px-6 py-3 rounded text-white font-bold text-lg transition">Delete</button>
      </div>
    </div>
  </div>

  <script>
    // Pass PHP ingredient data to JS
    let menuItems = <?php echo json_encode($items, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;

    const container = document.getElementById("menu-container");
    const modal = document.getElementById("modal");
    const modalClose = document.getElementById("modal-close");
    const modalItemName = document.getElementById("modal-item-name");
    const inputName = document.getElementById("item-name");
    const inputQty = document.getElementById("item-qty");
    const inputDescription = document.getElementById("item-description");
    const inputImgFile = document.getElementById("item-img-file");
    const imgPreview = document.getElementById("img-preview");
    const saveBtn = document.getElementById("save-btn");
    const deleteBtn = document.getElementById("delete-btn");
    const addIngredientBtn = document.getElementById("add-ingredient-btn");

    let currentItem = null;    // currently edited item
    let isNewItem = false;     // flag if modal is for new ingredient
    let currentItemImgData = null; // stores base64 image for new upload

    // Ensure all items have description property
    menuItems.forEach(item => {
      if (!item.description) item.description = "";
    });

    // Render all cards
    function renderCards() {
      container.innerHTML = ""; // clear
      menuItems.forEach(item => {
        const card = document.createElement("div");
        card.className = "bg-black rounded-xl shadow-lg flex flex-col items-center p-4 w-full h-[480px] border border-red-600 cursor-pointer hover:bg-red-900 transition";
        card.innerHTML = `
          <img src="${item.img}" alt="${item.name}" class="h-36 object-cover rounded-lg border border-red-600" />
          <h2 class="text-center text-xl font-semibold mt-4 text-red-600">${item.name}</h2>
          <p class="text-sm mt-2 text-gray-300 text-center px-2">Qty in stock: ${item.qty}</p>
          <div class="flex items-center mt-4 space-x-3 select-none">
            <button class="quantity-decrease bg-red-600 hover:bg-red-700 text-white font-bold text-xl px-3 rounded">−</button>
            <span class="quantity-value text-white font-bold text-lg min-w-[30px] text-center">1</span>
            <button class="quantity-increase bg-yellow-500 hover:bg-yellow-600 text-black font-bold text-xl px-3 rounded">+</button>
          </div>
          <p class="description-text text-sm mt-2 text-gray-300 text-center px-2">${item.description}</p>
        `;

        // Quantity buttons
        const decreaseBtn = card.querySelector(".quantity-decrease");
        const increaseBtn = card.querySelector(".quantity-increase");
        const quantityDisplay = card.querySelector(".quantity-value");

        decreaseBtn.addEventListener("click", (e) => {
          e.stopPropagation();
          let currentQty = parseInt(quantityDisplay.textContent, 10);
          if (currentQty > 1) {
            quantityDisplay.textContent = currentQty - 1;
          }
        });

        increaseBtn.addEventListener("click", (e) => {
          e.stopPropagation();
          let currentQty = parseInt(quantityDisplay.textContent, 10);
          quantityDisplay.textContent = currentQty + 1;
        });

        // Open modal on card click
        card.addEventListener("click", () => {
          openModalForItem(item, false);
        });

        container.appendChild(card);
      });
    }

    // Open modal for an existing or new item
    function openModalForItem(item, newItem) {
      currentItem = item;
      isNewItem = newItem;

      modalItemName.textContent = newItem ? "Add New Ingredient" : item.name;
      inputName.value = item.name || "";
      inputQty.value = item.qty || 0;
      inputDescription.value = item.description || "";

      // Image preview handling
      currentItemImgData = null;
      inputImgFile.value = "";
      if (item.img && item.img.startsWith('data:')) {
        imgPreview.src = item.img;
        imgPreview.classList.remove("hidden");
      } else {
        imgPreview.src = "";
        imgPreview.classList.add("hidden");
      }

      // Show/hide Delete button
      deleteBtn.style.display = newItem ? "none" : "inline-block";

      modal.classList.remove("hidden");
    }

    // Clear modal inputs
    function clearModalInputs() {
      currentItem = null;
      isNewItem = false;
      currentItemImgData = null;
      inputName.value = "";
      inputQty.value = "";
      inputDescription.value = "";
      inputImgFile.value = "";
      imgPreview.src = "";
      imgPreview.classList.add("hidden");
      modalItemName.textContent = "";
      deleteBtn.style.display = "inline-block";
    }

    // Close modal
    modalClose.addEventListener("click", () => {
      modal.classList.add("hidden");
      clearModalInputs();
    });

    // Close modal when clicking outside modal content
    modal.addEventListener("click", (e) => {
      if (e.target === modal) {
        modal.classList.add("hidden");
        clearModalInputs();
      }
    });

    // Handle file input change to preview image
    inputImgFile.addEventListener("change", () => {
      const file = inputImgFile.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
          imgPreview.src = e.target.result;
          imgPreview.classList.remove("hidden");
          currentItemImgData = e.target.result;
        };
        reader.readAsDataURL(file);
      } else {
        imgPreview.src = "";
        imgPreview.classList.add("hidden");
        currentItemImgData = null;
      }
    });

    // Save button click - update existing or add new ingredient (frontend only)
    saveBtn.addEventListener("click", () => {
      const nameVal = inputName.value.trim();
      const qtyVal = parseInt(inputQty.value, 10);
      const descVal = inputDescription.value.trim();

      if (!nameVal) {
        alert("Please enter a name.");
        return;
      }
      if (isNaN(qtyVal) || qtyVal < 0) {
        alert("Please enter a valid quantity (0 or more).");
        return;
      }

      if (isNewItem) {
        // Add new ingredient object with a new ID (max ID + 1)
        const newId = menuItems.length ? Math.max(...menuItems.map(i => parseInt(i.idingredient))) + 1 : 1;
        const newItem = {
          idingredient: newId.toString(),
          name: nameVal,
          qty: qtyVal,
          description: descVal,
          img: currentItemImgData || './assets/images/default.png'
        };
        menuItems.push(newItem);
      } else {
        // Update current item
        currentItem.name = nameVal;
        currentItem.qty = qtyVal;
        currentItem.description = descVal;
        if (currentItemImgData) {
          currentItem.img = currentItemImgData;
        }
      }

      renderCards();
      modal.classList.add("hidden");
      clearModalInputs();
    });

    // Delete button click - remove ingredient from array (frontend only)
    deleteBtn.addEventListener("click", () => {
      if (!currentItem) return;

      if (confirm(`Are you sure you want to delete "${currentItem.name}"?`)) {
        menuItems = menuItems.filter(item => item.idingredient !== currentItem.idingredient);
        renderCards();
        modal.classList.add("hidden");
        clearModalInputs();
      }
    });

    // Add Ingredient button click
    addIngredientBtn.addEventListener("click", () => {
      openModalForItem({
        idingredient: "",
        name: "",
        qty: 0,
        description: "",
        img: ""
      }, true);
    });

    // Initial render
    renderCards();
  </script>
</body>
</html>
