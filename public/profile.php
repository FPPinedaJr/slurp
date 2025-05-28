<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: index.php");
  exit;
}
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/output.css?v=0.1">
    <link rel="stylesheet" href="./assets/css/fontawesome/all.min.css">
    <link rel="stylesheet" href="./assets/css/fontawesome/fontawesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <script src="./assets/js/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lozad"></script>
    <title>SendNoods | Profile</title>
  </head>
  <style>
    body {
      background: #000;
      color: #dc2626;
    }

    #main-blur-blur {
      transition: filter 0.2s;
    }

    .modal-blur-bg #main-blur-blur {
      filter: blur(2.5px);
    }
  </style>
</head>

<body class="min-h-screen text-red-600 bg-black">
  <?php include_once "includes/header.php"; ?>

  <div id="main-blur-blur">
    <main class="container py-10 mx-auto">
      <div class="flex flex-col justify-center gap-8 lg:flex-row">
        <div class="flex flex-col items-center w-full max-w-md">
          <!-- profile card -->
          <div class="w-full p-8 mb-8 bg-black border-2 border-red-600 shadow-lg rounded-xl">
            <div class="mb-6 text-center">
              <svg class="mx-auto mb-2 text-red-600" width="64" height="64" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 12c2.7 0 8 1.34 8 4v2H4v-2c0-2.66 5.3-4 8-4zm0-2a4 4 0 100-8 4 4 0 000 8z" />
              </svg>
              <h2 class="mb-1 text-2xl font-bold text-red-600">
                <?php echo htmlspecialchars($user['f_name'] . ' ' . $user['l_name']); ?></h2>
              <div class="flex justify-center gap-3 mt-3">
                <button type="button"
                  class="px-4 py-2 font-bold text-white bg-red-600 rounded-full shadow hover:bg-red-700"
                  id="showProfileModal">
                  <svg class="inline mr-2" width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 12c2.7 0 8 1.34 8 4v2H4v-2c0-2.66 5.3-4 8-4zm0-2a4 4 0 100-8 4 4 0 000 8z" />
                  </svg>
                  View Profile
                </button>
              </div>
            </div>
            <div class="mb-6">
              <!-- noodspro -->
              <div class="p-4 text-center shadow-lg rounded-2xl"
                style="background: linear-gradient(120deg, #1a1a1a 60%, #dc2626 100%); border: 2px solid #dc2626;">
                <div class="flex items-center justify-center mb-1">
                  <span class="mr-2 text-lg font-bold text-yellow-400">20%</span>
                  <svg class="mr-2 text-yellow-400" width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                    <path
                      d="M17 7V3H7v4H3v14h18V7h-4zm-8-2h6v2H9V5zm10 16H5V9h14v12zm-7-2c2.21 0 4-1.79 4-4h-2a2 2 0 01-4 0H7c0 2.21 1.79 4 4 4z" />
                  </svg>
                  <span class="text-base font-bold text-white" style="letter-spacing:1px;">OFF!</span>
                </div>
                <div class="mb-1 text-base font-bold text-white" style="letter-spacing:1px;">
                  Save with <span class="text-yellow-400">NoodsPro!</span>
                </div>
                <div class="mb-2 text-sm text-white/70">
                  <svg class="inline mr-1 text-red-600" width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                    <path
                      d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                  </svg>
                  FREE for 30 days
                </div>
                <a href="#"
                  class="inline-block px-4 py-2 mt-2 text-base font-bold text-red-700 bg-yellow-400 rounded-full shadow hover:bg-yellow-300">
                  <svg class="inline mr-2" width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M10 17l5-5-5-5v10z" />
                  </svg>
                  Start your free trial
                </a>
              </div>
            </div>
            <!-- tiles -->
            <div class="grid grid-cols-1 gap-4 mb-6 sm:grid-cols-3">
              <div class="flex flex-col items-center p-4 bg-black border border-red-600 shadow rounded-xl">
                <svg class="mb-2 text-red-600" width="32" height="32" fill="currentColor" viewBox="0 0 24 24">
                  <path
                    d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                </svg>
                <span class="font-bold text-red-600">Favorites</span>
                <span class="text-sm text-white/70">Your most loved dishes</span>
              </div>
              <div class="flex flex-col items-center p-4 bg-black border border-red-600 shadow rounded-xl">
                <svg class="mb-2 text-red-600" width="32" height="32" fill="currentColor" viewBox="0 0 24 24">
                  <path
                    d="M20 6h-2V4a2 2 0 00-2-2H8a2 2 0 00-2 2v2H4a2 2 0 00-2 2v12a2 2 0 002 2h16a2 2 0 002-2V8a2 2 0 00-2-2zm-6 12a4 4 0 110-8 4 4 0 010 8zm-6-8V8h12v2H6z" />
                </svg>
                <span class="font-bold text-red-600">Branches</span>
                <span class="text-sm text-white/70">Find a SendNoods near you</span>
              </div>
              <div class="flex flex-col items-center p-4 bg-black border border-red-600 shadow rounded-xl">
                <svg class="mb-2 text-yellow-400" width="32" height="32" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                </svg>
                <span class="font-bold text-red-600">Points</span>
                <span class="text-sm text-white/70">Earn and redeem rewards</span>
              </div>
            </div>
            <!-- paynoods -->
            <div class="p-4 mb-6 bg-black border border-red-600 shadow rounded-xl">
              <div class="flex items-center justify-between mb-1 text-lg font-bold text-red-600">
                <span><svg class="inline mr-2" width="22" height="22" fill="currentColor" viewBox="0 0 24 24">
                    <path
                      d="M21 7V3H3v4H1v2h2v12h18V9h2V7h-2zm-2 12H5V9h14v10zm-7-2c2.21 0 4-1.79 4-4h-2a2 2 0 01-4 0H7c0 2.21 1.79 4 4 4z" />
                  </svg>PayNoods</span>
                <span class="text-xl font-bold text-yellow-400">₱69.00</span>
              </div>
            </div>
          </div>
        </div>
        <div class="flex items-stretch flex-1 w-full max-w-2xl">
          <div class="w-full">
            <!-- perks just for you -->
            <div class="w-full p-8 mb-8 text-left bg-black border-2 border-red-600 shadow-lg rounded-xl">
              <h3 class="flex items-center mb-4 text-xl font-bold text-red-600"><svg class="inline mr-2" width="22"
                  height="22" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                </svg>Perks Just for You</h3>
              <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div class="flex items-center gap-3 p-4 bg-black border border-red-600 shadow rounded-xl">
                  <svg class="text-yellow-400" width="32" height="32" fill="currentColor" viewBox="0 0 24 24">
                    <path
                      d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                  </svg>
                  <div>
                    <span class="font-bold text-red-600">Become a Pro</span><br>
                    <span class="text-sm text-white/70">Unlock exclusive discounts and features</span>
                  </div>
                </div>
                <div class="flex items-center gap-3 p-4 bg-black border border-red-600 shadow rounded-xl">
                  <svg class="text-yellow-400" width="32" height="32" fill="currentColor" viewBox="0 0 24 24">
                    <path
                      d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                  </svg>
                  <div>
                    <span class="font-bold text-red-600">Nood Rewards</span><br>
                    <span class="text-sm text-white/70">Earn points every order</span>
                  </div>
                </div>
                <div class="flex items-center gap-3 p-4 bg-black border border-red-600 shadow rounded-xl">
                  <svg class="text-red-600" width="32" height="32" fill="currentColor" viewBox="0 0 24 24">
                    <path
                      d="M21 7V3H3v4H1v2h2v12h18V9h2V7h-2zm-2 12H5V9h14v10zm-7-2c2.21 0 4-1.79 4-4h-2a2 2 0 01-4 0H7c0 2.21 1.79 4 4 4z" />
                  </svg>
                  <div>
                    <span class="font-bold text-red-600">Vouchers</span><br>
                    <span class="text-sm text-white/70">Redeem for discounts and freebies</span>
                  </div>
                </div>
                <div class="flex items-center gap-3 p-4 bg-black border border-red-600 shadow rounded-xl">
                  <svg class="text-red-600" width="32" height="32" fill="currentColor" viewBox="0 0 24 24">
                    <path
                      d="M16 11c1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3 1.34 3 3 3zm-8 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4zm8 0c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                  </svg>
                  <div>
                    <span class="font-bold text-red-600">Invite Friends</span><br>
                    <span class="text-sm text-white/70">Get rewards for every successful invite</span>
                  </div>
                </div>
              </div>
            </div>
            <!-- general -->
            <div class="w-full p-8 text-left bg-black border-2 border-red-600 shadow-lg rounded-xl">
              <h3 class="flex items-center mb-4 text-xl font-bold text-red-600"><svg class="inline mr-2" width="22"
                  height="22" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                </svg>General</h3>
              <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div class="flex items-center gap-3 p-4 bg-black border border-red-600 shadow rounded-xl">
                  <svg class="text-red-600" width="32" height="32" fill="currentColor" viewBox="0 0 24 24">
                    <path
                      d="M19.14 12.94a1.5 1.5 0 00-2.12 0l-1.42 1.42a1.5 1.5 0 000 2.12l1.42 1.42a1.5 1.5 0 002.12 0l1.42-1.42a1.5 1.5 0 000-2.12l-1.42-1.42z" />
                  </svg>
                  <div>
                    <span class="font-bold text-red-600">Settings</span><br>
                    <span class="text-sm text-white/70">Manage your account preferences</span>
                  </div>
                </div>
                <div class="flex items-center gap-3 p-4 bg-black border border-red-600 shadow rounded-xl">
                  <svg class="text-yellow-400" width="32" height="32" fill="currentColor" viewBox="0 0 24 24">
                    <path
                      d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                  </svg>
                  <div>
                    <span class="font-bold text-red-600">Help Center</span><br>
                    <span class="text-sm text-white/70">Get support and FAQs</span>
                  </div>
                </div>
                <div class="flex items-center gap-3 p-4 bg-black border border-red-600 shadow rounded-xl">
                  <svg class="text-red-600" width="32" height="32" fill="currentColor" viewBox="0 0 24 24">
                    <path
                      d="M21 7V3H3v4H1v2h2v12h18V9h2V7h-2zm-2 12H5V9h14v10zm-7-2c2.21 0 4-1.79 4-4h-2a2 2 0 01-4 0H7c0 2.21 1.79 4 4 4z" />
                  </svg>
                  <div>
                    <span class="font-bold text-red-600">Business</span><br>
                    <span class="text-sm text-white/70">Partner with SendNoods</span>
                  </div>
                </div>
                <div class="flex items-center gap-3 p-4 bg-black border border-red-600 shadow rounded-xl">
                  <svg class="text-red-600" width="32" height="32" fill="currentColor" viewBox="0 0 24 24">
                    <path
                      d="M21 7V3H3v4H1v2h2v12h18V9h2V7h-2zm-2 12H5V9h14v10zm-7-2c2.21 0 4-1.79 4-4h-2a2 2 0 01-4 0H7c0 2.21 1.79 4 4 4z" />
                  </svg>
                  <div>
                    <span class="font-bold text-red-600">Terms &amp; Conditions</span><br>
                    <span class="text-sm text-white/70">Read our policies</span>
                  </div>
                </div>
              </div>
              <div class="flex justify-center w-full mt-6 mb-2">
                <a href="includes/logout.php"
                  class="px-6 py-2 font-bold text-white bg-red-600 rounded-full shadow hover:bg-red-700">Logout</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
  <!-- view profile modal -->
  <div id="profileModalWrapper" class="fixed inset-0 z-50 items-center justify-center hidden">
    <div class="absolute inset-0 bg-black/85 backdrop-blur-sm" id="profileModalBg"></div>
    <div id="profileModal"
      class="relative flex flex-col w-full max-w-lg mx-auto overflow-hidden text-red-600 bg-black border-2 border-red-600 rounded-xl">
      <div class="flex items-center justify-between px-6 py-4 border-b-2 border-red-600">
        <h5 class="text-xl text-red-600">Profile Information</h5>
        <button type="button" class="text-2xl text-white" id="closeProfileModal">&times;</button>
      </div>
      <div class="px-6 py-4">
        <div class="mb-3">
          <span class="font-bold text-white">Full Name:</span>
          <span
            class="ml-2 text-red-600"><?php echo htmlspecialchars($user['f_name'] . ' ' . $user['l_name']); ?></span>
        </div>
        <div class="mb-3">
          <span class="font-bold text-white">Username:</span>
          <span class="ml-2 text-red-600"><?php echo htmlspecialchars($user['username']); ?></span>
        </div>
        <div class="mb-3">
          <span class="font-bold text-white">Email:</span>
          <span class="ml-2 text-red-600"><?php echo htmlspecialchars($user['email']); ?></span>
        </div>
        <div class="mb-3">
          <span class="font-bold text-white">User Type:</span>
          <span class="ml-2 text-red-600"><?php echo $user['usertype'] == 1 ? 'Admin' : 'Customer'; ?></span>
        </div>
        <div class="mb-3">
          <span class="font-bold text-white">Address:</span>
          <span class="ml-2 text-red-600"><?php echo htmlspecialchars($user['address'] ?? ''); ?></span>
        </div>
      </div>
      <div class="flex justify-center px-6 py-4 border-t-2 border-red-600">
        <a href="./edit_profile.php"
          class="px-6 py-2 font-bold text-white bg-red-600 rounded-full hover:bg-red-700">Edit Profile</a>
      </div>
    </div>
  </div>
  <script>
    // Modal logic with jQuery
    function toggleBodyBlur(show) {
      if (show) $('body').addClass('modal-blur-bg');
      else $('body').removeClass('modal-blur-bg');
    }
    function showModal($wrapper) {
      $('.fixed.inset-0.z-50').addClass('hidden').removeClass('flex');
      $wrapper.removeClass('hidden').addClass('flex');
      toggleBodyBlur(true);
    }
    function hideModal($wrapper) {
      $wrapper.addClass('hidden').removeClass('flex');
      toggleBodyBlur(false);
    }
    $('#showProfileModal').on('click', function () {
      showModal($('#profileModalWrapper'));
    });
    $('#closeProfileModal').on('click', function () {
      hideModal($('#profileModalWrapper'));
    });
    $('#profileModalBg').on('click', function () {
      hideModal($('#profileModalWrapper'));
    });
  </script>
</body>

</html>