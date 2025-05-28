<header class="text-white bg-black shadow-md">
    <div class="flex items-center justify-between w-full px-6 py-3">
        <!-- Logo and Tagline -->
        <div class="flex items-center space-x-4">
            <a href="./index.php" class="text-3xl font-extrabold text-red-500">SendNoods</a>
            <span class="text-sm text-gray-300">Your one-stop shop for all things noodles!</span>
        </div>

        <!-- Right Section -->
        <div class="relative flex items-center space-x-4">
            <!-- Card with Number -->
            <div class="relative px-3 py-1 text-sm font-semibold text-white bg-red-500 rounded-full shadow-md">
                <i class="fa-solid fa-cart-shopping"></i>
                <span
                    class="absolute flex items-center justify-center w-5 h-5 text-xs font-bold text-red-600 bg-white rounded-full -top-2 -right-2">
                    3
                </span>
            </div>

            <!-- Triple Dot Menu -->
            <div class="relative group">
                <button class="text-white hover:text-red-500 focus:outline-none">
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                </button>

                <!-- Dropdown -->
                <div
                    class="absolute right-0 z-10 hidden w-40 mt-2 text-black bg-white rounded-md shadow-lg group-hover:block">
                    <a href="./dashboard.php" class="block px-4 py-2 hover:bg-red-100 hover:text-red-600">Home</a>
                    <a href="./profile.php" class="block px-4 py-2 hover:bg-red-100 hover:text-red-600">Profile</a>
                    <a href="./about.php" class="block px-4 py-2 hover:bg-red-100 hover:text-red-600">About</a>
                    <a href="./contact.php" class="block px-4 py-2 hover:bg-red-100 hover:text-red-600">Contact Us</a>
                    <a href="./logout.php" class="block px-4 py-2 hover:bg-red-100 hover:text-red-600">Logout</a>
                </div>
            </div>
        </div>
    </div>
</header>