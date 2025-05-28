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
    $id = $pdo->lastInsertId();
    // Auto-login after signup
    $_SESSION['user'] = [
      'userid' => $id,
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
      'userid' => $user['iduser'],
      'username' => $user['username'],
      'email' => $user['email'],
      'usertype' => $user['usertype'],
      'f_name' => $user['f_name'],
      'l_name' => $user['l_name'],
      'address' => $user['address']
    ];
    header("Location: product.php");
    exit;
  } else {
    $login_error = "Invalid email or password.";
  }
}
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

<body class="text-red-600 bg-black">

  <?php if (!empty($login_error)): ?>
    <div role="alert"
      class="fixed px-4 py-3 mb-4 text-sm text-white transform -translate-x-1/2 bg-red-600 rounded shadow bottom-5 left-1/2">
      <?php echo htmlspecialchars($login_error); ?>
    </div>
  <?php endif; ?>

  <?php if (!empty($login_success)): ?>
    <div role="alert"
      class="fixed px-4 py-3 mb-4 text-sm text-white transform -translate-x-1/2 bg-green-600 rounded shadow bottom-5 left-1/2">
      <?php echo htmlspecialchars($login_success); ?>
    </div>
  <?php endif; ?>




  <div id="main-blur-blur">
    <main class="container py-10 mx-auto text-center">
      <h1 class="mb-6 text-4xl font-bold text-red-600">Welcome to SendNoods</h1>
      <div class="flex justify-center w-full mb-8">
        <div class="max-w-3xl text-lg text-justify text-white">
          Inspired by the rich traditions of Japanese noodle culture, <span
            class="font-bold text-red-600">SendNoods</span> brings you bold flavors, quality ingredients, and
          handcrafted bowls made with care. From classic broths to modern twists, every dish we serve honors the
          simplicity and soul of Japanese comfort food—delivered with a touch of cheeky fun.
        </div>
      </div>
      <!-- carousel -->
      <section class="mb-10">
        <div class="relative w-full mx-auto mb-8 overflow-hidden -translate-x-1/2 max-w-none left-1/2 right-1/2">
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
          <button id="multiPrev"
            class="absolute left-0 z-10 px-4 py-2 text-white -translate-y-1/2 bg-red-600 rounded btn top-1/2 hover:bg-red-700">
            &#8592;
          </button>
          <button id="multiNext"
            class="absolute right-0 z-10 px-4 py-2 text-white -translate-y-1/2 bg-red-600 rounded btn top-1/2 hover:bg-red-700">
            &#8594;
          </button>
        </div>
      </section>
      <!-- deals -->
      <section class="mb-10">
        <h2 class="mb-6 text-2xl font-bold text-red-600">We Offer Special Deals for New Customers</h2>
        <div class="flex flex-col justify-center gap-6 mb-6 md:flex-row">
          <div class="flex flex-col items-center w-full p-6 bg-black border border-red-600 shadow rounded-xl md:w-1/3">
            <span class="mb-2 text-lg font-bold text-red-600">Buy 1 Get 1 Free</span>
            <span class="text-white/70">On all classic ramen orders. Today only!</span>
          </div>
          <div class="flex flex-col items-center w-full p-6 bg-black border border-red-600 shadow rounded-xl md:w-1/3">
            <span class="mb-2 text-lg font-bold text-red-600">Free Drink</span>
            <span class="text-white/70">With any purchase over ₱300.</span>
          </div>
          <div class="flex flex-col items-center w-full p-6 bg-black border border-red-600 shadow rounded-xl md:w-1/3">
            <span class="mb-2 text-lg font-bold text-red-600">Raffle</span>
            <span class="text-white/70">Chance to win ₱1,000,000 for first time order.</span>
          </div>
        </div>
        <div class="mt-3">
          <span class="text-lg text-white">
            Want to learn more about <span class="italic font-semibold">SendNoods</span> or need help?
            <a href="./about.php" class="text-red-600 underline hover:text-red-500">Read about us</a> or
            <a href="./contact.php" class="text-red-600 underline hover:text-red-500">contact our customer service</a>!
          </span>
        </div>

      </section>
      <!-- auth buttons -->
      <div class="flex justify-center gap-4">
        <button
          class="px-6 py-2 text-red-600 border border-red-600 rounded cursor-pointer hover:bg-red-700 hover:text-white"
          id="showLoginModal">Login</button>
      </div>
    </main>
  </div>

  <!-- login modal -->
  <div id="loginModalWrapper" class="fixed inset-0 z-50 items-center justify-center hidden">
    <div class="absolute inset-0 bg-black/85 backdrop-blur-sm" id="loginModalBg"></div>
    <div id="loginModal"
      class="relative flex flex-col w-full max-w-lg mx-auto overflow-hidden text-red-600 bg-black border border-red-600 rounded-xl md:flex-row">
      <div class="hidden md:block md:w-2/5">
        <img src="./assets/images/logmodal.png" alt="Login" class="object-cover w-full h-full" />
      </div>
      <div class="w-full md:w-3/5">
        <div class="flex items-center justify-between px-6 py-4 border-b border-red-600">
          <h5 class="text-xl text-red-600">Login</h5>
          <button type="button" class="text-2xl text-white cursor-pointer" id="closeLoginModal">&times;</button>
        </div>
        <form method="post" autocomplete="off">
          <div class="px-6 py-4">

            <div class="mb-4">
              <label for="loginEmail" class="block mb-1">Email address</label>
              <input type="email" class="w-full px-3 py-2 text-red-600 bg-black border border-red-600 rounded"
                id="loginEmail" name="loginEmail" required autocomplete="email" />
            </div>
            <div class="mb-4">
              <label for="loginPassword" class="block mb-1">Password</label>
              <input type="password" class="w-full px-3 py-2 text-red-600 bg-black border border-red-600 rounded"
                id="loginPassword" name="loginPassword" required autocomplete="current-password" />
            </div>
            <div class="mt-3 text-center">
              <span>Didn't have an account yet? </span>
              <a href="#" class="text-red-600 underline" id="switchToSignup">
                Register
              </a>
            </div>
          </div>
          <div class="px-6 py-4 border-t border-red-600">
            <button type="submit" name="login"
              class="w-full py-2 text-white bg-red-600 rounded cursor-pointer hover:bg-red-700">Login</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- signup modal -->
  <div id="signupModalWrapper" class="fixed inset-0 z-50 items-center justify-center hidden">
    <div class="absolute inset-0 bg-black/85 backdrop-blur-sm" id="signupModalBg"></div>
    <div id="signupModal"
      class="relative flex flex-col w-full max-w-lg mx-auto overflow-hidden text-red-600 bg-black border border-red-600 rounded-xl md:flex-row">
      <div class="hidden md:block md:w-2/5">
        <img src="./assets/images/signmodal.png" alt="Sign Up" class="object-cover w-full h-full" />
      </div>
      <div class="w-full md:w-3/5">
        <div class="flex items-center justify-between px-6 py-4 border-b border-red-600">
          <h5 class="text-xl text-red-600">Sign Up</h5>
          <button type="button" class="text-2xl text-white" id="closeSignupModal">&times;</button>
        </div>
        <form method="post" autocomplete="off">
          <div class="px-6 py-4">
            <?php if (!empty($signup_error)): ?>
              <div class="px-3 py-2 mb-2 text-white bg-red-600 rounded"><?php echo htmlspecialchars($signup_error); ?>
              </div>
            <?php endif; ?>
            <?php if (!empty($signup_success)): ?>
              <div class="px-3 py-2 mb-2 text-white bg-green-600 rounded">
                <?php echo htmlspecialchars($signup_success); ?>
              </div>
            <?php endif; ?>
            <div class="mb-3">
              <label for="signupFName" class="block mb-1">First Name</label>
              <input type="text" class="w-full px-3 py-2 text-red-600 bg-black border border-red-600 rounded"
                id="signupFName" name="signupFName" maxlength="90" required autocomplete="given-name" />
            </div>
            <div class="mb-3">
              <label for="signupLName" class="block mb-1">Last Name</label>
              <input type="text" class="w-full px-3 py-2 text-red-600 bg-black border border-red-600 rounded"
                id="signupLName" name="signupLName" maxlength="90" required autocomplete="family-name" />
            </div>
            <div class="mb-3">
              <label for="signupUsername" class="block mb-1">Username</label>
              <input type="text" class="w-full px-3 py-2 text-red-600 bg-black border border-red-600 rounded"
                id="signupUsername" name="signupUsername" maxlength="90" required autocomplete="username" />
            </div>
            <div class="mb-3">
              <label for="signupEmail" class="block mb-1">Email address</label>
              <input type="email" class="w-full px-3 py-2 text-red-600 bg-black border border-red-600 rounded"
                id="signupEmail" name="signupEmail" maxlength="255" required autocomplete="email" />
            </div>
            <div class="hidden mb-3">
              <label for="signupUsertype" class="block mb-1">User Type</label>
              <select class="w-full px-3 py-2 text-red-600 bg-black border border-red-600 rounded" id="signupUsertype"
                name="signupUsertype" required>
                <option value="" disabled selected>Select user type</option>
                <option value="0" selected>Customer</option>
                <option value="1">Admin</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="signupAddress" class="block mb-1">Address</label>
              <textarea class="w-full px-3 py-2 text-red-600 bg-black border border-red-600 rounded" id="signupAddress"
                name="signupAddress" rows="2" required autocomplete="street-address"></textarea>
            </div>
            <div class="mb-3">
              <label for="signupPassword" class="block mb-1">Password</label>
              <input type="password" class="w-full px-3 py-2 text-red-600 bg-black border border-red-600 rounded"
                id="signupPassword" name="signupPassword" required autocomplete="new-password" />
            </div>
          </div>
          <div class="px-6 py-4 border-t border-red-600">
            <button type="submit" name="signup" class="w-full py-2 text-white bg-red-600 rounded hover:bg-red-700">Sign
              Up</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    // jQuery Carousel
    $(function () {
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

      $(window).on('load resize', function () { updateCarousel(false); });

      function slideTo(newPosition) {
        if (animating) return;
        animating = true;
        position = newPosition;
        updateCarousel();
        setTimeout(() => animating = false, 800);
      }

      $('#multiPrev').on('click', function () {
        position -= visible;
        if (position < 0) position = total;
        slideTo(position);
      });

      $('#multiNext').on('click', function () {
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

      $('#showLoginModal').on('click', function () {
        showModal($('#loginModalWrapper'));
      });
      $('#showSignupModal').on('click', function () {
        showModal($('#signupModalWrapper'));
      });
      $('#closeLoginModal').on('click', function () {
        hideModal($('#loginModalWrapper'));
      });
      $('#closeSignupModal').on('click', function () {
        hideModal($('#signupModalWrapper'));
      });
      $('#switchToSignup').on('click', function (e) {
        e.preventDefault();
        hideModal($('#loginModalWrapper'));
        showModal($('#signupModalWrapper'));
      });

      // Hide modal on background click
      $('#loginModalBg').on('click', function () {
        hideModal($('#loginModalWrapper'));
      });
      $('#signupModalBg').on('click', function () {
        hideModal($('#signupModalWrapper'));
      });
    });
  </script>
</body>

</html>