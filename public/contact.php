<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SendNoods - Contact Us</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@1,500;1,700&display=swap" rel="stylesheet">
  <style>
    body { background: #000; color: #dc2626; }
    .contact-title {
      font-family: 'Playfair Display', serif;
      font-style: italic;
      margin-top: 3.5rem;
    }
  </style>
</head>
<body>
  <?php include_once "includes/header.php"; ?>
  <main>
    <div class="w-full max-w-xl rounded-3xl shadow-lg p-8 mx-auto mt-8 bg-black border-2 border-red-600" style="min-height: 400px;">
      <!-- Header Image Start -->
      <div class="w-full mb-6">
        <img src="assets/images/contact.jpg" alt="Contact Header"
          class="rounded-2xl w-full object-cover shadow-lg"
          style="box-shadow: 0 0 16px 2px rgba(220,38,38,0.3); height: 120px; object-fit: cover;">
      </div>
      <!-- Header Image End -->
      <div class="contact-title text-center text-red-600 font-bold text-3xl mb-4">Contact the SendNoods Team</div>
      <div class="mb-4 text-white text-lg">
        <div class="flex items-center mb-1">
          <svg class="inline mr-2 text-red-600" width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.7 0 8 1.34 8 4v2H4v-2c0-2.66 5.3-4 8-4zm0-2a4 4 0 100-8 4 4 0 000 8z"/></svg>
          Developers: <span class="font-bold ml-1">SendNoods Team</span>
        </div>
        <div class="flex items-center mb-1">
          <svg class="inline mr-2 text-red-600" width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
          Email: <a href="mailto:sendnoods.team@gmail.com" class="text-red-600 ml-1">sendnoods.team@gmail.com</a>
        </div>
        <div class="mt-3 flex flex-row items-center justify-center space-x-6">
          <a href="https://twitter.com/sendnoods" target="_blank" title="Twitter" class="text-red-600 hover:text-white transition">
            <svg width="28" height="28" fill="currentColor" viewBox="0 0 24 24"><path d="M22.46 6c-.77.35-1.6.59-2.47.7a4.3 4.3 0 001.88-2.38 8.59 8.59 0 01-2.72 1.04A4.28 4.28 0 0016.11 4c-2.37 0-4.29 1.92-4.29 4.29 0 .34.04.67.11.99C7.69 9.13 4.07 7.38 1.64 4.7c-.37.64-.58 1.39-.58 2.19 0 1.51.77 2.84 1.94 3.62-.72-.02-1.39-.22-1.98-.54v.05c0 2.11 1.5 3.87 3.5 4.27-.37.1-.76.16-1.16.16-.28 0-.55-.03-.81-.08.55 1.72 2.16 2.97 4.07 3a8.6 8.6 0 01-5.33 1.84c-.35 0-.7-.02-1.04-.06A12.13 12.13 0 006.29 21c7.55 0 11.68-6.26 11.68-11.68 0-.18-.01-.36-.02-.54A8.18 8.18 0 0024 4.59a8.36 8.36 0 01-2.54.7z"/></svg>
          </a>
          <a href="https://facebook.com/sendnoods" target="_blank" title="Facebook" class="text-red-600 hover:text-white transition">
            <svg width="28" height="28" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 5 3.66 9.13 8.44 9.88v-6.99h-2.54v-2.89h2.54V9.41c0-2.5 1.49-3.89 3.77-3.89 1.09 0 2.23.2 2.23.2v2.45h-1.26c-1.24 0-1.63.77-1.63 1.56v1.87h2.78l-.44 2.89h-2.34v6.99C18.34 21.13 22 17 22 12z"/></svg>
          </a>
          <a href="https://instagram.com/sendnoods" target="_blank" title="Instagram" class="text-red-600 hover:text-white transition">
            <svg width="28" height="28" fill="currentColor" viewBox="0 0 24 24"><path d="M7.75 2h8.5A5.75 5.75 0 0122 7.75v8.5A5.75 5.75 0 0116.25 22h-8.5A5.75 5.75 0 012 16.25v-8.5A5.75 5.75 0 017.75 2zm0 1.5A4.25 4.25 0 003.5 7.75v8.5A4.25 4.25 0 007.75 20.5h8.5a4.25 4.25 0 004.25-4.25v-8.5A4.25 4.25 0 0016.25 3.5h-8.5zm4.25 2.75a5.75 5.75 0 110 11.5 5.75 5.75 0 010-11.5zm0 1.5a4.25 4.25 0 100 8.5 4.25 4.25 0 000-8.5zm6.25 1.25a1.25 1.25 0 110 2.5 1.25 1.25 0 010-2.5z"/></svg>
          </a>
          <a href="https://github.com/sendnoods" target="_blank" title="GitHub" class="text-red-600 hover:text-white transition">
            <svg width="28" height="28" fill="currentColor" viewBox="0 0 24 24"><path d="M12 .5C5.73.5.5 5.73.5 12c0 5.08 3.29 9.39 7.86 10.91.58.11.79-.25.79-.56v-2.17c-3.2.7-3.87-1.39-3.87-1.39-.53-1.34-1.3-1.7-1.3-1.7-1.06-.72.08-.71.08-.71 1.17.08 1.79 1.2 1.79 1.2 1.04 1.78 2.73 1.27 3.4.97.11-.75.41-1.27.75-1.56-2.56-.29-5.26-1.28-5.26-5.7 0-1.26.45-2.29 1.19-3.1-.12-.29-.52-1.46.11-3.04 0 0 .98-.31 3.2 1.18a11.1 11.1 0 012.92-.39c.99.01 1.99.13 2.92.39 2.22-1.49 3.2-1.18 3.2-1.18.63 1.58.23 2.75.11 3.04.74.81 1.19 1.84 1.19 3.1 0 4.43-2.7 5.41-5.27 5.7.42.36.8 1.09.8 2.2v3.26c0 .31.21.67.8.56C20.71 21.39 24 17.08 24 12c0-6.27-5.23-11.5-12-11.5z"/></svg>
          </a>
        </div>
      </div>
      <form method="post" action="mailto:sendnoods.team@gmail.com" enctype="text/plain">
        <div class="mb-4">
          <label for="name" class="block text-red-600 font-semibold mb-1">Your Name</label>
          <input type="text" class="bg-zinc-900 text-white border border-red-600 rounded-md px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-red-600" id="name" name="name" required maxlength="64">
        </div>
        <div class="mb-4">
          <label for="email" class="block text-red-600 font-semibold mb-1">Your Email</label>
          <input type="email" class="bg-zinc-900 text-white border border-red-600 rounded-md px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-red-600" id="email" name="email" required maxlength="64">
        </div>
        <div class="mb-4">
          <label for="message" class="block text-red-600 font-semibold mb-1">Message</label>
          <textarea class="bg-zinc-900 text-white border border-red-600 rounded-md px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-red-600" id="message" name="message" rows="4" required maxlength="500"></textarea>
        </div>
        <button type="submit" class="bg-red-600 text-white rounded-md py-2 px-8 text-lg font-bold transition hover:bg-red-800 block mx-auto">Send Message</button>
      </form>
    </div>
  </main>
</body>
</html>
