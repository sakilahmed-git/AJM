<?php
// results.php — class-wise toppers
$rankOrder = ["1st" => 1, "2nd" => 2, "3rd" => 3, "4th" => 4, "5th" => 5];
$classesWithToppers = [];
for ($class = 1; $class <= 10; $class++) {
    $filePath = __DIR__ . "/results_data/class{$class}.json";
    if (!is_file($filePath)) continue;
    $json = file_get_contents($filePath);
    $data = json_decode($json, true);
    if (!is_array($data)) continue;
    $rankedStudents = [];
    foreach ($data as $roll => $stu) {
        if (!is_array($stu)) continue;
        $rank = trim((string)($stu['Rank1'] ?? ''));
        if ($rank !== '' && isset($rankOrder[$rank])) {
            $rankedStudents[] = [
                'name' => (string)($stu['Name'] ?? 'Student'),
                'rank' => $rank,
                'rankValue' => $rankOrder[$rank]
            ];
        }
    }
    usort($rankedStudents, static function ($a, $b) { return $a['rankValue'] <=> $b['rankValue']; });
    if ($rankedStudents) $classesWithToppers[$class] = $rankedStudents;
}
$totalToppers = array_sum(array_map('count', $classesWithToppers));
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Results | AJM English School</title>
  <meta name="description" content="View class-wise toppers at AJM English School, Gossaigaon, Assam.">
  <link rel="icon" type="image/png" href="unnamed-fotor-bg-remover-20250627142251.png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
  <style>
    :root{--navy:#0c2c4d;--navy2:#164c70;--gold:#c9a45c;--ink:#19334d;--muted:#718191;--line:#e5eaf0;--shadow:0 18px 48px rgba(12,44,77,.09)}
    *,*::before,*::after{box-sizing:border-box}html{scroll-behavior:smooth;scroll-padding-top:90px}
    body{margin:0;min-height:100vh;overflow-x:hidden;background:linear-gradient(180deg,#fffdf8 0%,#f5f8fb 62%,#fffdf8 100%);color:var(--ink);font:14px/1.6 Inter,Arial,sans-serif}
    h1,h2,h3,h4{font-family:Poppins,Inter,sans-serif;color:var(--navy)}a,button{-webkit-tap-highlight-color:transparent}a:focus-visible,button:focus-visible{outline:3px solid var(--gold)!important;outline-offset:3px}
    .ajm-ticker{height:38px;min-height:38px;display:flex;align-items:center;gap:14px;padding:4px clamp(12px,2.5vw,42px);position:relative;z-index:1040;color:#fff;background:linear-gradient(100deg,#092744,#124a78 62%,#1e608a);box-shadow:0 4px 15px #09274422}
    .ajm-ticker-label{display:flex;align-items:center;gap:8px;white-space:nowrap;flex:0 0 auto;color:#f2dca9;font-size:9px;font-weight:800;letter-spacing:1.2px}.ticker-live-dot{width:6px;height:6px;border-radius:50%;background:#e7c77f;box-shadow:0 0 0 4px #e7c77f20;animation:livePulse 2s infinite}
    .ajm-ticker-window{flex:1;min-width:0;overflow:hidden}.ajm-ticker-track{display:flex;align-items:center;width:max-content;animation:bulletin 48s linear infinite}.ajm-ticker-track>span{display:flex;align-items:center;white-space:nowrap;padding:0 22px;border-right:1px solid #ffffff30;font-size:11px;font-weight:600}.ticker-toggle{width:27px;height:27px;flex:0 0 27px;display:grid;place-items:center;border:1px solid #ffffff65;border-radius:50%;background:#ffffff10;color:#fff;font-size:10px}.ticker-toggle:hover{background:var(--gold);color:var(--navy)}@keyframes bulletin{to{transform:translateX(-50%)}}@keyframes livePulse{50%{box-shadow:0 0 0 7px #e7c77f08;opacity:.7}}
    .navbar{padding:12px clamp(14px,3vw,48px);position:sticky;top:0;z-index:1030;border:0!important;border-bottom:1px solid #e6e8e7!important;background:rgba(255,253,248,.92)!important;backdrop-filter:blur(22px) saturate(145%);-webkit-backdrop-filter:blur(22px) saturate(145%);box-shadow:0 8px 28px #0c2c4d0b!important}.navbar>.container-fluid{width:100%;max-width:1700px;margin:auto;padding:0;gap:18px}
    .navbar-brand{display:flex;align-items:center;gap:11px!important;margin:0;color:var(--navy)!important;font-size:clamp(1rem,1.45vw,1.4rem);font-weight:800;letter-spacing:-.5px;white-space:nowrap}.navbar-brand img{width:44px;height:44px;object-fit:contain;padding:3px;border-radius:13px;background:#fff;box-shadow:0 5px 15px #0c2c4d14}.navbar-collapse{flex-grow:0}.navbar-nav{align-items:center;gap:5px}.navbar .btn{margin:0!important;padding:10px 13px;border:1px solid transparent!important;border-radius:11px;font-size:12px;font-weight:800;white-space:nowrap;transition:transform .22s,box-shadow .22s}.navbar .btn-outline-light{background:#f0f5fa;color:#244f75}.navbar .btn-light{background:var(--navy)!important;color:#fff!important;box-shadow:0 7px 16px #0c2c4d1e}.navbar .btn[aria-current=page]{background:#edf6f0!important;color:#36745d!important}.navbar .btn:hover{transform:translateY(-2px);box-shadow:0 10px 22px #0c2c4d18}.navbar-toggler{border:1px solid #dfe5e9!important;border-radius:10px;padding:7px 9px;box-shadow:none!important}
    .page-shell{width:100%;max-width:1120px;margin:0 auto;padding:clamp(28px,5vw,58px) clamp(15px,3vw,30px) 0}.page-heading{display:flex;align-items:flex-end;justify-content:space-between;gap:22px;margin-bottom:26px}.eyebrow{display:inline-flex;align-items:center;gap:8px;margin:0 0 11px;padding:7px 11px;border:1px solid #eadfc5;border-radius:999px;background:#fff9eb;color:#896b35;font-size:10px;font-weight:800;letter-spacing:1.1px;text-transform:uppercase}.eyebrow-dot{width:6px;height:6px;border-radius:50%;background:var(--gold)}.page-heading h1{margin:0;font-size:clamp(2rem,4vw,3.15rem);line-height:1.1;letter-spacing:-.055em}.page-heading h1 span{color:#2c668b}.heading-subtitle{margin:9px 0 0;color:var(--muted);font-size:13px}.summary-pill{display:flex;align-items:center;gap:10px;flex:0 0 auto;padding:12px 15px;border:1px solid #e8e9e5;border-radius:15px;background:#fff;box-shadow:0 7px 20px #0c2c4d08}.summary-pill i{display:grid;place-items:center;width:36px;height:36px;border-radius:11px;background:#fbf1dc;color:#a17a32;font-size:18px}.summary-pill strong{display:block;color:var(--navy);font-size:18px;line-height:1.1}.summary-pill small{display:block;margin-top:3px;color:var(--muted);font-size:10px}
    .class-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:18px}.class-card{overflow:hidden;border:1px solid #e8edf1;border-radius:20px;background:rgba(255,255,255,.88);box-shadow:0 10px 28px #0c2c4d08;transition:transform .22s,box-shadow .22s}.class-card:hover{transform:translateY(-3px);box-shadow:var(--shadow)}.class-card-head{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:17px 20px;border-bottom:1px solid #edf0f2;background:linear-gradient(110deg,#f8fbfd,#fffaf0)}.class-label{display:flex;align-items:center;gap:11px}.class-icon{display:grid;place-items:center;width:39px;height:39px;border-radius:12px;background:#e9f1f7;color:#245b7e;font-size:18px}.class-card h2{margin:0;font-size:16px;font-weight:700;letter-spacing:-.3px}.class-count{padding:5px 9px;border-radius:999px;background:#f0f4f7;color:#6d7d8b;font-size:10px;font-weight:800;white-space:nowrap}.topper-list{list-style:none;padding:7px 18px 12px;margin:0}.topper-row{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:12px 2px;border-bottom:1px solid #edf0f2}.topper-row:last-child{border-bottom:0}.student-name{display:flex;align-items:center;gap:10px;min-width:0;font-size:13px;font-weight:650;color:#29465d;overflow-wrap:anywhere}.student-rank{display:grid;place-items:center;min-width:44px;padding:6px 9px;border:1px solid #e8d8ad;border-radius:9px;background:#fff8e8;color:#906b28;font-size:10px;font-weight:800}.rank-medal{color:#c49a45;font-size:15px}.empty-state{grid-column:1/-1;padding:38px 20px;border:1px dashed #d8e1e8;border-radius:20px;background:#ffffffb8;text-align:center}.empty-state i{display:grid;place-items:center;width:54px;height:54px;margin:0 auto 13px;border-radius:16px;background:#edf3f7;color:#416984;font-size:23px}.empty-state h2{font-size:18px;margin-bottom:7px}.empty-state p{margin:0;color:var(--muted);font-size:12px}
    footer{margin-top:58px!important;padding:32px 16px!important;border-top:3px solid var(--gold);background:linear-gradient(110deg,#092744,#164c70)!important;color:#eaf1f5!important;text-align:center;font-family:Arial,sans-serif}footer .footer-school{font-size:14px;font-weight:600;margin-bottom:6px}footer .footer-contact{font-size:13px;line-height:1.5;margin-bottom:10px}footer a{color:#f1dba6!important;text-decoration:none}footer a:hover{color:#fff!important}footer .footer-divider{height:1px;width:85%;max-width:1100px;background:#ffffff35;margin:12px auto}footer small{color:#c5d4df!important;font-size:12px;display:block;margin-top:5px}
    @media(max-width:1100px){.navbar .btn{padding:9px 10px;font-size:11px}.navbar-nav{gap:4px}}@media(max-width:767.98px){html{scroll-padding-top:78px}.ajm-ticker{height:34px;min-height:34px;gap:8px;padding:3px 8px}.ajm-ticker-label{gap:6px;font-size:8px;letter-spacing:.65px}.ticker-live-dot{width:5px;height:5px}.ajm-ticker-track{animation-duration:34s}.ajm-ticker-track>span{padding:0 13px;font-size:9.5px;line-height:1.2}.ticker-toggle{width:25px;height:25px;flex-basis:25px}.navbar{padding:8px 12px}.navbar>.container-fluid{gap:8px}.navbar-brand{font-size:15px;line-height:1.15;gap:8px!important;white-space:normal;min-width:0}.navbar-brand img{width:36px;height:36px;flex:0 0 36px}.navbar-brand small{font-size:10px!important}.navbar-collapse{padding:10px 0 4px}.navbar-nav{align-items:stretch;gap:5px}.navbar .btn{width:100%;text-align:left;padding:10px 12px;font-size:12px}.page-shell{padding:25px 13px 0}.page-heading{align-items:flex-start;flex-direction:column;gap:15px;margin-bottom:19px}.page-heading h1{font-size:clamp(2rem,9vw,2.7rem)}.heading-subtitle{font-size:12px}.summary-pill{padding:9px 12px}.summary-pill i{width:32px;height:32px}.class-grid{grid-template-columns:1fr;gap:13px}.class-card{border-radius:17px}.class-card-head{padding:14px 15px}.topper-list{padding:5px 15px 9px}.topper-row{padding:11px 1px}.student-name{font-size:12px}.student-rank{min-width:42px}footer{margin-top:38px!important;padding:25px 15px!important}footer .footer-contact{display:flex;flex-wrap:wrap;justify-content:center;column-gap:9px;row-gap:3px;font-size:12px}footer .footer-divider{width:92%}}@media(max-width:390px){.ajm-ticker-label{font-size:7.2px;letter-spacing:.45px;gap:4px}.ajm-ticker-track>span{padding:0 10px;font-size:9px}.navbar-brand{font-size:14px}.class-card-head{padding:13px}.topper-list{padding-inline:13px}}
    @media(prefers-reduced-motion:reduce){html{scroll-behavior:auto}*,*::before,*::after{animation-duration:.01ms!important;animation-iteration-count:1!important;transition-duration:.01ms!important}}
  </style>
</head>
<body>
  <section class="ajm-ticker" aria-label="School announcements">
    <div class="ajm-ticker-label"><span class="ticker-live-dot"></span> SCHOOL UPDATES</div>
    <div class="ajm-ticker-window"><div class="ajm-ticker-track" id="ajmTickerTrack">
      <span>Admissions information — contact the school office for details</span><span>Celebrating student achievement and academic progress</span><span>Smart classrooms and activity-based learning</span><span>Check the website for exam dates and result updates</span>
    </div></div>
    <button class="ticker-toggle" id="ajmTickerToggle" type="button" aria-pressed="false" aria-label="Pause announcement ticker" title="Pause or resume announcements">Ⅱ</button>
  </section>
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php"><img src="unnamed-fotor-bg-remover-20250627142251.png" alt="AJM School logo"><span>AJM English School<small style="display:block;font:500 10px Inter,Arial,sans-serif;letter-spacing:.2px;color:#738392;margin-top:1px">Gossaigaon, Assam</small></span></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav"><div class="navbar-nav">
        <a class="btn btn-outline-light" href="index.php">Home</a><a class="btn btn-outline-light" href="index.php#about">About</a><a class="btn btn-outline-light" href="exam-dates.php">Exam Dates</a><a class="btn btn-outline-light" href="results.php" aria-current="page">Results</a><a class="btn btn-outline-light" href="fees.php">Pay Fees</a><a class="btn btn-outline-light" href="gallery.php">Gallery</a><a class="btn btn-outline-light" href="index.php#location">Contact</a><a class="btn btn-light" href="login.php">Admin</a>
      </div></div>
    </div>
  </nav>
  <main class="page-shell">
    <header class="page-heading">
      <div><div class="eyebrow"><span class="eyebrow-dot"></span> Student achievement</div><h1>Class-wise <span>toppers.</span></h1><p class="heading-subtitle">Celebrating the students who have earned a place among the top ranks.</p></div>
      <div class="summary-pill"><i class="bi bi-trophy-fill" aria-hidden="true"></i><div><strong><?= (int)$totalToppers ?></strong><small><?= $totalToppers === 1 ? 'listed topper' : 'listed toppers' ?></small></div></div>
    </header>
    <section class="class-grid" aria-label="Class-wise toppers">
      <?php if (!$classesWithToppers): ?>
        <div class="empty-state"><i class="bi bi-journal-text" aria-hidden="true"></i><h2>Results will appear here</h2><p>Class-wise topper details are not available right now. Please check again later.</p></div>
      <?php else: foreach ($classesWithToppers as $class => $students): ?>
        <article class="class-card">
          <div class="class-card-head"><div class="class-label"><span class="class-icon"><i class="bi bi-mortarboard-fill" aria-hidden="true"></i></span><h2>Class <?= (int)$class ?></h2></div><span class="class-count"><?= count($students) ?> <?= count($students) === 1 ? 'topper' : 'toppers' ?></span></div>
          <ul class="topper-list">
            <?php foreach ($students as $student): ?>
              <li class="topper-row"><span class="student-name"><i class="bi bi-award-fill rank-medal" aria-hidden="true"></i><?= htmlspecialchars($student['name'], ENT_QUOTES, 'UTF-8') ?></span><span class="student-rank"><?= htmlspecialchars($student['rank'], ENT_QUOTES, 'UTF-8') ?></span></li>
            <?php endforeach; ?>
          </ul>
        </article>
      <?php endforeach; endif; ?>
    </section>
  </main>
  <footer>
    <div class="footer-school">AJM English School, Gossaigaon, Assam</div>
    <div class="footer-contact"><span>Email: <a href="mailto:ajmschool@gmail.com">ajmschool@gmail.com</a></span><span aria-hidden="true"> | </span><span>Phone: <a href="tel:+919876543210">+91 98765 43210</a></span></div>
    <div class="footer-divider"></div><small>© 2026 AJM English School. All rights reserved.</small>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    (()=>{const track=document.getElementById('ajmTickerTrack');const toggle=document.getElementById('ajmTickerToggle');if(!track||!toggle)return;Array.from(track.children).forEach(item=>{const clone=item.cloneNode(true);clone.setAttribute('aria-hidden','true');track.appendChild(clone)});toggle.addEventListener('click',()=>{const paused=toggle.getAttribute('aria-pressed')!=='true';toggle.setAttribute('aria-pressed',String(paused));track.style.animationPlayState=paused?'paused':'running';toggle.textContent=paused?'▶':'Ⅱ';toggle.setAttribute('aria-label',paused?'Resume announcement ticker':'Pause announcement ticker')})})();
  </script>
</body>
</html>
