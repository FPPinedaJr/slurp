<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SendNoods - About Us</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@1,500;1,700&display=swap" rel="stylesheet">
  <style>
    .about-title, .about-desc {
      font-family: 'Playfair Display', serif;
      font-style: italic;
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

<body class="bg-black text-red-600">
  <?php include_once "includes/header.php"; ?>
  <main>
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] max-w-[98vw] min-h-[800px] max-h-[800px] z-10 overflow-hidden bg-black border-0 rounded-3xl shadow-none p-0 mb-4 flex flex-col items-center justify-center
      md:w-[700px] md:max-w-[98vw] md:min-h-[800px] md:max-h-[800px]
      sm:w-[99vw] sm:min-h-[600px] sm:max-h-[600px] sm:p-4">
      <div class="about-title text-center text-red-600 font-bold text-3xl mb-4 mt-14">About SendNoods</div>
      <div class="w-full flex justify-center mb-4">
        <img src="./assets/images/header.jpg" alt="About SendNoods" class="w-full max-w-2xl max-h-80 rounded-xl object-cover" />
      </div>
      <div class="about-desc text-white text-lg mb-4 leading-relaxed min-h-[340px] max-h-[420px] overflow-hidden whitespace-pre-line break-words" id="aboutTypewriter"></div>
    </div>
  </main>
  <script>
    $(function() {
      const aboutText = `Welcome to SendNoods, where we bring the authentic taste of Japan to your table. We specialize in traditional Japanese cuisine made with fresh ingredients and prepared with care. From sushi and sashimi to ramen and donburi, our menu offers a variety of dishes that reflect the rich flavors and culture of Japan.

At SendNoods, we are passionate about bringing the rich traditions of Japanese noodle culture to your table. Our journey began with a simple idea: to serve handcrafted bowls of noodles made with the finest ingredients, bold flavors, and a touch of cheeky fun.

Whether you crave classic broths or modern twists, every dish is prepared with care and respect for the art of Japanese comfort food. We believe in quality, authenticity, and making every meal a memorable experience.`;

      const $el = $('#aboutTypewriter');
      let i = 0;
      function typeWriterLetter() {
        if (i < aboutText.length) {
          let char = aboutText[i];
          if (char === "\n") {
            $el.append("<br>");
          } else {
            $el.append(char);
          }
          i++;
          setTimeout(typeWriterLetter, 18);
        } else {
          $el.append('<span class="typewriter-cursor">&nbsp;</span>');
        }
      }
      // Fill with invisible text to prevent box from moving
      const invisible = `<span style="opacity:0;pointer-events:none;">${aboutText.replace(/\n/g, '<br>')}</span>`;
      $el.html(invisible);
      setTimeout(() => {
        $el.html('');
        typeWriterLetter();
      }, 100);
    });
  </script>
</body>
</html>