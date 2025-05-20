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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
    #main-blur-blur {
      transition: filter 0.2s;
    }

    .modal-blur-bg #main-blur-blur {
      filter: blur(2.5px);
    }

    .modal-backdrop.show {
      opacity: 0.85 !important;
      background: #000 !important;
      backdrop-filter: blur(0px) !important;
    }

    .modal-content {
      background: rgba(0, 0, 0, 0.7) !important;
      backdrop-filter: blur(0px) !important;
    }
  </style>
</head>

<body class="bg-black text-danger">
  <?php include_once "includes/header.php"; ?>

  <div id="main-blur-blur">
    <main class="container py-5 text-center">
      <h1 class="text-danger fw-bold mb-3">Welcome to SendNoods</h1>
      <div class="w-100 d-flex justify-content-center mb-4">
        <div class="text-white fs-5 text-justify" style="max-width: 1000px; text-align: justify;">
          Inspired by the rich traditions of Japanese noodle culture, <span class="text-danger fw-bold">SendNoods</span> brings you bold flavors, quality ingredients, and handcrafted bowls made with care. From classic broths to modern twists, every dish we serve honors the simplicity and soul of Japanese comfort food—delivered with a touch of cheeky fun.
        </div>
      </div>
      <!-- carousel -->
      <section class="mb-5">
        <div class="position-relative mb-4 mx-auto" style="width: 100vw; max-width: none; left: 50%; right: 50%; transform: translateX(-50%); overflow: hidden;">
          <div id="multiImageCarousel" class="d-flex align-items-center" style="transition: transform 0.5s;">
            <img src="./assets/images/1.png" class="carousel-img mx-2 rounded" style="width: 300px; height: 200px; object-fit: cover;">
            <img src="./assets/images/2.png" class="carousel-img mx-2 rounded" style="width: 300px; height: 200px; object-fit: cover;">
            <img src="./assets/images/3.png" class="carousel-img mx-2 rounded" style="width: 300px; height: 200px; object-fit: cover;">
            <img src="./assets/images/4.png" class="carousel-img mx-2 rounded" style="width: 300px; height: 200px; object-fit: cover;">
            <img src="./assets/images/5.png" class="carousel-img mx-2 rounded" style="width: 300px; height: 200px; object-fit: cover;">
            <img src="./assets/images/6.png" class="carousel-img mx-2 rounded" style="width: 300px; height: 200px; object-fit: cover;">
            <img src="./assets/images/7.png" class="carousel-img mx-2 rounded" style="width: 300px; height: 200px; object-fit: cover;">
            <img src="./assets/images/8.png" class="carousel-img mx-2 rounded" style="width: 300px; height: 200px; object-fit: cover;">
            <img src="./assets/images/9.png" class="carousel-img mx-2 rounded" style="width: 300px; height: 200px; object-fit: cover;">
            <img src="./assets/images/10.png" class="carousel-img mx-2 rounded" style="width: 300px; height: 200px; object-fit: cover;">
          </div>
          <button id="multiPrev" class="btn btn-danger position-absolute top-50 start-0 translate-middle-y" style="z-index:2;">
            <i class="fas fa-chevron-left"></i>
          </button>
          <button id="multiNext" class="btn btn-danger position-absolute top-50 end-0 translate-middle-y" style="z-index:2;">
            <i class="fas fa-chevron-right"></i>
          </button>
        </div>
      </section>
      <!-- deals -->
      <section class="mb-5">
        <h2 class="mb-4 fw-bold text-danger">We Offer Special Deals for New Customers</h2>
        <div class="row g-4 justify-content-center mb-3">
          <div class="col-12 col-md-4">
            <div class="bg-black border border-danger rounded-3 p-4 h-100 d-flex flex-column align-items-center shadow">
              <span class="fw-bold text-danger fs-5 mb-2">Buy 1 Get 1 Free</span>
              <span class="text-white-50">On all classic ramen orders. Today only!</span>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="bg-black border border-danger rounded-3 p-4 h-100 d-flex flex-column align-items-center shadow">
              <span class="fw-bold text-danger fs-5 mb-2">Free Drink</span>
              <span class="text-white-50">With any purchase over ₱300.</span>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="bg-black border border-danger rounded-3 p-4 h-100 d-flex flex-column align-items-center shadow">
              <span class="fw-bold text-danger fs-5 mb-2">Loyalty Rewards</span>
              <span class="text-white-50">Earn points every time you order online.</span>
            </div>
          </div>
        </div>
        <div class="mt-3">
          <span class="text-white fs-5">Are you interested? <span class="text-danger">Check it out by signing up or logging in if you already have an account!</span></span>
        </div>
      </section>
      <!-- auth buttons -->
      <div class="d-flex justify-content-center gap-3">
        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
        <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#signupModal">Sign Up</button>
      </div>
    </main>
  </div>

  <!-- login modal -->
  <div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content bg-black text-danger border-danger">
        <div class="row g-0">
          <div class="col-md-5 d-none d-md-block">
            <img src="./assets/images/logmodal.png" alt="Login" class="img-fluid h-100 w-100 object-fit-cover rounded-start" style="object-fit: cover; height:100%;">
          </div>
          <div class="col-12 col-md-7">
            <div class="modal-header border-danger">
              <h5 class="modal-title text-danger">Login</h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" autocomplete="off">
              <div class="modal-body">
                <?php if (!empty($login_error)): ?>
                  <div class="alert alert-danger py-2"><?php echo htmlspecialchars($login_error); ?></div>
                <?php endif; ?>
                <?php if (!empty($login_success)): ?>
                  <div class="alert alert-success py-2"><?php echo htmlspecialchars($login_success); ?></div>
                <?php endif; ?>
                <div class="mb-3">
                  <label for="loginEmail" class="form-label">Email address</label>
                  <input type="email" class="form-control bg-black text-danger border-danger" id="loginEmail" name="loginEmail" required autocomplete="email" required />
                </div>
                <div class="mb-3">
                  <label for="loginPassword" class="form-label">Password</label>
                  <input type="password" class="form-control bg-black text-danger border-danger" id="loginPassword" name="loginPassword" required autocomplete="current-password" required />
                </div>
                <div class="text-center mt-3">
                  <span>Didn't have an account yet? </span>
                  <a href="#" class="text-danger text-decoration-underline" data-bs-dismiss="modal" data-bs-toggle="modal"
                    data-bs-target="#signupModal">
                    Register
                  </a>
                </div>
              </div>
              <div class="modal-footer border-danger">
                <button type="submit" name="login" class="btn btn-danger w-100">Login</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- signup modal -->
  <div class="modal fade" id="signupModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content bg-black text-danger border-danger">
        <div class="row g-0">
          <div class="col-md-5 d-none d-md-block">
            <img src="./assets/images/signmodal.png" alt="Sign Up" class="img-fluid h-100 w-100 object-fit-cover rounded-start" style="object-fit: cover; height:100%;">
          </div>
          <div class="col-12 col-md-7">
            <div class="modal-header border-danger">
              <h5 class="modal-title text-danger">Sign Up</h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" autocomplete="off">
              <div class="modal-body">
                <?php if (!empty($signup_error)): ?>
                  <div class="alert alert-danger py-2"><?php echo htmlspecialchars($signup_error); ?></div>
                <?php endif; ?>
                <?php if (!empty($signup_success)): ?>
                  <div class="alert alert-success py-2"><?php echo htmlspecialchars($signup_success); ?></div>
                <?php endif; ?>
                <div class="mb-3">
                  <label for="signupFName" class="form-label">First Name</label>
                  <input type="text" class="form-control bg-black text-danger border-danger" id="signupFName" name="signupFName" maxlength="90" required autocomplete="given-name" required />
                </div>
                <div class="mb-3">
                  <label for="signupLName" class="form-label">Last Name</label>
                  <input type="text" class="form-control bg-black text-danger border-danger" id="signupLName" name="signupLName" maxlength="90" required autocomplete="family-name" required />
                </div>
                <div class="mb-3">
                  <label for="signupUsername" class="form-label">Username</label>
                  <input type="text" class="form-control bg-black text-danger border-danger" id="signupUsername" name="signupUsername" maxlength="90" required autocomplete="username" required />
                </div>
                <div class="mb-3">
                  <label for="signupEmail" class="form-label">Email address</label>
                  <input type="email" class="form-control bg-black text-danger border-danger" id="signupEmail" name="signupEmail" maxlength="255" required autocomplete="email" required />
                </div>
                <div class="mb-3">
                  <label for="signupUsertype" class="form-label">User Type</label>
                  <select class="form-select bg-black text-danger border-danger" id="signupUsertype" name="signupUsertype" required required>
                    <option value="" disabled selected>Select user type</option>
                    <option value="0">Customer</option>
                    <option value="1">Admin</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="signupAddress" class="form-label">Address</label>
                  <textarea class="form-control bg-black text-danger border-danger" id="signupAddress" name="signupAddress" rows="2" required autocomplete="street-address" required></textarea>
                </div>
                <div class="mb-3">
                  <label for="signupPassword" class="form-label">Password</label>
                  <input type="password" class="form-control bg-black text-danger border-danger" id="signupPassword" name="signupPassword" required autocomplete="new-password" required />
                </div>
              </div>
              <div class="modal-footer border-danger">
                <button type="submit" name="signup" class="btn btn-danger w-100 text-white">Sign Up</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
  document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.getElementById('multiImageCarousel');
    const imgs = Array.from(carousel.querySelectorAll('.carousel-img'));
    const prevBtn = document.getElementById('multiPrev');
    const nextBtn = document.getElementById('multiNext');
    const visible = 3;
    const total = imgs.length;
    let animating = false;

    function setupClones() {
      carousel.querySelectorAll('.clone').forEach(el => el.remove());
      for (let i = 0; i < visible; i++) {
        let clone = imgs[i].cloneNode(true);
        clone.classList.add('clone');
        carousel.appendChild(clone);
      }
      for (let i = total - visible; i < total; i++) {
        let clone = imgs[i].cloneNode(true);
        clone.classList.add('clone');
        carousel.insertBefore(clone, carousel.firstChild);
      }
    }

    setupClones();

    let allImgs = carousel.querySelectorAll('.carousel-img');
    let position = visible;

    function getImgWidth() {
      return imgs[0].offsetWidth + 16;
    }

    function updateCarousel(animate = true) {
      const imgWidth = getImgWidth();
      if (!animate) carousel.style.transition = 'none';
      else carousel.style.transition = 'transform 0.8s cubic-bezier(0.77,0,0.18,1)';
      carousel.style.transform = `translateX(-${position * imgWidth}px)`;
      if (!animate) setTimeout(() => carousel.style.transition = 'transform 0.8s cubic-bezier(0.77,0,0.18,1)', 10);
    }

    window.addEventListener('load', () => updateCarousel(false));
    window.addEventListener('resize', () => updateCarousel(false));

    function slideTo(newPosition) {
      if (animating) return;
      animating = true;
      const imgWidth = getImgWidth();
      position = newPosition;
      updateCarousel();
      setTimeout(() => animating = false, 800);
    }

    prevBtn.addEventListener('click', () => {
      position -= visible;
      if (position < 0) position = total;
      slideTo(position);
    });

    nextBtn.addEventListener('click', () => {
      position += visible;
      if (position >= total * 2) position = visible;
      slideTo(position);
    });

    function toggleBodyBlur(show) {
      if (show) document.body.classList.add('modal-blur-bg');
      else document.body.classList.remove('modal-blur-bg');
    }
    const modals = ['#loginModal', '#signupModal'];
    modals.forEach(function(id) {
      var modal = document.querySelector(id);
      if (modal) {
        modal.addEventListener('show.bs.modal', function() { toggleBodyBlur(true); });
        modal.addEventListener('hidden.bs.modal', function() { toggleBodyBlur(false); });
      }
    });
  });
  </script>
</body>

</html>
