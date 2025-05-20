<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SendNoods - Contact Us</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@1,500;1,700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body { background: #000; color: #dc2626; }
    .contact-title {
      font-family: 'Playfair Display', serif;
      font-style: italic;
      margin-top: 3.5rem;
    }
    .contact-card {
      background: #000;
      border-radius: 1.5rem;
      box-shadow: 0 2px 16px rgba(220,38,38,0.15);
      padding: 2rem;
      max-width: 700px;
      margin: 2rem auto;
      border: 1.5px solid #dc2626;
    }
    .contact-info i {
      color: #dc2626;
      margin-right: 0.5rem;
    }
    .contact-social a {
      color: #dc2626;
      margin-right: 1.2rem;
      font-size: 1.7rem;
      transition: color 0.2s;
    }
    .contact-social a:hover {
      color: #fff;
    }
    .form-control, .form-control:focus {
      background: #222;
      color: #fff;
      border: 1px solid #dc2626;
    }
    .btn-danger {
      background: #dc2626;
      border: none;
    }
    .btn-danger:hover {
      background: #b91c1c;
    }
  </style>
</head>
<body>
  <?php include_once "includes/header.php"; ?>
  <main>
    <div class="contact-card w-full max-w-xl rounded-3xl shadow-lg p-8 mx-auto mt-8" style="min-height: 400px;">
      <!-- Header Image Start -->
      <div class="w-full mb-6">
        <img src="assets/images/contact.jpg" alt="Contact Header"
          class="rounded-2xl w-full object-cover shadow-lg"
          style="box-shadow: 0 0 16px 2px rgba(220,38,38,0.3); height: 120px; object-fit: cover;">
      </div>
      <!-- Header Image End -->
      <div class="contact-title text-center text-danger fw-bold text-3xl mb-4">Contact the SendNoods Team</div>
      <div class="contact-info mb-4 text-white text-lg">
        <div><i class="fas fa-user"></i>Developers: <span class="fw-bold">SendNoods Team</span></div>
        <div><i class="fas fa-envelope"></i>Email: <a href="mailto:sendnoods.team@gmail.com" class="text-danger">sendnoods.team@gmail.com</a></div>
        <div class="contact-social mt-3 flex flex-row items-center justify-center">
          <a href="https://twitter.com/sendnoods" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a>
          <a href="https://facebook.com/sendnoods" target="_blank" title="Facebook"><i class="fab fa-facebook"></i></a>
          <a href="https://instagram.com/sendnoods" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
          <a href="https://github.com/sendnoods" target="_blank" title="GitHub"><i class="fab fa-github"></i></a>
        </div>
      </div>
      <form method="post" action="mailto:sendnoods.team@gmail.com" enctype="text/plain">
        <div class="mb-3">
          <label for="name" class="form-label text-danger">Your Name</label>
          <input type="text" class="form-control rounded-md" id="name" name="name" required maxlength="64">
        </div>
        <div class="mb-3">
          <label for="email" class="form-label text-danger">Your Email</label>
          <input type="email" class="form-control rounded-md" id="email" name="email" required maxlength="64">
        </div>
        <div class="mb-3">
          <label for="message" class="form-label text-danger">Message</label>
          <textarea class="form-control rounded-md" id="message" name="message" rows="4" required maxlength="500"></textarea>
        </div>
        <button type="submit" class="btn btn-danger rounded-md py-2 px-8 text-lg font-bold transition hover:bg-red-800 block mx-auto">Send Message</button>
      </form>
    </div>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
