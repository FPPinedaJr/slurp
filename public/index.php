<?php
session_start();
require_once __DIR__ . "/includes/connect_db.php";

// Handle Signup
$signup_error = '';
$signup_success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {
    $f_name = trim($_POST['signupFName']);
    $l_name = trim($_POST['signupLName']);
    $username = trim($_POST['signupUsername']);
    $email = trim($_POST['signupEmail']);
    $usertype = intval($_POST['signupUsertype']);
    $address = trim($_POST['signupAddress']);
    $password = password_hash($_POST['signupPassword'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("SELECT iduser FROM user WHERE email = ? OR username = ?");
    $stmt->execute([$email, $username]);
    if ($stmt->fetch()) {
        $signup_error = "Email or username already exists.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO user (f_name, l_name, username, email, usertype, address, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$f_name, $l_name, $username, $email, $usertype, $address, $password]);
        // Auto-login after signup
        $_SESSION['user'] = [
            'username' => $username,
            'email' => $email,
            'usertype' => $usertype,
            'f_name' => $f_name,
            'l_name' => $l_name,
            'address' => $address
        ];
        header("Location: profile.php");
        exit;
    }
}

// Handle Login
$login_error = '';
$login_success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = trim($_POST['loginEmail']);
    $password = $_POST['loginPassword'];
    $stmt = $pdo->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = [
            'username' => $user['username'],
            'email' => $user['email'],
            'usertype' => $user['usertype'],
            'f_name' => $user['f_name'],
            'l_name' => $user['l_name'],
            'address' => $user['address'] // ensure address is included
        ];
        header("Location: profile.php");
        exit;
    } else {
        $login_error = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SendNoods - Noodle Shop</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <style>
    #main-blur-blur {
      transition: filter 0.2s;
    }

    .modal-blur-bg #main-blur-blur {
      filter: blur(2.5px);
    }

    .modal-bg {
      background: rgba(0, 0, 0, 0.85);
      backdrop-filter: blur(0px);
    }
  </style>
</head>

<body class="bg-black text-red-600">
  <?php include_once "includes/header.php"; ?>

  <div id="main-blur-blur">
    <main class="container mx-auto py-10 text-center">
      <h1 class="text-red-600 font-bold text-4xl mb-6">Welcome to SendNoods</h1>
      <div class="w-full flex justify-center mb-8">
        <div class="text-white text-lg max-w-3xl text-justify">
          Inspired by the rich traditions of Japanese noodle culture, <span class="text-red-600 font-bold">SendNoods</span> brings you bold flavors, quality ingredients, and handcrafted bowls made with care. From classic broths to modern twists, every dish we serve honors the simplicity and soul of Japanese comfort food—delivered with a touch of cheeky fun.
        </div>
      </div>
      <!-- carousel -->
      <section class="mb-10">
        <div class="relative mb-8 mx-auto w-full max-w-none left-1/2 right-1/2 -translate-x-1/2 overflow-hidden">
          <div id="multiImageCarousel" class="flex items-center transition-transform duration-500">
            <img src="./assets/images/1.png" class="carousel-img mx-2 rounded w-[300px] h-[200px] object-cover" />
            <img src="./assets/images/2.png" class="carousel-img mx-2 rounded w-[300px] h-[200px] object-cover" />
            <img src="./assets/images/3.png" class="carousel-img mx-2 rounded w-[300px] h-[200px] object-cover" />
            <img src="./assets/images/4.png" class="carousel-img mx-2 rounded w-[300px] h-[200px] object-cover" />
            <img src="./assets/images/5.png" class="carousel-img mx-2 rounded w-[300px] h-[200px] object-cover" />
            <img src="./assets/images/6.png" class="carousel-img mx-2 rounded w-[300px] h-[200px] object-cover" />
            <img src="./assets/images/7.png" class="carousel-img mx-2 rounded w-[300px] h-[200px] object-cover" />
            <img src="./assets/images/8.png" class="carousel-img mx-2 rounded w-[300px] h-[200px] object-cover" />
            <img src="./assets/images/9.png" class="carousel-img mx-2 rounded w-[300px] h-[200px] object-cover" />
            <img src="./assets/images/10.png" class="carousel-img mx-2 rounded w-[300px] h-[200px] object-cover" />
          </div>
          <button id="multiPrev" class="btn absolute top-1/2 left-0 -translate-y-1/2 z-10 bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
            &#8592;
          </button>
          <button id="multiNext" class="btn absolute top-1/2 right-0 -translate-y-1/2 z-10 bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
            &#8594;
          </button>
        </div>
      </section>
      <!-- deals -->
      <section class="mb-10">
        <h2 class="mb-6 font-bold text-red-600 text-2xl">We Offer Special Deals for New Customers</h2>
        <div class="flex flex-col md:flex-row gap-6 justify-center mb-6">
          <div class="bg-black border border-red-600 rounded-xl p-6 flex flex-col items-center shadow w-full md:w-1/3">
            <span class="font-bold text-red-600 text-lg mb-2">Buy 1 Get 1 Free</span>
            <span class="text-white/70">On all classic ramen orders. Today only!</span>
          </div>
          <div class="bg-black border border-red-600 rounded-xl p-6 flex flex-col items-center shadow w-full md:w-1/3">
            <span class="font-bold text-red-600 text-lg mb-2">Free Drink</span>
            <span class="text-white/70">With any purchase over ₱300.</span>
          </div>
          <div class="bg-black border border-red-600 rounded-xl p-6 flex flex-col items-center shadow w-full md:w-1/3">
            <span class="font-bold text-red-600 text-lg mb-2">Loyalty Rewards</span>
            <span class="text-white/70">Earn points every time you order online.</span>
          </div>
        </div>
        <div class="mt-3">
          <span class="text-white text-lg">Are you interested? <span class="text-red-600">Check it out by signing up or logging in if you already have an account!</span></span>
        </div>
      </section>
      <!-- auth buttons -->
      <div class="flex justify-center gap-4">
        <button class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700" id="showLoginModal">Login</button>
        <button class="border border-red-600 text-red-600 px-6 py-2 rounded hover:bg-red-700 hover:text-white" id="showSignupModal">Sign Up</button>
      </div>
    </main>
  </div>

  <!-- login modal -->
  <div id="loginModalWrapper" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/85 backdrop-blur-sm" id="loginModalBg"></div>
    <div id="loginModal" class="relative bg-black text-red-600 border border-red-600 rounded-xl w-full max-w-lg mx-auto flex flex-col md:flex-row overflow-hidden">
      <div class="hidden md:block md:w-2/5">
        <img src="./assets/images/logmodal.png" alt="Login" class="h-full w-full object-cover" />
      </div>
      <div class="w-full md:w-3/5">
        <div class="flex justify-between items-center border-b border-red-600 px-6 py-4">
          <h5 class="text-red-600 text-xl">Login</h5>
          <button type="button" class="text-white text-2xl" id="closeLoginModal">&times;</button>
        </div>
        <form method="post" autocomplete="off">
          <div class="px-6 py-4">
            <?php if (!empty($login_error)): ?>
              <div class="bg-red-600 text-white rounded px-3 py-2 mb-2"><?php echo htmlspecialchars($login_error); ?></div>
            <?php endif; ?>
            <?php if (!empty($login_success)): ?>
              <div class="bg-green-600 text-white rounded px-3 py-2 mb-2"><?php echo htmlspecialchars($login_success); ?></div>
            <?php endif; ?>
            <div class="mb-4">
              <label for="loginEmail" class="block mb-1">Email address</label>
              <input type="email" class="bg-black text-red-600 border border-red-600 rounded w-full px-3 py-2" id="loginEmail" name="loginEmail" required autocomplete="email" />
            </div>
            <div class="mb-4">
              <label for="loginPassword" class="block mb-1">Password</label>
              <input type="password" class="bg-black text-red-600 border border-red-600 rounded w-full px-3 py-2" id="loginPassword" name="loginPassword" required autocomplete="current-password" />
            </div>
            <div class="text-center mt-3">
              <span>Didn't have an account yet? </span>
              <a href="#" class="text-red-600 underline" id="switchToSignup">
                Register
              </a>
            </div>
          </div>
          <div class="border-t border-red-600 px-6 py-4">
            <button type="submit" name="login" class="bg-red-600 text-white w-full py-2 rounded hover:bg-red-700">Login</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- signup modal -->
  <div id="signupModalWrapper" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/85 backdrop-blur-sm" id="signupModalBg"></div>
    <div id="signupModal" class="relative bg-black text-red-600 border border-red-600 rounded-xl w-full max-w-lg mx-auto flex flex-col md:flex-row overflow-hidden">
      <div class="hidden md:block md:w-2/5">
        <img src="./assets/images/signmodal.png" alt="Sign Up" class="h-full w-full object-cover" />
      </div>
      <div class="w-full md:w-3/5">
        <div class="flex justify-between items-center border-b border-red-600 px-6 py-4">
          <h5 class="text-red-600 text-xl">Sign Up</h5>
          <button type="button" class="text-white text-2xl" id="closeSignupModal">&times;</button>
        </div>
        <form method="post" autocomplete="off">
          <div class="px-6 py-4">
            <?php if (!empty($signup_error)): ?>
              <div class="bg-red-600 text-white rounded px-3 py-2 mb-2"><?php echo htmlspecialchars($signup_error); ?></div>
            <?php endif; ?>
            <?php if (!empty($signup_success)): ?>
              <div class="bg-green-600 text-white rounded px-3 py-2 mb-2"><?php echo htmlspecialchars($signup_success); ?></div>
            <?php endif; ?>
            <div class="mb-3">
              <label for="signupFName" class="block mb-1">First Name</label>
              <input type="text" class="bg-black text-red-600 border border-red-600 rounded w-full px-3 py-2" id="signupFName" name="signupFName" maxlength="90" required autocomplete="given-name" />
            </div>
            <div class="mb-3">
              <label for="signupLName" class="block mb-1">Last Name</label>
              <input type="text" class="bg-black text-red-600 border border-red-600 rounded w-full px-3 py-2" id="signupLName" name="signupLName" maxlength="90" required autocomplete="family-name" />
            </div>
            <div class="mb-3">
              <label for="signupUsername" class="block mb-1">Username</label>
              <input type="text" class="bg-black text-red-600 border border-red-600 rounded w-full px-3 py-2" id="signupUsername" name="signupUsername" maxlength="90" required autocomplete="username" />
            </div>
            <div class="mb-3">
              <label for="signupEmail" class="block mb-1">Email address</label>
              <input type="email" class="bg-black text-red-600 border border-red-600 rounded w-full px-3 py-2" id="signupEmail" name="signupEmail" maxlength="255" required autocomplete="email" />
            </div>
            <div class="mb-3">
              <label for="signupUsertype" class="block mb-1">User Type</label>
              <select class="bg-black text-red-600 border border-red-600 rounded w-full px-3 py-2" id="signupUsertype" name="signupUsertype" required>
                <option value="" disabled selected>Select user type</option>
                <option value="0">Customer</option>
                <option value="1">Admin</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="signupAddress" class="block mb-1">Address</label>
              <textarea class="bg-black text-red-600 border border-red-600 rounded w-full px-3 py-2" id="signupAddress" name="signupAddress" rows="2" required autocomplete="street-address"></textarea>
            </div>
            <div class="mb-3">
              <label for="signupPassword" class="block mb-1">Password</label>
              <input type="password" class="bg-black text-red-600 border border-red-600 rounded w-full px-3 py-2" id="signupPassword" name="signupPassword" required autocomplete="new-password" />
            </div>
          </div>
          <div class="border-t border-red-600 px-6 py-4">
            <button type="submit" name="signup" class="bg-red-600 text-white w-full py-2 rounded hover:bg-red-700">Sign Up</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
  // jQuery Carousel
  $(function() {
    const $carousel = $('#multiImageCarousel');
    const $imgs = $carousel.find('.carousel-img');
    const visible = 3;
    const total = $imgs.length;
    let animating = false;

    function setupClones() {
      $carousel.find('.clone').remove();
      for (let i = 0; i < visible; i++) {
        $imgs.eq(i).clone(true).addClass('clone').appendTo($carousel);
      }
      for (let i = total - visible; i < total; i++) {
        $imgs.eq(i).clone(true).addClass('clone').prependTo($carousel);
      }
    }

    setupClones();

    let $allImgs = $carousel.find('.carousel-img');
    let position = visible;

    function getImgWidth() {
      return $imgs[0].offsetWidth + 16;
    }

    function updateCarousel(animate = true) {
      const imgWidth = getImgWidth();
      if (!animate) $carousel.css('transition', 'none');
      else $carousel.css('transition', 'transform 0.8s cubic-bezier(0.77,0,0.18,1)');
      $carousel.css('transform', `translateX(-${position * imgWidth}px)`);
      if (!animate) setTimeout(() => $carousel.css('transition', 'transform 0.8s cubic-bezier(0.77,0,0.18,1)'), 10);
    }

    $(window).on('load resize', function() { updateCarousel(false); });

    function slideTo(newPosition) {
      if (animating) return;
      animating = true;
      position = newPosition;
      updateCarousel();
      setTimeout(() => animating = false, 800);
    }

    $('#multiPrev').on('click', function() {
      position -= visible;
      if (position < 0) position = total;
      slideTo(position);
    });

    $('#multiNext').on('click', function() {
      position += visible;
      if (position >= total * 2) position = visible;
      slideTo(position);
    });

    // Modal logic
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

    $('#showLoginModal').on('click', function() {
      showModal($('#loginModalWrapper'));
    });
    $('#showSignupModal').on('click', function() {
      showModal($('#signupModalWrapper'));
    });
    $('#closeLoginModal').on('click', function() {
      hideModal($('#loginModalWrapper'));
    });
    $('#closeSignupModal').on('click', function() {
      hideModal($('#signupModalWrapper'));
    });
    $('#switchToSignup').on('click', function(e) {
      e.preventDefault();
      hideModal($('#loginModalWrapper'));
      showModal($('#signupModalWrapper'));
    });

    // Hide modal on background click
    $('#loginModalBg').on('click', function() {
      hideModal($('#loginModalWrapper'));
    });
    $('#signupModalBg').on('click', function() {
      hideModal($('#signupModalWrapper'));
    });
  });
  </script>
</body>

</html>
