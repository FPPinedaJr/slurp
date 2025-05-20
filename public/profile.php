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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SendNoods - Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
    body { background: #000; color: #dc2626; }
    .profile-card { background: #000; border: 2px solid #dc2626; }
    .profile-label { color: #fff; }
    .profile-value { color: #dc2626; }
    .logout-btn, .view-btn { background: #dc2626; color: #fff; border: none; }
    .logout-btn:hover, .view-btn:hover { background: #b91c1c; color: #fff; }
    .orders-section { background: #000; border: 2px solid #dc2626; }
    .noodspro-div { background: #000 !important; border: 2px solid #dc2626; }
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
<body class="bg-black text-danger min-vh-100">
  <?php include_once "includes/header.php"; ?>

  <div id="main-blur-blur">
    <main class="container py-5">
      <div class="row justify-content-center">
        <div class="col-12 col-md-6 col-lg-5 d-flex flex-column align-items-center">
          <!-- profile card -->
          <div class="profile-card rounded-3 shadow-lg p-4 mb-4 w-100">
            <div class="text-center mb-4">
              <i class="fas fa-user-circle fa-4x text-danger mb-2"></i>
              <h2 class="fw-bold text-danger mb-1"><?php echo htmlspecialchars($user['f_name'] . ' ' . $user['l_name']); ?></h2>
              <div class="d-flex justify-content-center gap-3 mt-3">
                <button type="button" class="btn view-btn px-4 rounded-pill fw-bold shadow" data-bs-toggle="modal" data-bs-target="#viewProfileModal">
                  <i class="fas fa-id-card me-2"></i>View Profile
                </button>
              </div>
            </div>
            <div class="mb-4">
              <!-- noodspro -->
              <div class="noodspro-div rounded-4 text-center p-3 shadow-lg" style="background: linear-gradient(120deg, #1a1a1a 60%, #dc2626 100%); border: 2px solid #dc2626;">
                <div class="d-flex align-items-center justify-content-center mb-1">
                  <span class="fw-bold text-warning fs-5 me-2">20%</span>
                  <i class="fas fa-percent text-warning fs-6 me-2"></i>
                  <span class="fw-bold text-white fs-6" style="letter-spacing:1px;">OFF!</span>
                </div>
                <div class="fw-bold text-white fs-6 mb-1" style="letter-spacing:1px;">
                  Save with <span class="text-warning">NoodsPro!</span>
                </div>
                <div class="text-white-50 mb-2" style="font-size:0.95rem;">
                  <i class="fas fa-gift text-danger me-1"></i>FREE for 30 days
                </div>
                <a href="#" class="btn btn-warning fw-bold px-3 py-1 rounded-pill mt-2 shadow" style="color:#b91c1c; font-size:1rem;">
                  <i class="fas fa-arrow-right me-2"></i>Start your free trial
                </a>
              </div>
            </div>
            <!-- tiles -->
            <div class="row g-3 mb-4">
              <div class="col-12 col-sm-4">
                <div class="bg-black border border-danger rounded-3 p-3 h-100 d-flex flex-column align-items-center shadow">
                  <i class="fas fa-heart fa-2x text-danger mb-2"></i>
                  <span class="fw-bold text-danger">Favorites</span>
                  <span class="text-white-50 small">Your most loved dishes</span>
                </div>
              </div>
              <div class="col-12 col-sm-4">
                <div class="bg-black border border-danger rounded-3 p-3 h-100 d-flex flex-column align-items-center shadow">
                  <i class="fas fa-store-alt fa-2x text-danger mb-2"></i>
                  <span class="fw-bold text-danger">Branches</span>
                  <span class="text-white-50 small">Find a SendNoods near you</span>
                </div>
              </div>
              <div class="col-12 col-sm-4">
                <div class="bg-black border border-danger rounded-3 p-3 h-100 d-flex flex-column align-items-center shadow">
                  <i class="fas fa-coins fa-2x text-warning mb-2"></i>
                  <span class="fw-bold text-danger">Points</span>
                  <span class="text-white-50 small">Earn and redeem rewards</span>
                </div>
              </div>
            </div>
            <!-- paynoods -->
            <div class="bg-black border border-danger rounded-3 p-3 shadow mb-4">
              <div class="fw-bold text-danger fs-5 mb-1 d-flex align-items-center justify-content-between">
                <span><i class="fas fa-wallet me-2"></i>PayNoods</span>
                <span class="fs-4 fw-bold" style="color:#fbbf24;">₱69.00</span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-6 col-lg-7 d-flex align-items-stretch">
          <div class="w-100">
            <!-- perks just for you -->
            <div class="orders-section rounded-3 shadow-lg p-4 mb-4 w-100 text-start">
              <h3 class="fw-bold text-danger mb-3"><i class="fas fa-gift me-2"></i>Perks Just for You</h3>
              <div class="row g-3">
                <div class="col-12 col-md-6">
                  <div class="bg-black border border-danger rounded-3 p-3 d-flex align-items-center gap-3 shadow">
                    <i class="fas fa-crown fa-2x text-warning"></i>
                    <div>
                      <span class="fw-bold text-danger">Become a Pro</span><br>
                      <span class="text-white-50 small">Unlock exclusive discounts and features</span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="bg-black border border-danger rounded-3 p-3 d-flex align-items-center gap-3 shadow">
                    <i class="fas fa-coins fa-2x text-warning"></i>
                    <div>
                      <span class="fw-bold text-danger">Nood Rewards</span><br>
                      <span class="text-white-50 small">Earn points every order</span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="bg-black border border-danger rounded-3 p-3 d-flex align-items-center gap-3 shadow">
                    <i class="fas fa-ticket-alt fa-2x text-danger"></i>
                    <div>
                      <span class="fw-bold text-danger">Vouchers</span><br>
                      <span class="text-white-50 small">Redeem for discounts and freebies</span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="bg-black border border-danger rounded-3 p-3 d-flex align-items-center gap-3 shadow">
                    <i class="fas fa-user-friends fa-2x text-danger"></i>
                    <div>
                      <span class="fw-bold text-danger">Invite Friends</span><br>
                      <span class="text-white-50 small">Get rewards for every successful invite</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- general -->
            <div class="orders-section rounded-3 shadow-lg p-4 w-100 text-start">
              <h3 class="fw-bold text-danger mb-3"><i class="fas fa-cog me-2"></i>General</h3>
              <div class="row g-3">
                <div class="col-12 col-md-6">
                  <div class="bg-black border border-danger rounded-3 p-3 d-flex align-items-center gap-3 shadow">
                    <i class="fas fa-cog fa-2x text-danger"></i>
                    <div>
                      <span class="fw-bold text-danger">Settings</span><br>
                      <span class="text-white-50 small">Manage your account preferences</span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="bg-black border border-danger rounded-3 p-3 d-flex align-items-center gap-3 shadow">
                    <i class="fas fa-question-circle fa-2x text-warning"></i>
                    <div>
                      <span class="fw-bold text-danger">Help Center</span><br>
                      <span class="text-white-50 small">Get support and FAQs</span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="bg-black border border-danger rounded-3 p-3 d-flex align-items-center gap-3 shadow">
                    <i class="fas fa-briefcase fa-2x text-danger"></i>
                    <div>
                      <span class="fw-bold text-danger">Business</span><br>
                      <span class="text-white-50 small">Partner with SendNoods</span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="bg-black border border-danger rounded-3 p-3 d-flex align-items-center gap-3 shadow">
                    <i class="fas fa-file-contract fa-2x text-danger"></i>
                    <div>
                      <span class="fw-bold text-danger">Terms &amp; Conditions</span><br>
                      <span class="text-white-50 small">Read our policies</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="w-100 d-flex justify-content-center mt-4 mb-2">
                <a href="./logout.php" class="btn logout-btn px-4 rounded-pill fw-bold shadow">Logout</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
  <!-- view profile modal -->
  <div class="modal fade modal-center-profile" id="viewProfileModal" tabindex="-1" aria-labelledby="viewProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content bg-black text-danger border-danger">
        <div class="modal-header border-danger">
          <h5 class="modal-title text-danger" id="viewProfileModalLabel">Profile Information</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <span class="profile-label fw-bold">Full Name:</span>
            <span class="profile-value ms-2"><?php echo htmlspecialchars($user['f_name'] . ' ' . $user['l_name']); ?></span>
          </div>
          <div class="mb-3">
            <span class="profile-label fw-bold">Username:</span>
            <span class="profile-value ms-2"><?php echo htmlspecialchars($user['username']); ?></span>
          </div>
          <div class="mb-3">
            <span class="profile-label fw-bold">Email:</span>
            <span class="profile-value ms-2"><?php echo htmlspecialchars($user['email']); ?></span>
          </div>
          <div class="mb-3">
            <span class="profile-label fw-bold">User Type:</span>
            <span class="profile-value ms-2"><?php echo $user['usertype'] == 1 ? 'Admin' : 'Customer'; ?></span>
          </div>
          <div class="mb-3">
            <span class="profile-label fw-bold">Address:</span>
            <span class="profile-value ms-2"><?php echo htmlspecialchars($user['address'] ?? ''); ?></span>
          </div>
        </div>
        <div class="modal-footer border-danger d-flex justify-content-center">
          <a href="./edit_profile.php" class="btn btn-danger text-white">Edit Profile</a>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var modal = document.getElementById('viewProfileModal');
      if (modal) {
        modal.addEventListener('show.bs.modal', function() {
          document.body.classList.add('modal-blur-bg');
        });
        modal.addEventListener('hidden.bs.modal', function() {
          document.body.classList.remove('modal-blur-bg');
        });
      }
    });
  </script>
</body>
</html>
