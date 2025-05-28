<header class="text-white bg-black border-b-2 border-red-500 shadow-md">
    <div class="flex items-center justify-between w-full px-6 py-3">
        <!-- Logo and Tagline -->
        <div class="flex items-center space-x-4">
            <a href="./index.php" class="text-3xl font-extrabold text-red-500">SendNoods</a>
            <span class="text-sm text-gray-300">Your one-stop shop for all things noodles!</span>
        </div>

        <!-- Right Section -->
        <div class="relative flex items-center space-x-4">
              


            <!-- Triple Dot Menu -->
            <div class="relative group">
                <button id="menuToggleBtn"
                    class="text-2xl text-white cursor-pointer hover:text-red-500 focus:outline-none">
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                </button>


                <!-- Dropdown -->
                <div id="menuDropdown"
                    class="absolute right-0 z-10 hidden w-40 mt-2 text-black bg-white rounded-md shadow-lg">
                    <a href="./dashboard.php" class="block px-4 py-2 hover:bg-red-100 hover:text-red-600">Home</a>
                    <a href="./profile.php" class="block px-4 py-2 hover:bg-red-100 hover:text-red-600">Profile</a>
                    <a href="./product.php" class="block px-4 py-2 hover:bg-red-100 hover:text-red-600">Products</a>
                    <a href="./inventory.php" class="block px-4 py-2 hover:bg-red-100 hover:text-red-600">inventory</a>
                    <a href="./user.php" class="block px-4 py-2 hover:bg-red-100 hover:text-red-600">Users</a>
                    <a href="./about.php" class="block px-4 py-2 hover:bg-red-100 hover:text-red-600">About</a>
                    <a href="./contact.php" class="block px-4 py-2 hover:bg-red-100 hover:text-red-600">Contact Us</a>
                    <a href="./includes/logout.php" class="block px-4 py-2 hover:bg-red-100 hover:text-red-600">Logout</a>
                </div>

            </div>
        </div>
    </div>
</header>

<script>
    $(document).ready(function () {
        $('#menuToggleBtn').on('click', function (e) {
            e.stopPropagation(); // Prevents body click from closing immediately
            $('#menuDropdown').toggle(); // Toggle the dropdown
        });

        // Hide the menu if clicking outside
        $(document).on('click', function () {
            $('#menuDropdown').hide();
        });

        // Prevent closing if clicking inside the menu
        $('#menuDropdown').on('click', function (e) {
            e.stopPropagation();
        });
    });
</script>