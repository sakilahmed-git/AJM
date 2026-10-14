<?php
// result-download-login.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Download Marksheet | AJM English School</title>
  <meta name="description" content="Securely access your AJM English School marksheet.">
  <link rel="icon" type="image/png" href="unnamed-fotor-bg-remover-20250627142251.png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --navy:#0c2c4d; --navy-2:#164c70; --gold:#c9a45c; --gold-pale:#f7efde;
      --ink:#19334d; --muted:#718191; --line:#e5eaf0; --shadow:0 18px 48px rgba(12,44,77,.11);
    }
    *,*::before,*::after{box-sizing:border-box}
    html{scroll-behavior:smooth;scroll-padding-top:90px}
    body{margin:0;min-height:100vh;overflow-x:hidden;background:linear-gradient(180deg,#fffdf8 0%,#f5f8fb 60%,#fffdf8 100%);color:var(--ink);font:14px/1.6 Inter,Arial,sans-serif}
    a,button,input,select{ -webkit-tap-highlight-color:transparent }
    a:focus-visible,button:focus-visible,input:focus-visible,select:focus-visible{outline:3px solid var(--gold)!important;outline-offset:3px}
    h1,h2,h3,h4{font-family:Poppins,Inter,sans-serif;color:var(--navy)}
    /* Shared homepage announcement ticker */
    .ajm-ticker{height:38px;min-height:38px;width:100%;display:flex;align-items:center;gap:14px;padding:4px clamp(12px,2.5vw,42px);position:relative;z-index:1040;color:#fff;background:linear-gradient(100deg,#092744,#124a78 62%,#1e608a);box-shadow:0 4px 15px #09274422}
    .ajm-ticker-label{display:flex;align-items:center;gap:8px;white-space:nowrap;flex:0 0 auto;color:#f2dca9;font-size:9px;font-weight:800;letter-spacing:1.2px}
    .ticker-live-dot{width:6px;height:6px;border-radius:50%;background:#e7c77f;box-shadow:0 0 0 4px #e7c77f20;animation:livePulse 2s infinite}
    .ajm-ticker-window{flex:1;min-width:0;overflow:hidden}
    .ajm-ticker-track{display:flex;align-items:center;width:max-content;animation:bulletin 48s linear infinite}
    .ajm-ticker-track>span{display:flex;align-items:center;gap:9px;white-space:nowrap;padding:0 22px;border-right:1px solid #ffffff30;font-size:11px;font-weight:600}
    .ticker-toggle{width:27px;height:27px;flex:0 0 27px;display:grid;place-items:center;border:1px solid #ffffff65;border-radius:50%;background:#ffffff10;color:#fff;font-size:10px;transition:all .2s}
    .ticker-toggle:hover{background:var(--gold);color:var(--navy)}
    .ajm-ticker-track.is-paused{animation-play-state:paused}
    .ui-icon{display:inline-flex;align-items:center;justify-content:center;vertical-align:-.2em;margin-right:6px;color:#9bbdce}
    .ui-icon svg{width:1.1em;height:1.1em;stroke:currentColor;fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round}
    @keyframes bulletin{to{transform:translateX(-50%)}}
    @keyframes livePulse{50%{box-shadow:0 0 0 7px #e7c77f08;opacity:.7}}
    /* Shared homepage navigation */
    .navbar{width:100%;max-width:none;margin:0;padding:12px clamp(14px,3vw,48px);position:sticky;top:0;z-index:1030;border:0!important;border-bottom:1px solid #e6e8e7!important;border-radius:0;background:rgba(255,253,248,.9)!important;backdrop-filter:blur(22px) saturate(145%);-webkit-backdrop-filter:blur(22px) saturate(145%);box-shadow:0 8px 28px #0c2c4d0b!important}
    .navbar>.container-fluid{width:100%;max-width:1700px;margin:auto;padding:0;gap:18px}
    .navbar-brand{display:flex;align-items:center;gap:11px!important;margin:0;color:var(--navy)!important;font-size:clamp(1rem,1.45vw,1.4rem);font-weight:800;letter-spacing:-.5px;white-space:nowrap}
    .navbar-brand img{width:44px;height:44px;object-fit:contain;padding:3px;border-radius:13px;background:#fff;box-shadow:0 5px 15px #0c2c4d14}
    .navbar-collapse{flex-grow:0}
    .navbar-nav{align-items:center;gap:5px}
    .navbar .btn{margin:0!important;padding:10px 13px;border:1px solid transparent!important;border-radius:11px;font-size:12px;font-weight:800;white-space:nowrap;transition:transform .22s,box-shadow .22s,background .22s}
    .navbar .btn-outline-light{background:#f0f5fa;color:#244f75}
    .navbar .btn-outline-light:nth-child(3){background:#edf6f0;color:#36745d}
    .navbar .btn-outline-light:nth-child(4){background:#fbf2e4;color:#946d2e}
    .navbar .btn-outline-light:nth-child(5){background:#f4effb;color:#6a55a0}
    .navbar .btn-light{background:var(--navy)!important;color:#fff!important;box-shadow:0 7px 16px #0c2c4d1e}
    .navbar .btn:hover{transform:translateY(-2px);box-shadow:0 10px 22px #0c2c4d18}
    .navbar .btn[aria-current=page]{box-shadow:inset 0 0 0 1px #0c2c4d2e,0 5px 14px #0c2c4d12}
    .navbar-toggler{border:1px solid #dfe5e9!important;border-radius:10px;padding:7px 9px;box-shadow:none!important}
    /* Compact page content */
    .page-shell{width:100%;max-width:1100px;margin:0 auto;padding:clamp(25px,5vw,58px) clamp(15px,3vw,30px) 0}
    .form-layout{display:grid;grid-template-columns:minmax(0,.85fr) minmax(340px,1fr);align-items:center;gap:clamp(24px,5vw,62px)}
    .intro{padding:10px 0}
    .eyebrow{display:inline-flex;align-items:center;gap:8px;margin:0 0 13px;padding:7px 11px;border:1px solid #eadfc5;border-radius:999px;background:#fff9eb;color:#896b35;font-size:10px;font-weight:800;letter-spacing:1.2px;text-transform:uppercase}
    .eyebrow-dot{width:6px;height:6px;border-radius:50%;background:var(--gold)}
    .intro h1{margin:0 0 13px;font-size:clamp(2rem,4vw,3.5rem);line-height:1.06;letter-spacing:-.055em}
    .intro h1 span{color:#2c668b}
    .intro p{max-width:390px;margin:0;color:#63788a;font-size:14px;line-height:1.8}
    .secure-note{display:flex;align-items:center;gap:10px;margin-top:23px;color:#577267;font-size:12px;font-weight:700}
    .secure-note i{display:grid;place-items:center;width:34px;height:34px;border-radius:11px;background:#eaf5ef;color:#347b5c;font-size:16px}
    .form-card{padding:clamp(22px,3.2vw,34px);border:1px solid rgba(255,255,255,.95);border-radius:25px;background:rgba(255,255,255,.86);box-shadow:var(--shadow);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px)}
    .form-card-head{display:flex;align-items:center;gap:14px;margin-bottom:25px}
    .form-symbol{display:grid;place-items:center;width:50px;height:50px;flex:0 0 50px;border-radius:15px;background:linear-gradient(145deg,#e4eff8,#f7efdf);color:var(--navy);font-size:22px}
    .form-card h2{margin:0 0 4px;font-size:21px;font-weight:700;letter-spacing:-.5px}
    .form-card-head p{margin:0;color:var(--muted);font-size:12px}
    .form-label{margin-bottom:7px;color:#314d65;font-size:12px;font-weight:800}
    .form-control,.form-select,.input-group-text{min-height:47px;border-color:#dfe6ec;border-radius:11px!important;background-color:#fff;color:var(--ink);font-size:13px;box-shadow:none!important}
    .form-control,.form-select{padding:11px 13px}
    .input-group{gap:8px}
    .input-group-text{display:grid;place-items:center;width:46px;padding:0;background:#f2f6f8;color:#52758c}
    .form-control:focus,.form-select:focus{border-color:#86a9c1;background:#fff}
    .field-help{display:block;margin-top:6px;color:#8794a0;font-size:10px}
    .submit-btn{display:flex;align-items:center;justify-content:center;gap:10px;width:100%;min-height:49px;margin-top:7px;border:0;border-radius:12px;background:linear-gradient(110deg,var(--navy),#1d5b87);color:#fff;font-size:13px;font-weight:800;box-shadow:0 9px 20px #0c2c4d20;transition:transform .2s,box-shadow .2s}
    .submit-btn:hover{transform:translateY(-2px);box-shadow:0 13px 26px #0c2c4d2b}
    .privacy-line{display:flex;justify-content:center;align-items:center;gap:7px;margin:16px 0 0;color:#81909c;font-size:10px;text-align:center}
    .privacy-line i{color:#478064}
    .help-strip{display:flex;align-items:flex-start;gap:12px;margin-top:18px;padding:15px 17px;border:1px solid #eadfc5;border-radius:15px;background:linear-gradient(120deg,rgba(255,249,235,.94),rgba(255,253,248,.92))}
    .help-strip i{color:#987334;font-size:17px}
    .help-strip p{margin:0;color:#706d62;font-size:11px;line-height:1.7}
    /* Shared homepage footer */
    footer{margin-top:58px!important;padding:32px 16px!important;border-top:3px solid var(--gold);background:linear-gradient(110deg,#092744,#164c70)!important;color:#eaf1f5!important;text-align:center;font-family:Arial,sans-serif}
    footer .footer-school{font-size:14px;font-weight:600;margin-bottom:6px}
    footer .footer-contact{font-size:13px;line-height:1.5;margin-bottom:10px}
    footer a{color:#f1dba6!important;text-decoration:none}
    footer a:hover{color:#fff!important}
    footer .footer-divider{height:1px;width:85%;max-width:1100px;background:#ffffff35;margin:12px auto}
    footer small{color:#c5d4df!important;font-size:12px;display:block;margin-top:5px}
    @media(max-width:1100px){.navbar .btn{padding:9px 10px;font-size:11px}.navbar-nav{gap:4px}.form-layout{grid-template-columns:minmax(0,.8fr) minmax(330px,1fr);gap:28px}}
    @media(max-width:767.98px){
      html{scroll-padding-top:78px}
      .ajm-ticker{height:34px;min-height:34px;gap:8px;padding:3px 8px}
      .ajm-ticker-label{gap:6px;font-size:8px;letter-spacing:.65px}
      .ticker-live-dot{width:5px;height:5px}
      .ajm-ticker-track{animation-duration:34s}
      .ajm-ticker-track>span{gap:7px;padding:0 13px;font-size:9.5px;line-height:1.2}
      .ticker-toggle{width:25px;height:25px;flex-basis:25px;font-size:9px}
      .navbar{padding:8px 12px}
      .navbar>.container-fluid{gap:8px}
      .navbar-brand{font-size:15px;line-height:1.15;gap:8px!important;white-space:normal;min-width:0}
      .navbar-brand img{width:36px;height:36px;flex:0 0 36px}
      .navbar-brand small{font-size:10px!important}
      .navbar-collapse{padding:10px 0 4px}
      .navbar-nav{align-items:stretch;gap:5px}
      .navbar .btn{width:100%;text-align:left;padding:10px 12px;font-size:12px}
      .page-shell{padding:25px 13px 0}
      .form-layout{grid-template-columns:1fr;gap:19px;max-width:520px;margin:auto}
      .intro{padding:0 3px}
      .eyebrow{margin-bottom:10px;font-size:9px}
      .intro h1{font-size:clamp(2rem,9vw,2.7rem);margin-bottom:8px}
      .intro p{font-size:12px;line-height:1.65}
      .secure-note{margin-top:12px;font-size:11px}
      .secure-note i{width:30px;height:30px}
      .form-card{padding:20px 17px;border-radius:20px}
      .form-card-head{gap:11px;margin-bottom:20px}
      .form-symbol{width:44px;height:44px;flex-basis:44px;border-radius:13px;font-size:19px}
      .form-card h2{font-size:19px}
      .form-control,.form-select,.input-group-text{min-height:46px}
      .submit-btn{min-height:48px}
      .help-strip{margin-top:13px;padding:13px;border-radius:13px}
      footer{margin-top:38px!important;padding:25px 15px!important}
      footer .footer-contact{display:flex;flex-wrap:wrap;justify-content:center;column-gap:9px;row-gap:3px;font-size:12px}
      footer .footer-divider{width:92%}
    }
    @media(max-width:390px){.ajm-ticker-label{font-size:7.2px;letter-spacing:.45px;gap:4px}.ajm-ticker-track>span{padding:0 10px;font-size:9px}.navbar-brand{font-size:14px}.form-card{padding:18px 14px}}
    @media(prefers-reduced-motion:reduce){html{scroll-behavior:auto}*,*::before,*::after{animation-duration:.01ms!important;animation-iteration-count:1!important;transition-duration:.01ms!important}.ajm-ticker-track{animation:none!important}}
  </style>
</head>
<body>
  <!-- Shared school announcements -->
  <section class="ajm-ticker" aria-label="School announcements">
    <div class="ajm-ticker-label"><span class="ticker-live-dot"></span> SCHOOL UPDATES</div>
    <div class="ajm-ticker-window"><div class="ajm-ticker-track" id="ajmTickerTrack">
      <span>Admissions for 2025–26 — contact the school office for details</span>
      <span>Congratulations to our Class 10 batch for the reported 100% board results</span>
      <span>Smart classrooms and activity-based learning</span>
      <span>Annual Day, Sports Meet and Cultural Fest highlights</span>
      <span>Check the website for exam dates and result updates</span>
    </div></div>
    <button class="ticker-toggle" id="ajmTickerToggle" type="button" aria-pressed="false" aria-label="Pause announcement ticker" title="Pause or resume announcements">Ⅱ</button>
  </section>

  <!-- Shared homepage navigation -->
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">
        <img src="unnamed-fotor-bg-remover-20250627142251.png" alt="AJM School logo">
        <span>AJM English School<small style="display:block;font:500 10px Inter,Arial,sans-serif;letter-spacing:.2px;color:#738392;margin-top:1px">Gossaigaon, Assam</small></span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <div class="navbar-nav">
          <a class="btn btn-outline-light" href="index.php">Home</a>
          <a class="btn btn-outline-light" href="index.php#about">About</a>
          <a class="btn btn-outline-light" href="exam-dates.php">Exam Dates</a>
          <a class="btn btn-outline-light" href="results.php" aria-current="page">Results</a>
          <a class="btn btn-outline-light" href="fees.php">Pay Fees</a>
          <a class="btn btn-outline-light" href="gallery.php">Gallery</a>
          <a class="btn btn-outline-light" href="index.php#location">Contact</a>
          <a class="btn btn-light" href="login.php">Admin</a>
        </div>
      </div>
    </div>
  </nav>

  <main class="page-shell">
    <div class="form-layout">
      <section class="intro" aria-labelledby="page-title">
        <div class="eyebrow"><span class="eyebrow-dot"></span> Student portal</div>
        <h1 id="page-title">Download your <span>marksheet.</span></h1>
        <p>Enter your class, roll number and date of birth to access your result.</p>
        <div class="secure-note"><i class="bi bi-shield-lock-fill" aria-hidden="true"></i><span>Secure access for registered students</span></div>
      </section>

      <section class="form-card" aria-labelledby="form-title">
        <div class="form-card-head">
          <div class="form-symbol" aria-hidden="true"><i class="bi bi-file-earmark-check"></i></div>
          <div>
            <h2 id="form-title">Student verification</h2>
            <p>Enter the details registered with the school.</p>
          </div>
        </div>

        <form method="POST" action="marksheet.php" id="resultForm">
          <div class="mb-3">
            <label class="form-label" for="class">Class</label>
            <select name="class" id="class" class="form-select" required>
              <option value="" disabled selected>Select your class</option>
              <?php for ($i = 1; $i <= 10; $i++) echo "<option value=\"$i\">Class $i</option>"; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label" for="roll">Roll number</label>
            <input type="number" class="form-control" id="roll" name="roll" placeholder="Enter roll number" min="1" step="1" inputmode="numeric" required>
          </div>
          <div class="mb-3">
            <label class="form-label" for="dob">Date of birth</label>
            <div class="input-group">
              <span class="input-group-text" aria-hidden="true"><i class="bi bi-calendar-event"></i></span>
              <input type="text" class="form-control" id="dob" name="dob" placeholder="DD/MM/YYYY" inputmode="numeric" autocomplete="bday" required>
            </div>
            <small class="field-help">Use the date format DD/MM/YYYY.</small>
          </div>
          <button type="submit" class="submit-btn"><i class="bi bi-download" aria-hidden="true"></i> Download marksheet</button>
          <p class="privacy-line"><i class="bi bi-shield-check" aria-hidden="true"></i> Your details are used to verify your student record.</p>
        </form>
      </section>
    </div>

    <aside class="help-strip" aria-label="Help with marksheet access">
      <i class="bi bi-info-circle-fill" aria-hidden="true"></i>
      <p><strong>Need help?</strong> If your details are not accepted, please contact the school office. Full marksheets are available only to registered students.</p>
    </aside>
  </main>

  <!-- Shared homepage footer -->
  <footer>
    <div class="footer-school">AJM English School, Gossaigaon, Assam</div>
    <div class="footer-contact">
      <span>Email: <a href="mailto:ajmschool@gmail.com">ajmschool@gmail.com</a></span>
      <span aria-hidden="true">|</span>
      <span>Phone: <a href="tel:+919876543210">+91 98765 43210</a></span>
    </div>
    <div class="footer-divider"></div>
    <small>© 2026 AJM English School. All rights reserved.</small>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script>
    (() => {
      const ticker = document.querySelector('.ajm-ticker');
      const track = document.getElementById('ajmTickerTrack');
      const toggle = document.getElementById('ajmTickerToggle');

      if (ticker && track && toggle && !track.dataset.loopReady) {
        Array.from(track.children).forEach(item => {
          const clone = item.cloneNode(true);
          clone.setAttribute('aria-hidden', 'true');
          track.appendChild(clone);
        });
        track.dataset.loopReady = 'true';

        const pausedByButton = () => toggle.getAttribute('aria-pressed') === 'true';
        ticker.addEventListener('mouseenter', () => { track.style.animationPlayState = 'paused'; });
        ticker.addEventListener('mouseleave', () => { if (!pausedByButton()) track.style.animationPlayState = ''; });
        ticker.addEventListener('focusin', () => { track.style.animationPlayState = 'paused'; });
        ticker.addEventListener('focusout', () => { if (!pausedByButton()) track.style.animationPlayState = ''; });
        toggle.addEventListener('click', () => {
          const paused = track.classList.toggle('is-paused');
          toggle.textContent = paused ? '▶' : 'Ⅱ';
          toggle.setAttribute('aria-pressed', String(paused));
          toggle.setAttribute('aria-label', paused ? 'Resume announcement ticker' : 'Pause announcement ticker');
          toggle.setAttribute('title', paused ? 'Resume announcements' : 'Pause announcements');
        });
      }

      const dobInput = document.getElementById('dob');
      if (window.flatpickr && dobInput) {
        flatpickr(dobInput, {
          dateFormat: 'd/m/Y',
          allowInput: true,
          maxDate: 'today',
          disableMobile: true
        });
        dobInput.addEventListener('input', function () {
          const digits = this.value.replace(/\D/g, '').slice(0, 8);
          if (digits.length > 4) this.value = digits.slice(0, 2) + '/' + digits.slice(2, 4) + '/' + digits.slice(4);
          else if (digits.length > 2) this.value = digits.slice(0, 2) + '/' + digits.slice(2);
          else this.value = digits;
        });
      }
    })();
  </script>
</body>
</html>
