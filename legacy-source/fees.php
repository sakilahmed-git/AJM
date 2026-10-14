<?php
$classSelected = filter_input(INPUT_GET, 'class', FILTER_VALIDATE_INT);
if ($classSelected !== null && $classSelected !== false && ($classSelected < 1 || $classSelected > 10)) {
    $classSelected = null;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#101d3a">
  <title>Fee Dues – AJM English School</title>
  <link rel="icon" type="image/png" href="unnamed-fotor-bg-remover-20250627142251.png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
  <style>
    :root{--navy:#101d3a;--navy-2:#192b50;--gold:#e6bd62;--cream:#fbf8f0;--ink:#18243b;--muted:#6d7788;--line:#e8eaf0;--surface:#fff}
    *{box-sizing:border-box}
    body{margin:0;background:#f7f8fb;color:var(--ink);font-family:'DM Sans',sans-serif;font-size:14px;-webkit-font-smoothing:antialiased}
    h1,h2,h3,h4,h5,.navbar-brand{font-family:'Manrope',sans-serif}
    a{text-decoration:none}
    .updates-strip{height:38px;background:var(--navy);color:#fff;display:flex;align-items:center;overflow:hidden;font-size:11px;letter-spacing:.035em}
    .updates-label{height:100%;display:flex;align-items:center;gap:8px;padding:0 16px;background:var(--gold);color:var(--navy);font-weight:800;white-space:nowrap}
    .live-dot{width:7px;height:7px;border-radius:50%;background:#228b62;box-shadow:0 0 0 3px #228b6224}
    .ticker-window{flex:1;overflow:hidden;white-space:nowrap}
    .ticker-track{display:flex;width:max-content;animation:ticker 34s linear infinite}
    .ticker-track:hover{animation-play-state:paused}
    .ticker-item{padding:0 28px;color:#e9edf6}
    .ticker-item:before{content:'•';color:var(--gold);padding-right:10px}
    .ticker-control{border:0;background:transparent;color:#fff;padding:0 13px;height:100%}
    @keyframes ticker{to{transform:translateX(-50%)}}
    .site-nav{position:sticky;top:0;z-index:1000;background:rgba(251,248,240,.94);backdrop-filter:blur(18px);border-bottom:1px solid #e8e2d5;box-shadow:0 5px 24px #101d3a08}
    .site-nav .container{min-height:76px}
    .brand-mark{width:42px;height:42px;object-fit:contain;border-radius:10px;background:#fff}
    .brand-name{font-size:16px;line-height:1.2;font-weight:800;color:var(--navy);letter-spacing:-.035em}
    .brand-subtitle{font-size:10px;color:#7a7d85;letter-spacing:.08em;text-transform:uppercase;margin-top:3px}
    .navbar-nav{gap:5px;align-items:center}
    .nav-link{font-size:12px;font-weight:700;color:#4b566a!important;padding:10px 12px!important;border-radius:10px;transition:background .2s,color .2s}
    .nav-link:hover{background:#eee9dc;color:var(--navy)!important}
    .nav-link.active{background:var(--navy);color:#fff!important}
    .navbar-toggler{border:1px solid #d7d9df;border-radius:10px;padding:7px 10px}
    .navbar-toggler:focus{box-shadow:0 0 0 3px #e6bd6240}
    .page-wrap{width:min(1120px,calc(100% - 40px));margin:38px auto 70px}
    .page-heading{display:flex;justify-content:space-between;align-items:flex-end;gap:18px;margin-bottom:24px}
    .eyebrow{display:inline-flex;align-items:center;gap:8px;color:#8b6a25;font-size:10px;font-weight:800;letter-spacing:.14em;text-transform:uppercase;margin-bottom:9px}
    .eyebrow:before{content:'';width:20px;height:2px;background:var(--gold)}
    .page-heading h1{font-size:clamp(27px,4vw,39px);font-weight:800;letter-spacing:-.055em;margin:0;color:var(--navy)}
    .page-heading p{margin:8px 0 0;color:var(--muted);font-size:13px}
    .secure-note{display:flex;align-items:center;gap:8px;color:#617064;background:#edf5ef;border:1px solid #dcebdd;border-radius:999px;padding:9px 13px;font-size:11px;font-weight:700;white-space:nowrap}
    .selector-panel{background:var(--surface);border:1px solid var(--line);border-radius:18px;padding:22px;margin-bottom:22px;box-shadow:0 8px 30px #17213b05}
    .selector-row{display:flex;align-items:flex-end;gap:16px}
    .field-wrap{flex:1;min-width:0}
    .field-label{display:block;font-size:11px;font-weight:800;color:#49546a;margin-bottom:8px}
    .form-select{min-height:48px;border:1px solid #dfe3eb;border-radius:11px;color:var(--ink);font-size:13px;padding:12px 40px 12px 14px;background-color:#fcfcfd}
    .form-select:focus{border-color:#c5a14d;box-shadow:0 0 0 4px #e6bd6226}
    .btn-gold{min-height:48px;border:1px solid var(--gold);background:var(--gold);color:var(--navy);font-weight:800;font-size:12px;border-radius:11px;padding:0 21px;transition:transform .2s,background .2s}
    .btn-gold:hover{background:#f0cc77;color:var(--navy);transform:translateY(-1px)}
    .table-panel{overflow:hidden;border:1px solid var(--line);border-radius:18px;background:#fff;box-shadow:0 10px 35px #17213b06}
    .table-heading{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:19px 22px;border-bottom:1px solid var(--line)}
    .table-heading h2{font-size:15px;font-weight:800;margin:0;color:var(--navy)}
    .class-pill{font-size:11px;font-weight:800;color:#76591b;background:#fbf3dd;border:1px solid #f0e3bd;border-radius:999px;padding:6px 10px}
    .table-responsive{margin:0}
    .fee-table{margin:0;vertical-align:middle;min-width:600px}
    .fee-table thead th{background:#f7f8fb;color:#778093;font-size:10px;text-transform:uppercase;letter-spacing:.08em;font-weight:800;padding:15px 20px;border-bottom:1px solid var(--line);white-space:nowrap}
    .fee-table tbody td{padding:15px 20px;border-bottom:1px solid #eff0f4;font-size:13px}
    .fee-table tbody tr:last-child td{border-bottom:0}
    .fee-table tbody tr:hover{background:#fcfbf7}
    .student-name{font-weight:700;color:#202b41}
    .roll-chip{display:inline-flex;align-items:center;justify-content:center;min-width:34px;padding:5px 8px;border-radius:8px;background:#f0f2f7;color:#526078;font-size:11px;font-weight:800}
    .amount{font-weight:800;color:var(--navy);font-variant-numeric:tabular-nums}
    .pay-button{display:inline-flex;align-items:center;gap:7px;background:var(--navy);color:#fff;border:0;border-radius:9px;padding:9px 13px;font-size:11px;font-weight:800;white-space:nowrap}
    .pay-button:hover{background:#263c67;color:#fff}
    .empty-state{text-align:center;padding:42px 20px;color:var(--muted)}
    .empty-icon{width:48px;height:48px;display:grid;place-items:center;margin:0 auto 13px;border-radius:15px;background:#f5f0e3;color:#9a762b;font-size:21px}
    .empty-state h3{font-size:15px;font-weight:800;color:var(--navy);margin-bottom:6px}
    .empty-state p{font-size:12px;margin:0}
    .page-footnote{display:flex;align-items:flex-start;gap:10px;margin-top:16px;color:#727d8e;font-size:11px;line-height:1.6}
    .page-footnote i{color:#9b7a32;font-size:15px}
    .site-footer{background:linear-gradient(135deg,#101d3a,#192b50);border-top:3px solid var(--gold);color:#e9edf5;padding:28px 0 18px}
    .footer-inner{width:min(1120px,calc(100% - 40px));margin:auto;display:flex;align-items:center;justify-content:space-between;gap:18px}
    .footer-school{font-family:'Manrope',sans-serif;font-size:14px;font-weight:800;color:#fff}
    .footer-contact{display:flex;flex-wrap:wrap;gap:16px;margin-top:8px;color:#c4cddd;font-size:11px}
    .footer-contact a{color:inherit}
    .footer-contact i{color:var(--gold);margin-right:5px}
    .footer-copy{border-top:1px solid #ffffff20;margin:20px auto 0;padding-top:14px;width:min(1120px,calc(100% - 40px));font-size:10px;color:#aebbd0;text-align:center}
    @media(min-width:992px){.navbar-collapse{justify-content:flex-end}}
    @media(max-width:991.98px){.navbar-nav{align-items:stretch;padding:12px 0 15px}.nav-link{padding:11px 12px!important}.site-nav .container{min-height:68px}}
    @media(max-width:650px){.updates-strip{height:35px}.updates-label{padding:0 10px;font-size:9px}.ticker-item{padding:0 17px;font-size:10px}.page-wrap{width:calc(100% - 28px);margin:27px auto 48px}.page-heading{align-items:flex-start;flex-direction:column;gap:12px;margin-bottom:19px}.page-heading h1{font-size:29px}.page-heading p{font-size:12px}.secure-note{font-size:10px}.selector-panel{padding:16px;border-radius:15px}.selector-row{align-items:stretch;flex-direction:column;gap:12px}.btn-gold{width:100%}.table-heading{padding:16px}.fee-table thead th,.fee-table tbody td{padding:13px 15px}.footer-inner{width:calc(100% - 32px);align-items:flex-start;flex-direction:column}.footer-copy{width:calc(100% - 32px)}}
    @media(prefers-reduced-motion:reduce){*,*::before,*::after{animation-duration:.01ms!important;transition-duration:.01ms!important;scroll-behavior:auto!important}}
  </style>

  <style>
    :root{--navy:#0c2c4d;--blue:#164b7a;--blue-2:#2d6c9d;--gold:#c9a45c;--gold-pale:#f7efde;--ink:#19334d;--muted:#6e7f90;--ivory:#fffdf8;--line:#e8e5dc;--shadow:0 16px 42px rgba(12,44,77,.09);--shadow-hover:0 22px 48px rgba(12,44,77,.14);--glass:rgba(255,255,255,.86)}
    html{scroll-behavior:smooth;scroll-padding-top:95px}
    body{background:linear-gradient(180deg,#fffdf8 0%,#f6f9fc 50%,#fffdf8 100%);color:var(--ink);font:15px/1.65 Inter,Arial,sans-serif}
    h1,h2,h3,h4,h5,h6{color:var(--navy);font-family:Georgia,'Times New Roman',serif}
    a:focus-visible,button:focus-visible,select:focus-visible{outline:3px solid var(--gold)!important;outline-offset:3px}
    .ajm-ticker{height:38px;min-height:38px;width:100%;display:flex;align-items:center;gap:14px;padding:4px clamp(12px,2.5vw,42px);position:relative;z-index:1040;color:#fff;background:linear-gradient(100deg,#092744,#124a78 62%,#1e608a);box-shadow:0 4px 15px #09274422}
    .ajm-ticker-label{display:flex;align-items:center;gap:8px;white-space:nowrap;flex:0 0 auto;color:#f2dca9;font-size:9px;font-weight:800;letter-spacing:1.2px}
    .ticker-live-dot{width:6px;height:6px;border-radius:50%;background:#e7c77f;box-shadow:0 0 0 4px #e7c77f20;animation:livePulse 2s infinite}
    .ajm-ticker-window{flex:1;min-width:0;overflow:hidden}
    .ajm-ticker-track{display:flex;align-items:center;width:max-content;animation:bulletin 48s linear infinite}
    .ajm-ticker-track>span{display:flex;align-items:center;gap:9px;white-space:nowrap;padding:0 22px;border-right:1px solid #ffffff30;font-size:11px;font-weight:600}
    .ticker-toggle{width:27px;height:27px;flex:0 0 27px;display:grid;place-items:center;border:1px solid #ffffff65;border-radius:50%;background:#ffffff10;color:#fff;font-size:10px;transition:all .2s}
    .ticker-toggle:hover{background:var(--gold);color:var(--navy);transform:scale(1.06)}
    .ajm-ticker-track.is-paused{animation-play-state:paused}
    .ui-icon{display:inline-flex;align-items:center;justify-content:center;vertical-align:-.2em;margin-right:6px;color:#527b8b}
    .ui-icon svg{width:1.1em;height:1.1em;stroke:currentColor;fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round}
    @keyframes bulletin{to{transform:translateX(-50%)}}
    @keyframes livePulse{50%{box-shadow:0 0 0 7px #e7c77f08;opacity:.7}}
    .navbar{width:100%;max-width:none;margin:0;padding:12px clamp(14px,3vw,48px);position:sticky;top:0;z-index:1030;border:0!important;border-bottom:1px solid #e6e8e7!important;border-radius:0;background:rgba(255,253,248,.88)!important;backdrop-filter:blur(22px) saturate(145%);-webkit-backdrop-filter:blur(22px) saturate(145%);box-shadow:0 8px 28px #0c2c4d0b!important}
    .navbar>.container-fluid{width:100%;max-width:1700px;margin:auto;padding:0;gap:18px}
    .navbar-brand{display:flex;align-items:center;gap:11px!important;margin:0;color:var(--navy)!important;font-size:clamp(1rem,1.45vw,1.4rem);font-weight:800;letter-spacing:-.5px;white-space:nowrap}
    .navbar-brand img{width:44px;height:44px;object-fit:contain;padding:3px;border-radius:13px!important;background:#fff;box-shadow:0 5px 15px #0c2c4d14}
    .navbar-collapse{flex-grow:0}
    .navbar-nav{align-items:center;gap:5px}
    .navbar .btn{margin:0!important;padding:10px 13px;border:1px solid transparent!important;border-radius:11px;font-size:12px;font-weight:800;white-space:nowrap;transition:transform .22s,box-shadow .22s,background .22s}
    .navbar .btn-outline-light{background:#f0f5fa;color:#244f75}
    .navbar .btn-outline-light:nth-child(2){background:#edf6f0;color:#36745d}
    .navbar .btn-outline-light:nth-child(3){background:#fbf2e4;color:#946d2e}
    .navbar .btn-outline-light:nth-child(4){background:#f4effb;color:#6a55a0}
    .navbar .btn-light{background:var(--navy)!important;color:#fff!important;box-shadow:0 7px 16px #0c2c4d1e}
    .navbar .btn:hover{transform:translateY(-2px);box-shadow:0 10px 22px #0c2c4d18}
    .navbar .btn[aria-current="page"]{box-shadow:inset 0 0 0 1px rgba(12,44,77,.18),0 5px 14px #0c2c4d12}
    .navbar-toggler{border:1px solid #dfe5e9!important;border-radius:10px;padding:7px 9px;box-shadow:none!important}
    footer{margin-top:65px!important;padding:32px 16px!important;border-top:3px solid var(--gold);background:linear-gradient(110deg,#092744,#164c70)!important;color:#eaf1f5!important;text-align:center;font-family:Arial,sans-serif}
    footer .footer-school{font-size:14px;font-weight:600;margin-bottom:6px}
    footer .footer-contact{font-size:13px;line-height:1.5;margin-bottom:10px}
    footer a{color:#f1dba6!important;text-decoration:none}
    footer a:hover{color:#fff!important}
    footer .footer-divider{height:1px;width:85%;max-width:1100px;background:#ffffff35;margin:12px auto}
    footer small{color:#c5d4df!important;font-size:12px;display:block;margin-top:5px}
    @media(max-width:1100px){.navbar .btn{padding:9px 10px;font-size:11px}.navbar-nav{gap:4px}}
    @media(max-width:767.98px){html{scroll-padding-top:78px}body{font-size:14px}.ajm-ticker{height:34px;min-height:34px;gap:8px;padding:3px 8px}.ajm-ticker-label{gap:6px;font-size:8px;letter-spacing:.65px}.ticker-live-dot{width:5px;height:5px}.ajm-ticker-window{flex:1 1 auto;min-width:0}.ajm-ticker-track{animation-duration:34s}.ajm-ticker-track>span{gap:7px;padding:0 13px;font-size:9.5px;line-height:1.2}.ajm-ticker-track .ui-icon{margin-right:0;font-size:10px}.ticker-toggle{width:25px;height:25px;flex:0 0 25px;font-size:9px}.navbar{position:sticky;top:0;padding:8px 12px;z-index:1030}.navbar>.container-fluid{gap:8px}.navbar-brand{font-size:15px;line-height:1.15;gap:8px!important;white-space:normal;min-width:0}.navbar-brand img{width:36px;height:36px;flex:0 0 36px}.navbar-brand small{font-size:10px!important}.navbar-toggler{padding:6px 8px}.navbar-collapse{padding:10px 0 4px}.navbar-nav{align-items:stretch;gap:5px}.navbar .btn{width:100%;text-align:left;padding:10px 12px;font-size:12px}footer{margin-top:40px!important;padding:26px 15px!important}footer .footer-contact{display:flex;flex-wrap:wrap;justify-content:center;column-gap:9px;row-gap:3px;font-size:12px}footer .footer-divider{width:92%}}
    @media(max-width:390px){.ajm-ticker-label{font-size:7.2px;letter-spacing:.45px;gap:4px}.ajm-ticker-track>span{padding:0 10px;font-size:9px}.navbar-brand{font-size:14px}}
    @media(prefers-reduced-motion:reduce){html{scroll-behavior:auto}*,*::before,*::after{animation-duration:.01ms!important;animation-iteration-count:1!important;transition-duration:.01ms!important}.ajm-ticker-track{animation:none!important}}
  </style>

</head>
<body>
  <!-- Exact shared header structure from index.php -->
  <section class="ajm-ticker" aria-label="School announcements">
    <div class="ajm-ticker-label"><span class="ticker-live-dot"></span> SCHOOL UPDATES</div>
    <div class="ajm-ticker-window"><div class="ajm-ticker-track" id="ajmTickerTrack">
      <span><span class="ui-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="m3 11 18-5-5 17-4-7-9-5Z"/><path d="m12 16 4-5"/></svg></span>Admissions for 2025–26 — contact the school office for details</span>
      <span><span class="ui-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M8 21h8M12 17v4M7 4h10v5a5 5 0 0 1-10 0V4Z"/><path d="M7 6H4v2a4 4 0 0 0 4 4M17 6h3v2a4 4 0 0 1-4 4"/></svg></span>Congratulations to our Class 10 batch for the reported 100% board results</span>
      <span><span class="ui-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="4" width="18" height="13" rx="2"/><path d="M8 21h8M12 17v4M7 9h10M7 12h6"/></svg></span>Smart classrooms and activity-based learning</span>
      <span><span class="ui-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 10 12 3l9 7v10H3Z"/><path d="M9 20v-6h6v6"/></svg></span>Annual Day, Sports Meet and Cultural Fest highlights</span>
      <span><span class="ui-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="4" y="3" width="16" height="18" rx="2"/><path d="M8 7h8M8 11h8M8 15h5"/></svg></span>Check the website for exam dates and result updates</span>
    </div></div>
    <button class="ticker-toggle" id="ajmTickerToggle" type="button" aria-pressed="false" aria-label="Pause announcement ticker" title="Pause or resume announcements">Ⅱ</button>
  </section>

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
          <a class="btn btn-outline-light" href="fees.php" aria-current="page">Pay Fees</a>
          <a class="btn btn-outline-light" href="gallery.php">Gallery</a>
          <a class="btn btn-outline-light" href="index.php#location">Contact</a>
          <a class="btn btn-light" href="login.php">Admin</a>
        </div>
      </div>
    </div>
  </nav>

  <main class="page-wrap">
    <header class="page-heading">
      <div>
        <div class="eyebrow">Student finance portal</div>
        <h1>Fee dues</h1>
        <p>Select your class to view outstanding fee records.</p>
      </div>
      <div class="secure-note"><i class="bi bi-shield-check"></i> Secure payment checkout</div>
    </header>

    <section class="selector-panel" aria-label="Select class">
      <form method="GET" action="fees.php" class="selector-row">
        <div class="field-wrap">
          <label class="field-label" for="class">CLASS</label>
          <select name="class" id="class" class="form-select" required>
            <option value="" disabled <?= $classSelected === null ? 'selected' : '' ?>>Choose a class</option>
            <?php for ($i = 1; $i <= 10; $i++): ?>
              <option value="<?= $i ?>" <?= $classSelected === $i ? 'selected' : '' ?>>Class <?= $i ?></option>
            <?php endfor; ?>
          </select>
        </div>
        <button type="submit" class="btn-gold"><i class="bi bi-search me-2"></i>View fee dues</button>
      </form>
    </section>

    <?php if ($classSelected !== null): ?>
      <?php
        $filePath = __DIR__ . "/fees_data/class{$classSelected}.csv";
        $feeRows = [];
        if (is_file($filePath) && is_readable($filePath) && ($file = fopen($filePath, "r")) !== false) {
            fgetcsv($file); // Skip the CSV header row.
            while (($row = fgetcsv($file)) !== false) {
                if (count($row) < 3) continue;
                $roll = trim((string)$row[0]);
                $name = trim((string)$row[1]);
                $amount = filter_var(trim((string)$row[2]), FILTER_VALIDATE_FLOAT);
                if ($name === '' || $amount === false || $amount < 0) continue;
                $feeRows[] = ['roll' => $roll, 'name' => $name, 'amount' => (float)$amount];
            }
            fclose($file);
        }
      ?>
      <section class="table-panel" aria-label="Fee dues for Class <?= $classSelected ?>">
        <div class="table-heading">
          <h2>Outstanding fee records</h2>
          <span class="class-pill">Class <?= $classSelected ?></span>
        </div>
        <?php if (!is_file($filePath)): ?>
          <div class="empty-state"><div class="empty-icon"><i class="bi bi-folder2-open"></i></div><h3>No fee record found</h3><p>No fee file is available for Class <?= $classSelected ?>.</p></div>
        <?php elseif (empty($feeRows)): ?>
          <div class="empty-state"><div class="empty-icon"><i class="bi bi-clipboard-check"></i></div><h3>No fee entries to display</h3><p>There are no valid student fee entries in this class file.</p></div>
        <?php else: ?>
          <div class="table-responsive">
            <table class="table fee-table">
              <thead><tr><th scope="col">Roll</th><th scope="col">Student name</th><th scope="col">Due amount</th><th scope="col">Payment</th></tr></thead>
              <tbody>
              <?php foreach ($feeRows as $student): ?>
                <tr>
                  <td><span class="roll-chip"><?= htmlspecialchars($student['roll'], ENT_QUOTES, 'UTF-8') ?></span></td>
                  <td class="student-name"><?= htmlspecialchars($student['name'], ENT_QUOTES, 'UTF-8') ?></td>
                  <td class="amount">₹<?= number_format($student['amount'], 2) ?></td>
                  <td>
                    <button type="button" class="pay-button" data-name="<?= htmlspecialchars($student['name'], ENT_QUOTES, 'UTF-8') ?>" data-class="<?= $classSelected ?>" data-amount="<?= htmlspecialchars((string)$student['amount'], ENT_QUOTES, 'UTF-8') ?>">
                      <i class="bi bi-lock-fill"></i> Pay now
                    </button>
                  </td>
                </tr>
              <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </section>
      <div class="page-footnote"><i class="bi bi-info-circle"></i><span>Review the student name and due amount before continuing. Keep your payment receipt for future reference.</span></div>
    <?php else: ?>
      <section class="table-panel">
        <div class="empty-state"><div class="empty-icon"><i class="bi bi-receipt"></i></div><h3>Choose a class to get started</h3><p>Fee records will appear here after you select a class above.</p></div>
      </section>
    <?php endif; ?>
  </main>

  <!-- Exact homepage footer layout and contact details -->
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    (() => {
      const track = document.getElementById('tickerTrack');
      const toggle = document.getElementById('tickerToggle');
      let paused = false;
      toggle.addEventListener('click', () => {
        paused = !paused;
        track.style.animationPlayState = paused ? 'paused' : 'running';
        toggle.innerHTML = paused ? '<i class="bi bi-play-fill"></i>' : '<i class="bi bi-pause-fill"></i>';
        toggle.setAttribute('aria-label', paused ? 'Resume school updates' : 'Pause school updates');
      });

      document.querySelectorAll('.pay-button').forEach(button => {
        button.addEventListener('click', () => {
          const name = button.dataset.name;
          const className = button.dataset.class;
          const amount = Number(button.dataset.amount);
          if (!Number.isFinite(amount) || amount <= 0) {
            alert('There is no payable fee amount for this record.');
            return;
          }
          const options = {
            key: 'rzp_test_1D80S07ltx6VCy',
            amount: Math.round(amount * 100),
            currency: 'INR',
            name: 'AJM English School',
            description: `Fee payment for ${name} (Class ${className})`,
            handler: function (response) {
              const form = document.createElement('form');
              form.method = 'POST';
              form.action = 'receipt.php';
              const values = {
                payment_id: response.razorpay_payment_id,
                name: name,
                class: className,
                amount: amount
              };
              Object.entries(values).forEach(([key, value]) => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = key;
                input.value = String(value);
                form.appendChild(input);
              });
              document.body.appendChild(form);
              form.submit();
            },
            prefill: {name},
            theme: {color: '#101d3a'}
          };
          const checkout = new Razorpay(options);
          checkout.open();
        });
      });
    })();
  </script>
</body>
</html>
