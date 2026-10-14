<?php
/* AJM English School — Exam Dates. Uses the landing page's shared header/footer design. */

$selectedClass = null;
if (isset($_GET['class']) && is_scalar($_GET['class'])) {
    $candidate = filter_var($_GET['class'], FILTER_VALIDATE_INT);
    if ($candidate !== false && $candidate >= 1 && $candidate <= 10) {
        $selectedClass = $candidate;
    }
}

$examRows = [];
$scheduleError = '';
if ($selectedClass !== null) {
    $filePath = __DIR__ . '/exam_data/class' . $selectedClass . '_exams.csv';
    if (!is_file($filePath) || !is_readable($filePath)) {
        $scheduleError = 'No exam schedule has been uploaded for Class ' . $selectedClass . ' yet.';
    } else {
        $handle = fopen($filePath, 'r');
        if ($handle === false) {
            $scheduleError = 'The exam schedule could not be opened. Please try again later.';
        } else {
            while (($row = fgetcsv($handle, 0, ',', '"', '\\')) !== false) {
                if (count($row) === 1 && trim((string)$row[0]) === '') continue;
                $row = array_map(static function ($cell) {
                    return trim((string)$cell);
                }, $row);
                // Remove a UTF-8 BOM if the CSV was saved by spreadsheet software.
                if (isset($row[0])) $row[0] = preg_replace('/^\xEF\xBB\xBF/', '', $row[0]);
                $examRows[] = $row;
            }
            fclose($handle);
            if (!$examRows) {
                $scheduleError = 'The schedule file for Class ' . $selectedClass . ' is currently empty.';
            }
        }
    }
}

function e($value): string {
    return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#0c2c4d">
  <title>Exam Dates | AJM English School, Gossaigaon</title>
  <meta name="description" content="View class-wise exam schedules from AJM English School, Gossaigaon. Choose a class to see its uploaded exam timetable.">
  <link rel="icon" type="image/png" href="unnamed-fotor-bg-remover-20250627142251.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Poppins:wght@600&display=swap" rel="stylesheet">
  <style>
    :root{--navy:#0c2c4d;--blue:#164b7a;--blue2:#2d6c9d;--gold:#c9a45c;--gold-pale:#f7efde;--ink:#19334d;--muted:#6e7f90;--ivory:#fffdf8;--line:#e8e5dc;--mint:#eaf5ef;--sky:#edf5fb;--rose:#fff0ee;--lilac:#f3f0fb;--shadow:0 16px 42px rgba(12,44,77,.09);--shadow-hover:0 24px 54px rgba(12,44,77,.15)}
    *{box-sizing:border-box}
    html{scroll-behavior:smooth;scroll-padding-top:95px}
    body{margin:0;overflow-x:hidden;background:linear-gradient(180deg,#fffdf8 0%,#f8fafb 52%,#fffdf8 100%);color:var(--ink);font-family:Inter,Arial,sans-serif;font-size:15px;line-height:1.65}
    img{max-width:100%}
    a{transition:color .2s ease}
    h1,h2,h3,h4,h5,h6{color:var(--navy);font-family:Georgia,'Times New Roman',serif}
    button,a,select{-webkit-tap-highlight-color:transparent}
    a:focus-visible,button:focus-visible,select:focus-visible{outline:3px solid var(--gold)!important;outline-offset:3px}

    /* Shared landing-page ticker: keep this identical across public pages. */
    .ajm-ticker{height:38px;min-height:38px;width:100%;display:flex;align-items:center;gap:14px;padding:4px clamp(12px,2.5vw,42px);position:relative;z-index:1040;color:#fff;background:linear-gradient(100deg,#092744,#124a78 62%,#1e608a);box-shadow:0 4px 15px #09274422}
    .ajm-ticker-label{display:flex;align-items:center;gap:8px;white-space:nowrap;flex:0 0 auto;color:#f2dca9;font-size:9px;font-weight:800;letter-spacing:1.2px}
    .ticker-live-dot{width:6px;height:6px;flex:0 0 6px;border-radius:50%;background:#e7c77f;box-shadow:0 0 0 4px #e7c77f20;animation:livePulse 2s infinite}
    .ajm-ticker-window{flex:1;min-width:0;overflow:hidden}
    .ajm-ticker-track{display:flex;align-items:center;width:max-content;animation:bulletin 48s linear infinite}
    .ajm-ticker-track span{display:flex;align-items:center;gap:9px;white-space:nowrap;padding:0 22px;border-right:1px solid #ffffff30;font-size:11px;font-weight:600}
    .ticker-toggle{width:27px;height:27px;flex:0 0 27px;display:grid;place-items:center;border:1px solid #ffffff65;border-radius:50%;background:#ffffff10;color:#fff;font-size:10px;transition:all .2s}
    .ticker-toggle:hover{background:var(--gold);color:var(--navy);transform:scale(1.06)}
    .ajm-ticker:hover .ajm-ticker-track,.ajm-ticker:focus-within .ajm-ticker-track,.ajm-ticker-track.is-paused{animation-play-state:paused}
    @keyframes bulletin{to{transform:translateX(-50%)}}
    @keyframes livePulse{50%{box-shadow:0 0 0 7px #e7c77f08;opacity:.7}}
    .ui-icon{display:inline-flex;align-items:center;justify-content:center;vertical-align:-.2em;margin-right:6px;color:#527b8b}
    .ui-icon svg{width:1.1em;height:1.1em;stroke:currentColor;fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round}

    /* Exact shared homepage navbar treatment and link order. */
    .navbar{width:100%;max-width:none;margin:0;padding:12px clamp(14px,3vw,48px);position:sticky;top:0;z-index:1030;border:0!important;border-bottom:1px solid #e6e8e7!important;border-radius:0;background:#fffdf8f2!important;backdrop-filter:blur(18px);-webkit-backdrop-filter:blur(18px);box-shadow:0 8px 28px #0c2c4d0b!important}
    .navbar>.container-fluid{width:100%;max-width:1700px;margin:auto;padding:0;gap:18px}
    .navbar-brand{display:flex;align-items:center;gap:11px!important;margin:0;color:var(--navy)!important;font-size:clamp(1rem,1.45vw,1.4rem);font-weight:800;letter-spacing:-.5px;white-space:nowrap;line-height:1.2}
    .navbar-brand img{width:44px;height:44px;object-fit:contain;padding:3px;border-radius:13px!important;background:#fff;box-shadow:0 5px 15px #0c2c4d14}
    .navbar-brand small{display:block;font:500 10px Inter,Arial,sans-serif;letter-spacing:.2px;color:#738392;margin-top:1px}
    .navbar-collapse{flex-grow:0}
    .navbar-nav{align-items:center;gap:5px}
    .navbar .btn{margin:0!important;padding:10px 13px;border:1px solid transparent!important;border-radius:11px;font-size:12px;font-weight:800;white-space:nowrap;transition:transform .22s,box-shadow .22s,background .22s}
    .navbar .btn-outline-light{background:#f0f5fa;color:#244f75}
    .navbar .btn-outline-light:nth-child(2){background:#edf6f0;color:#36745d}
    .navbar .btn-outline-light:nth-child(3){background:#fbf2e4;color:#946d2e}
    .navbar .btn-outline-light:nth-child(4){background:#f4effb;color:#6a55a0}
    .navbar .btn-light{background:var(--navy)!important;color:#fff!important;box-shadow:0 7px 16px #0c2c4d1e}
    .navbar .btn:hover{transform:translateY(-2px);box-shadow:0 10px 22px #0c2c4d18}
    .navbar-toggler{border:1px solid #dfe5e9!important;border-radius:10px;padding:7px 9px;box-shadow:none!important}

    /* Exam page components use the homepage's navy/gold palette and spacing rhythm. */
    .page-shell{width:100%;max-width:1580px;margin:0 auto;padding:clamp(22px,3vw,40px) clamp(18px,3.5vw,58px) 0}
    .exam-hero{position:relative;isolation:isolate;display:grid;grid-template-columns:minmax(0,1.15fr) minmax(320px,.85fr);gap:clamp(22px,3.5vw,48px);align-items:center;overflow:hidden;padding:clamp(26px,4vw,54px);border:1px solid rgba(255,255,255,.9);border-radius:27px;background:linear-gradient(120deg,rgba(255,253,248,.97),rgba(237,245,251,.94));box-shadow:var(--shadow)}
    .exam-hero:before,.exam-hero:after{content:"";position:absolute;z-index:-1;pointer-events:none;border-radius:50%}
    .exam-hero:before{width:360px;height:360px;right:-100px;top:-210px;background:radial-gradient(circle,rgba(202,224,240,.9),transparent 70%)}
    .exam-hero:after{width:300px;height:300px;left:35%;bottom:-240px;background:radial-gradient(circle,rgba(244,226,187,.65),transparent 70%)}
    .exam-intro{min-width:0}
    .eyebrow{display:flex;align-items:center;gap:9px;margin:0 0 13px;color:#607b8d;font-size:9px;font-weight:800;letter-spacing:1.7px;text-transform:uppercase}
    .eyebrow:before{content:"";width:23px;height:2px;flex:0 0 23px;background:var(--gold)}
    .exam-intro h1{max-width:700px;margin:0 0 15px;font-size:clamp(2.45rem,4.3vw,4.4rem);line-height:.99;letter-spacing:-2px;font-weight:700}
    .exam-intro h1 span{color:#2c668b}
    .exam-intro>p{max-width:620px;margin:0;color:#5c7183;font-size:clamp(13px,1.08vw,15px);line-height:1.8}
    .hero-pills{display:flex;flex-wrap:wrap;gap:8px;margin-top:22px}
    .hero-pill{display:inline-flex;align-items:center;gap:7px;padding:8px 11px;border:1px solid rgba(12,44,77,.09);border-radius:999px;background:rgba(255,255,255,.72);color:#3f627d;font-size:10px;font-weight:700}
    .hero-pill span{color:#a77b34}
    .selector-card{position:relative;min-width:0;padding:clamp(18px,2.2vw,26px);border:1px solid rgba(255,255,255,.98);border-radius:22px;background:rgba(255,255,255,.86);box-shadow:0 15px 40px rgba(12,44,77,.09);backdrop-filter:blur(18px);-webkit-backdrop-filter:blur(18px)}
    .selector-top{display:flex;align-items:center;gap:12px;margin-bottom:18px}
    .selector-icon{display:grid;place-items:center;width:44px;height:44px;flex:0 0 44px;border-radius:14px;background:#edf5fb;color:#286b9e}
    .selector-icon svg{width:22px;height:22px;fill:none;stroke:currentColor;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round}
    .selector-top h2{margin:0 0 3px;font-family:Inter,Arial,sans-serif;font-size:16px;font-weight:800;letter-spacing:-.35px}
    .selector-top p{margin:0;color:var(--muted);font-size:11px;line-height:1.45}
    .selector-card label{display:block;margin:0 0 8px;color:#38556f;font-size:11px;font-weight:800}
    .class-select{width:100%;min-height:49px;padding:11px 42px 11px 14px;border:1px solid #dce5eb;border-radius:13px;background-color:#fff;color:var(--navy);font:600 13px Inter,Arial,sans-serif;box-shadow:0 3px 10px rgba(12,44,77,.03)}
    .class-select:focus{border-color:#8cb6d2;box-shadow:0 0 0 4px rgba(45,108,157,.12)}
    .selector-hint{display:flex;align-items:flex-start;gap:8px;margin-top:12px;color:#718395;font-size:10px;line-height:1.5}
    .selector-hint .hint-icon{color:#ba9147;font-weight:800;flex:0 0 auto}

    .schedule-section{margin-top:clamp(28px,3vw,40px)}
    .section-heading{display:flex;align-items:flex-end;justify-content:space-between;gap:18px;margin:0 0 16px}
    .section-heading .eyebrow{margin-bottom:7px}
    .section-heading h2{margin:0;font-size:clamp(1.45rem,2.3vw,2rem);font-weight:700;letter-spacing:-.8px}
    .section-heading p{margin:6px 0 0;color:var(--muted);font-size:12px}
    .class-tag{flex:0 0 auto;display:inline-flex;align-items:center;gap:7px;padding:8px 12px;border:1px solid #e3e9ec;border-radius:999px;background:rgba(255,255,255,.78);color:#42647d;font-size:10px;font-weight:800}
    .tag-dot{width:6px;height:6px;border-radius:50%;background:#48a582}
    .schedule-card{overflow:hidden;border:1px solid rgba(220,228,233,.95);border-radius:21px;background:rgba(255,255,255,.9);box-shadow:var(--shadow)}
    .schedule-card-head{display:flex;align-items:center;gap:12px;padding:18px 22px;border-bottom:1px solid #e9eef0;background:linear-gradient(100deg,rgba(237,245,251,.9),rgba(255,253,248,.88))}
    .schedule-icon{display:grid;place-items:center;width:40px;height:40px;flex:0 0 40px;border-radius:12px;background:#d9ebfb;color:#286b9e}
    .schedule-icon svg{width:20px;height:20px;fill:none;stroke:currentColor;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round}
    .schedule-card-head h3{margin:0;font-family:Inter,Arial,sans-serif;font-size:15px;font-weight:800}
    .schedule-card-head p{margin:3px 0 0;color:var(--muted);font-size:10px;line-height:1.45}
    .schedule-body{padding:0}
    .table-responsive{max-width:100%;margin:0;overflow-x:auto;-webkit-overflow-scrolling:touch}
    .schedule-table{width:100%;min-width:580px;margin:0!important;border-collapse:separate;border-spacing:0;color:var(--ink);font-size:12px}
    .schedule-table>:not(caption)>*>*{padding:14px 18px;border-bottom:1px solid #e9eef1;border-right:1px solid #eef1f3;vertical-align:middle}
    .schedule-table>:not(caption)>*>*:last-child{border-right:0}
    .schedule-table thead th{background:#f0f6fa;color:#264e6c;font-size:10px;font-weight:800;letter-spacing:.45px;text-transform:uppercase;white-space:nowrap}
    .schedule-table tbody tr:nth-child(even) td{background:rgba(246,249,251,.78)}
    .schedule-table tbody tr:hover td{background:#f6f9fc}
    .schedule-table tbody tr:last-child td{border-bottom:0}
    .schedule-table td{min-width:120px;overflow-wrap:anywhere}
    .schedule-table td:first-child{color:#264e6c;font-weight:700}
    .table-hint{display:none;padding:9px 14px;border-top:1px solid #e9eef1;background:#fbfcfd;color:#718395;font-size:10px}
    .state-panel{display:flex;align-items:flex-start;gap:14px;margin:20px;padding:20px;border:1px dashed #d8e4eb;border-radius:17px;background:linear-gradient(115deg,#f5f9fc,#fffdf8)}
    .state-icon{display:grid;place-items:center;width:43px;height:43px;flex:0 0 43px;border-radius:13px;background:#e4f0f9;color:#2d6c9d;font-size:20px;font-weight:800}
    .state-panel h3{margin:0 0 4px;font-family:Inter,Arial,sans-serif;font-size:14px;font-weight:800}
    .state-panel p{margin:0;color:#6d8192;font-size:12px;line-height:1.65}
    .state-panel.error{border-color:#f0d8d5;background:#fff8f6}
    .state-panel.error .state-icon{background:#fbe7e3;color:#a34b43}

    .values-section{margin-top:clamp(36px,4vw,52px)}
    .values-heading{max-width:700px;margin:0 auto 22px;text-align:center}
    .values-heading .eyebrow{justify-content:center}
    .values-heading h2{margin:0 0 8px;font-size:clamp(1.5rem,2.2vw,2.1rem);letter-spacing:-.8px}
    .values-heading p{margin:0;color:var(--muted);font-size:12px;line-height:1.7}
    .value-card{height:100%;padding:22px;border:1px solid #e5eaec;border-radius:19px;background:rgba(255,255,255,.86);box-shadow:0 8px 26px rgba(12,44,77,.045);transition:transform .22s,box-shadow .22s,border-color .22s}
    .value-card:hover{transform:translateY(-4px);border-color:#d5e1e7;box-shadow:0 16px 34px rgba(12,44,77,.09)}
    .value-icon{display:grid;place-items:center;width:42px;height:42px;margin-bottom:13px;border-radius:14px;background:var(--gold-pale);color:#9a7332;font-size:18px}
    .value-card:nth-child(2) .value-icon{background:var(--mint);color:#23835f}
    .value-card:nth-child(3) .value-icon{background:var(--sky);color:#286b9e}
    .value-card h3{margin:0 0 7px;font-family:Inter,Arial,sans-serif;font-size:14px;font-weight:800}
    .value-card p{margin:0;color:var(--muted);font-size:12px;line-height:1.7}

    /* Match the footer as it actually renders on the landing page. */
    footer{margin-top:65px!important;padding:32px 16px!important;border-top:3px solid var(--gold);background:linear-gradient(110deg,#092744,#164c70)!important;color:#eaf1f5!important;text-align:center}
    footer a{color:#f1dba6!important}
    footer small{color:#c5d4df!important}

    @media(max-width:1100px){
      .navbar .btn{padding:9px 10px;font-size:11px}.navbar-nav{gap:4px}
      .exam-hero{grid-template-columns:minmax(0,1fr) minmax(290px,.82fr);gap:24px;padding:30px}
      .exam-intro h1{font-size:clamp(2.45rem,5vw,3.8rem)}
      .selector-card{padding:20px}
    }
    @media(max-width:767.98px){
      html{scroll-padding-top:82px}
      body{font-size:14px}
      .ajm-ticker{height:34px;min-height:34px;padding:3px 8px;gap:7px}
      .ajm-ticker-label{font-size:8px;letter-spacing:.5px;gap:6px}
      .ticker-live-dot{width:5px;height:5px;flex-basis:5px}
      .ajm-ticker-track span{font-size:10px;padding:0 13px;gap:7px}
      .ticker-toggle{width:25px;height:25px;flex-basis:25px}
      .navbar{width:100%;padding:9px 13px}
      .navbar>.container-fluid{gap:8px}
      .navbar-brand{font-size:.98rem;white-space:normal;min-width:0;line-height:1.15;gap:8px!important}
      .navbar-brand img{width:36px;height:36px;flex:0 0 36px}
      .navbar-brand small{font-size:10px}
      .navbar-collapse{padding:12px 0 4px}
      .navbar-nav{align-items:stretch;gap:5px}
      .navbar .btn{width:100%;text-align:left;padding:11px 14px;font-size:13px}
      .page-shell{padding:18px 13px 0}
      .exam-hero{grid-template-columns:minmax(0,1fr);gap:20px;padding:23px 18px;border-radius:21px}
      .exam-intro h1{font-size:clamp(2.25rem,9.2vw,3.1rem);line-height:.98;letter-spacing:-1.3px;margin-bottom:11px}
      .exam-intro>p{font-size:13px;line-height:1.65}
      .eyebrow{font-size:8px;letter-spacing:1.2px;margin-bottom:10px}
      .eyebrow:before{width:19px;flex-basis:19px}
      .hero-pills{gap:6px;margin-top:15px}
      .hero-pill{padding:7px 9px;font-size:9px}
      .selector-card{padding:18px;border-radius:18px}
      .selector-top{gap:10px;margin-bottom:15px}
      .selector-icon{width:39px;height:39px;flex-basis:39px;border-radius:12px}
      .selector-top h2{font-size:15px}
      .selector-top p{font-size:10px}
      .class-select{min-height:48px;font-size:14px}
      .selector-hint{font-size:10px}
      .schedule-section{margin-top:27px}
      .section-heading{align-items:flex-start;flex-direction:column;gap:10px;margin-bottom:13px}
      .section-heading h2{font-size:1.45rem;line-height:1.2}
      .section-heading p{font-size:11px}
      .class-tag{padding:7px 10px;font-size:9px}
      .schedule-card{border-radius:17px}
      .schedule-card-head{gap:10px;padding:14px}
      .schedule-icon{width:36px;height:36px;flex-basis:36px}
      .schedule-card-head h3{font-size:13px}
      .schedule-card-head p{font-size:9px}
      .schedule-table{min-width:540px;font-size:11px}
      .schedule-table>:not(caption)>*>*{padding:12px 13px}
      .schedule-table thead th{font-size:9px}
      .table-hint{display:block}
      .state-panel{gap:10px;margin:12px;padding:14px;border-radius:14px}
      .state-icon{width:36px;height:36px;flex-basis:36px;border-radius:11px}
      .state-panel h3{font-size:13px}
      .state-panel p{font-size:11px}
      .values-section{margin-top:34px}
      .values-heading{margin-bottom:17px;text-align:left}
      .values-heading .eyebrow{justify-content:flex-start}
      .values-heading h2{font-size:1.55rem;line-height:1.15}
      .values-heading p{font-size:11px}
      .value-card{padding:17px;border-radius:16px}
      .value-icon{width:38px;height:38px;margin-bottom:10px}
      .value-card h3{font-size:13px}
      .value-card p{font-size:11px}
      footer{margin-top:42px!important;padding:26px 15px!important}
    }
    @media(max-width:380px){
      .ajm-ticker-label{max-width:75px;white-space:normal;line-height:1.2}
      .navbar-brand{font-size:.86rem}
      .exam-hero{padding:20px 14px;gap:17px}
      .exam-intro h1{font-size:2.18rem}
      .hero-pills{display:grid;grid-template-columns:1fr 1fr}
      .hero-pill:last-child{grid-column:1/-1;justify-content:center}
      .selector-card{padding:15px}
      .section-heading h2{font-size:1.35rem}
    }
    @media(prefers-reduced-motion:reduce){
      *,*::before,*::after{scroll-behavior:auto!important;animation-duration:.01ms!important;animation-iteration-count:1!important;transition-duration:.01ms!important}
    }
  </style>
</head>
<body>
<section class="ajm-ticker" aria-label="School announcements">
  <div class="ajm-ticker-label"><span class="ticker-live-dot"></span> SCHOOL UPDATES</div>
  <div class="ajm-ticker-window"><div class="ajm-ticker-track" id="ajmTickerTrack">
    <span><span class="ui-icon"><svg viewBox="0 0 24 24"><path d="m3 11 18-5-5 17-4-7-9-5Z"/><path d="m12 16 4-5"/></svg></span>Admissions for 2025–26 — contact the school office for details</span>
    <span><span class="ui-icon"><svg viewBox="0 0 24 24"><path d="M8 21h8M12 17v4M7 4h10v5a5 5 0 0 1-10 0V4Z"/><path d="M7 6H4v2a4 4 0 0 0 4 4M17 6h3v2a4 4 0 0 1-4 4"/></svg></span>Congratulations to our Class 10 batch for the reported 100% board results</span>
    <span><span class="ui-icon"><svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="13" rx="2"/><path d="M8 21h8M12 17v4M7 9h10M7 12h6"/></svg></span>Smart classrooms and activity-based learning</span>
    <span><span class="ui-icon"><svg viewBox="0 0 24 24"><path d="M3 10 12 3l9 7v10H3Z"/><path d="M9 20v-6h6v6"/></svg></span>Annual Day, Sports Meet and Cultural Fest highlights</span>
    <span><span class="ui-icon"><svg viewBox="0 0 24 24"><rect x="4" y="3" width="16" height="18" rx="2"/><path d="M8 7h8M8 11h8M8 15h5"/></svg></span>Check the website for exam dates and result updates</span>
  </div></div>
  <button class="ticker-toggle" id="ajmTickerToggle" type="button" aria-pressed="false" aria-label="Pause announcement ticker" title="Pause or resume announcements">Ⅱ</button>
</section>
<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php"><img src="unnamed-fotor-bg-remover-20250627142251.png" alt="AJM School logo"><span>AJM English School<small style="display:block;font:500 10px Inter,Arial,sans-serif;letter-spacing:.2px;color:#738392;margin-top:1px">Gossaigaon, Assam</small></span></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav"><div class="navbar-nav">
      <a class="btn btn-outline-light" href="index.php">Home</a><a class="btn btn-outline-light" href="index.php#about">About</a><a class="btn btn-outline-light" href="exam-dates.php" aria-current="page">Exam Dates</a><a class="btn btn-outline-light" href="results.php">Results</a><a class="btn btn-outline-light" href="fees.php">Pay Fees</a><a class="btn btn-outline-light" href="gallery.php">Gallery</a><a class="btn btn-outline-light" href="index.php#location">Contact</a><a class="btn btn-light" href="login.php">Admin</a>
    </div></div>
  </div>
</nav>
<main>
  <div class="page-shell">
    <section class="exam-hero" aria-labelledby="page-title">
      

      <div class="selector-card">
        <div class="selector-top">
          <div class="selector-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="16" rx="2"></rect><path d="M16 3v4M8 3v4M3 10h18M8 14h2M14 14h2M8 17h2"></path></svg>
          </div>
          <div><h2>Find your timetable</h2><p>Choose a class to load its schedule</p></div>
        </div>
        <form method="GET" action="exam-dates.php" id="classForm">
          <label for="class">Select your class</label>
          <select name="class" id="class" class="form-select class-select" onchange="this.form.submit()">
            <option value="" disabled <?= $selectedClass === null ? 'selected' : '' ?>>Choose a class</option>
            <?php for ($i = 1; $i <= 10; $i++): ?>
              <option value="<?= $i ?>" <?= $selectedClass === $i ? 'selected' : '' ?>>Class <?= $i ?></option>
            <?php endfor; ?>
          </select>
        </form>
        <div class="selector-hint"><span class="hint-icon" aria-hidden="true">ⓘ</span><span>The timetable appears below when a schedule is available for your selected class.</span></div>
      </div>
    </section>

    <section class="schedule-section" id="schedule" aria-labelledby="schedule-title">
      <div class="section-heading">
        <div>
          <div class="eyebrow">Academic calendar</div>
          <h2 id="schedule-title"><?= $selectedClass !== null ? 'Class ' . $selectedClass . ' examination schedule' : 'Upcoming exam schedule' ?></h2>
          <p><?= $selectedClass !== null ? 'Review the details below and check each date carefully.' : 'Choose your class above to see the timetable.' ?></p>
        </div>
        <?php if ($selectedClass !== null): ?>
          <span class="class-tag"><span class="tag-dot" aria-hidden="true"></span> Class <?= $selectedClass ?> selected</span>
        <?php endif; ?>
      </div>

      <div class="schedule-card">
        <div class="schedule-card-head">
          <div class="schedule-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M5 3h11l3 3v15H5z"></path><path d="M16 3v4h4M8 12h8M8 16h8M8 8h4"></path></svg></div>
          <div>
            <h3><?= $selectedClass !== null ? 'Official class timetable' : 'Your class timetable' ?></h3>
            <p>Schedule data shown directly from the school timetable file</p>
          </div>
        </div>
        <div class="schedule-body">
          <?php if ($selectedClass === null): ?>
            <div class="state-panel">
              <div class="state-icon" aria-hidden="true">☷</div>
              <div><h3>Select a class to get started</h3><p>Use the class selector above. If a timetable has been uploaded for that class, it will appear here in a readable table.</p></div>
            </div>
          <?php elseif ($scheduleError !== ''): ?>
            <div class="state-panel error">
              <div class="state-icon" aria-hidden="true">!</div>
              <div><h3>Schedule not available</h3><p><?= e($scheduleError) ?> Please check again later or contact the school office.</p></div>
            </div>
          <?php elseif (count($examRows) === 1): ?>
            <div class="state-panel">
              <div class="state-icon" aria-hidden="true">☷</div>
              <div><h3>Timetable is being prepared</h3><p>A schedule file exists for Class <?= $selectedClass ?>, but it contains column headings only. Please check again later.</p></div>
            </div>
          <?php else: ?>
            <div class="table-responsive" role="region" aria-label="Scrollable class timetable" tabindex="0">
              <table class="table schedule-table align-middle">
                <caption class="visually-hidden">Exam dates and details for Class <?= $selectedClass ?></caption>
                <thead><tr><?php foreach ($examRows[0] as $cell): ?><th scope="col"><?= e($cell) ?></th><?php endforeach; ?></tr></thead>
                <tbody>
                  <?php for ($rowIndex = 1, $rowCount = count($examRows); $rowIndex < $rowCount; $rowIndex++): ?>
                    <tr><?php foreach ($examRows[$rowIndex] as $cell): ?><td><?= e($cell) ?></td><?php endforeach; ?></tr>
                  <?php endfor; ?>
                </tbody>
              </table>
            </div>
            <div class="table-hint">On mobile, swipe horizontally to see all timetable columns.</div>
          <?php endif; ?>
        </div>
      </div>
    </section>

    <section class="values-section" aria-labelledby="values-title">
      <div class="values-heading">
        <div class="eyebrow">Learning with purpose</div>
        <h2 id="values-title">A little preparation goes a long way.</h2>
        <p>Use the schedule to organise revision, stay informed, and arrive ready for each exam.</p>
      </div>
      <div class="row g-3">
        <div class="col-md-4"><article class="value-card"><div class="value-icon" aria-hidden="true">◷</div><h3>Plan your revision</h3><p>Check each exam date and give yourself enough time to revise every subject.</p></article></div>
        <div class="col-md-4"><article class="value-card"><div class="value-icon" aria-hidden="true">✓</div><h3>Check updates</h3><p>Revisit the school website for timetable updates and any new notices.</p></article></div>
        <div class="col-md-4"><article class="value-card"><div class="value-icon" aria-hidden="true">✉</div><h3>Need help?</h3><p>Contact the school office if your class schedule is missing or you need clarification.</p></article></div>
      </div>
    </section>
  </div>
</main>

<footer style="
  background:#111; 
  color:#ccc; 
  padding:22px 12px; 
  margin-top:40px; 
  text-align:center; 
  font-family:Arial, sans-serif;
">

  <div style="font-size:14px; font-weight:600; margin-bottom:6px;">
    AJM English School, Gossaigaon, Assam
  </div>

  <div style="font-size:13px; line-height:1.5; margin-bottom:10px;">
    Email: 
    <a href="mailto:ajmschool@gmail.com" style="color:#bbb; text-decoration:none;">ajmschool@gmail.com</a> 
    | 
    Phone: 
    <a href="tel:+919876543210" style="color:#bbb; text-decoration:none;">+91 98765 43210</a>
  </div>

  <div style="height:1px; width:85%; background:#333; margin:12px auto;"></div>

  <small style="color:#777; font-size:12px; display:block; margin-top:5px;">
    © 2026 AJM English School. All rights reserved.
  </small>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
(() => {
  const ticker = document.querySelector('.ajm-ticker');
  const track = document.getElementById('ajmTickerTrack');
  const toggle = document.getElementById('ajmTickerToggle');
  if (!ticker || !track || !toggle) return;

  if (!track.dataset.loopReady) {
    Array.from(track.children).forEach(item => {
      const clone = item.cloneNode(true);
      clone.setAttribute('aria-hidden', 'true');
      clone.querySelectorAll('svg').forEach(svg => svg.setAttribute('aria-hidden', 'true'));
      track.appendChild(clone);
    });
    track.dataset.loopReady = 'true';
  }

  const isPausedByButton = () => toggle.getAttribute('aria-pressed') === 'true';
  ticker.addEventListener('mouseenter', () => { track.style.animationPlayState = 'paused'; });
  ticker.addEventListener('mouseleave', () => { if (!isPausedByButton()) track.style.animationPlayState = ''; });
  ticker.addEventListener('focusin', () => { track.style.animationPlayState = 'paused'; });
  ticker.addEventListener('focusout', () => { if (!isPausedByButton()) track.style.animationPlayState = ''; });
  toggle.addEventListener('click', () => {
    const paused = isPausedByButton();
    toggle.setAttribute('aria-pressed', String(!paused));
    track.classList.toggle('is-paused', !paused);
    track.style.animationPlayState = paused ? '' : 'paused';
    toggle.textContent = paused ? 'Ⅱ' : '▶';
    toggle.setAttribute('aria-label', paused ? 'Pause announcement ticker' : 'Resume announcement ticker');
  });
})();
</script>
</body>
</html>
