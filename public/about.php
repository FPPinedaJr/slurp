<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SendNoods - About Us</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@1,500;1,700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body { background: #000; color: #dc2626; }
    .about-title {
      font-family: 'Playfair Display', serif;
      font-style: italic;
      margin-top: 3.5rem;
    }
    .about-desc {
      font-family: 'Playfair Display', serif;
      font-style: italic;
      min-height: 420px;
      max-height: 420px;
      overflow: hidden;
      transition: none;
      white-space: pre-line;
      word-break: break-word;
    }
    .about-fixed {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 700px;
      max-width: 98vw;
      min-height: 800px;
      max-height: 800px;
      z-index: 10;
      overflow: hidden;
    }
    @media (max-width: 700px) {
      .about-fixed {
        width: 99vw;
        min-height: 600px;
        max-height: 600px;
        padding: 1rem !important;
      }
      .about-desc {
        min-height: 340px;
        max-height: 340px;
      }
    }
    .typewriter-cursor {
      display: inline-block;
      width: 1ch;
      color: #dc2626;
      animation: blink 1s steps(1) infinite;
      font-weight: bold;
    }
    @keyframes blink {
      0%, 50% { opacity: 1; }
      51%, 100% { opacity: 0; }
    }
  </style>
</head>

<body>
  <?php include_once "includes/header.php"; ?>
  <main>
    <div class="about-fixed w-full max-w-2xl bg-black border-0 rounded-3xl shadow-none p-0 mb-4 flex flex-col items-center justify-center" style="min-height:800px;max-height:800px;">
      <div class="about-title text-center text-danger fw-bold text-3xl mb-4">About SendNoods</div>
      <div class="w-100 flex justify-center mb-4">
        <img src="./assets/images/header.jpg" alt="About SendNoods" style="width:100%;max-width:650px;max-height:320px;height:auto;border-radius:1rem;object-fit:cover;">
      </div>
      <div class="about-desc text-white text-lg mb-4 leading-relaxed" id="aboutTypewriter"></div>
    </div>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const aboutText = `Welcome to SendNoods, where we bring the authentic taste of Japan to your table. We specialize in traditional Japanese cuisine made with fresh ingredients and prepared with care. From sushi and sashimi to ramen and donburi, our menu offers a variety of dishes that reflect the rich flavors and culture of Japan.

At SendNoods, we are passionate about bringing the rich traditions of Japanese noodle culture to your table. Our journey began with a simple idea: to serve handcrafted bowls of noodles made with the finest ingredients, bold flavors, and a touch of cheeky fun.

Whether you crave classic broths or modern twists, every dish is prepared with care and respect for the art of Japanese comfort food. We believe in quality, authenticity, and making every meal a memorable experience.`;

      const el = document.getElementById('aboutTypewriter');
      let i = 0;
      function typeWriterLetter() {
        if (i < aboutText.length) {
          let char = aboutText[i];
          if (char === "\n") {
            el.innerHTML += "<br>";
          } else {
            el.innerHTML += char;
          }
          i++;
          setTimeout(typeWriterLetter, 18);
        } else {
          el.innerHTML += '<span class="typewriter-cursor">&nbsp;</span>';
        }
      }
      // Fill with invisible text to prevent box from moving
      const invisible = `<span style="opacity:0;pointer-events:none;">${aboutText.replace(/\n/g, '<br>')}</span>`;
      el.innerHTML = invisible;
      setTimeout(() => {
        el.innerHTML = '';
        typeWriterLetter();
      }, 100);
    });
  </script>
</body>
</html>