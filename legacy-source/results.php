<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Results | AJM English School</title>
  <meta name="description" content="Access AJM English School student marksheets and public class-wise topper lists.">
  <link rel="icon" type="image/png" href="unnamed-fotor-bg-remover-20250627142251.png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --navy: #0c2c4d;
      --blue: #164b7a;
      --blue-2: #2d6c9d;
      --gold: #c9a45c;
      --gold-pale: #f7efde;
      --ink: #19334d;
      --muted: #6e7f90;
      --ivory: #fffdf8;
      --line: #e8e5dc;
      --shadow: 0 16px 42px rgba(12, 44, 77, .09);
      --shadow-hover: 0 22px 48px rgba(12, 44, 77, .14);
      --glass: rgba(255, 255, 255, .86);
    }
    *, *::before, *::after { box-sizing: border-box; }
    html { scroll-behavior: smooth; scroll-padding-top: 95px; }
    body {
      margin: 0; min-height: 100vh; overflow-x: hidden;
      background: linear-gradient(180deg, #fffdf8 0%, #f6f9fc 50%, #fffdf8 100%);
      color: var(--ink); font: 15px/1.65 Inter, Arial, sans-serif;
    }
    img { max-width: 100%; }
    a { transition: color .2s ease; }
    h1, h2, h3, h4, h5, h6 { color: var(--navy); font-family: Georgia, 'Times New Roman', serif; }
    button, a { -webkit-tap-highlight-color: transparent; }
    a:focus-visible, button:focus-visible, select:focus-visible { outline: 3px solid var(--gold) !important; outline-offset: 3px; }

    /* Shared homepage announcement ticker — keep this identical across public pages. */
    .ajm-ticker {
      height: 38px; min-height: 38px; width: 100%; display: flex; align-items: center; gap: 14px;
      padding: 4px clamp(12px, 2.5vw, 42px); position: relative; z-index: 1040; color: #fff;
      background: linear-gradient(100deg, #092744, #124a78 62%, #1e608a); box-shadow: 0 4px 15px #09274422;
    }
    .ajm-ticker-label { display: flex; align-items: center; gap: 8px; white-space: nowrap; flex: 0 0 auto; color: #f2dca9; font-size: 9px; font-weight: 800; letter-spacing: 1.2px; }
    .ticker-live-dot { width: 6px; height: 6px; border-radius: 50%; background: #e7c77f; box-shadow: 0 0 0 4px #e7c77f20; animation: livePulse 2s infinite; }
    .ajm-ticker-window { flex: 1; min-width: 0; overflow: hidden; }
    .ajm-ticker-track { display: flex; align-items: center; width: max-content; animation: bulletin 48s linear infinite; }
    .ajm-ticker-track > span { display: flex; align-items: center; gap: 9px; white-space: nowrap; padding: 0 22px; border-right: 1px solid #ffffff30; font-size: 11px; font-weight: 600; }
    .ticker-toggle { width: 27px; height: 27px; flex: 0 0 27px; display: grid; place-items: center; border: 1px solid #ffffff65; border-radius: 50%; background: #ffffff10; color: #fff; font-size: 10px; transition: all .2s; }
    .ticker-toggle:hover { background: var(--gold); color: var(--navy); transform: scale(1.06); }
    .ajm-ticker-track.is-paused { animation-play-state: paused; }
    .ui-icon { display: inline-flex; align-items: center; justify-content: center; vertical-align: -.2em; margin-right: 6px; color: #527b8b; }
    .ui-icon svg { width: 1.1em; height: 1.1em; stroke: currentColor; fill: none; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
    @keyframes bulletin { to { transform: translateX(-50%); } }
    @keyframes livePulse { 50% { box-shadow: 0 0 0 7px #e7c77f08; opacity: .7; } }

    /* Shared homepage navigation — same structure, logo, subtitle, order and button styling. */
    .navbar {
      width: 100%; max-width: none; margin: 0; padding: 12px clamp(14px, 3vw, 48px); position: sticky; top: 0; z-index: 1030;
      border: 0 !important; border-bottom: 1px solid #e6e8e7 !important; border-radius: 0;
      background: rgba(255, 253, 248, .88) !important; backdrop-filter: blur(22px) saturate(145%);
      -webkit-backdrop-filter: blur(22px) saturate(145%); box-shadow: 0 8px 28px #0c2c4d0b !important;
    }
    .navbar > .container-fluid { width: 100%; max-width: 1700px; margin: auto; padding: 0; gap: 18px; }
    .navbar-brand { display: flex; align-items: center; gap: 11px !important; margin: 0; color: var(--navy) !important; font-size: clamp(1rem, 1.45vw, 1.4rem); font-weight: 800; letter-spacing: -.5px; white-space: nowrap; }
    .navbar-brand img { width: 44px; height: 44px; object-fit: contain; padding: 3px; border-radius: 13px !important; background: #fff; box-shadow: 0 5px 15px #0c2c4d14; }
    .navbar-collapse { flex-grow: 0; }
    .navbar-nav { align-items: center; gap: 5px; }
    .navbar .btn { margin: 0 !important; padding: 10px 13px; border: 1px solid transparent !important; border-radius: 11px; font-size: 12px; font-weight: 800; white-space: nowrap; transition: transform .22s, box-shadow .22s, background .22s; }
    .navbar .btn-outline-light { background: #f0f5fa; color: #244f75; }
    .navbar .btn-outline-light:nth-child(2) { background: #edf6f0; color: #36745d; }
    .navbar .btn-outline-light:nth-child(3) { background: #fbf2e4; color: #946d2e; }
    .navbar .btn-outline-light:nth-child(4) { background: #f4effb; color: #6a55a0; }
    .navbar .btn-light { background: var(--navy) !important; color: #fff !important; box-shadow: 0 7px 16px #0c2c4d1e; }
    .navbar .btn:hover { transform: translateY(-2px); box-shadow: 0 10px 22px #0c2c4d18; }
    .navbar .btn[aria-current="page"] { box-shadow: inset 0 0 0 1px rgba(12,44,77,.18), 0 5px 14px #0c2c4d12; }
    .navbar-toggler { border: 1px solid #dfe5e9 !important; border-radius: 10px; padding: 7px 9px; box-shadow: none !important; }

    /* Page-specific results experience. */
    .page-shell { width: 100%; max-width: 1460px; margin: 0 auto; padding: clamp(24px, 4vw, 54px) clamp(16px, 3.4vw, 52px) 0; }
    .results-hero {
      position: relative; isolation: isolate; overflow: hidden; display: grid; grid-template-columns: minmax(0, 1.1fr) minmax(290px, .9fr);
      gap: clamp(22px, 4vw, 56px); align-items: center; padding: clamp(24px, 4vw, 54px);
      border: 1px solid rgba(255,255,255,.9); border-radius: 28px;
      background: radial-gradient(circle at 92% 12%, rgba(201,164,92,.17), transparent 30%), linear-gradient(125deg, rgba(255,253,248,.96), rgba(238,246,251,.92));
      box-shadow: var(--shadow);
    }
    .results-hero::after { content: ""; position: absolute; z-index: -1; width: 340px; height: 340px; right: -120px; bottom: -210px; border: 1px solid rgba(45,108,157,.12); border-radius: 50%; box-shadow: 0 0 0 35px rgba(45,108,157,.035), 0 0 0 70px rgba(45,108,157,.025); }
    .eyebrow { display: flex; align-items: center; gap: 9px; margin: 0 0 13px; color: #667b8d; font-size: 10px; font-weight: 800; letter-spacing: 1.7px; text-transform: uppercase; }
    .eyebrow::before { content: ""; width: 24px; height: 2px; flex: 0 0 24px; background: var(--gold); }
    .results-hero h1 { max-width: 700px; margin: 0 0 16px; font-size: clamp(2.55rem, 5.2vw, 4.9rem); line-height: .99; letter-spacing: -.055em; font-weight: 700; text-wrap: balance; }
    .results-hero h1 span { color: #2c668b; }
    .hero-description { max-width: 600px; margin: 0; color: #586f83; font-size: clamp(14px, 1.18vw, 16px); line-height: 1.8; }
    .hero-pills { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 23px; }
    .hero-pill { display: inline-flex; align-items: center; gap: 7px; padding: 8px 11px; border: 1px solid #e2e8e9; border-radius: 999px; background: rgba(255,255,255,.7); color: #4b667d; font-size: 11px; font-weight: 700; }
    .hero-pill span { color: #997535; font-weight: 900; }
    .results-preview { position: relative; padding: clamp(18px, 2.5vw, 30px); border: 1px solid rgba(255,255,255,.95); border-radius: 23px; background: rgba(255,255,255,.76); box-shadow: 0 18px 46px rgba(12,44,77,.08); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); }
    .preview-top { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 20px; }
    .preview-label { margin: 0; color: #6c7f90; font-size: 10px; font-weight: 800; letter-spacing: 1.2px; text-transform: uppercase; }
    .preview-status { display: inline-flex; align-items: center; gap: 6px; padding: 6px 9px; border-radius: 999px; background: #eaf5ef; color: #317457; font-size: 10px; font-weight: 800; white-space: nowrap; }
    .preview-status::before { content: ""; width: 6px; height: 6px; border-radius: 50%; background: #3c9a6e; }
    .preview-symbol { display: grid; place-items: center; width: 56px; height: 56px; margin-bottom: 15px; border-radius: 17px; background: linear-gradient(145deg, #e4eff8, #f7efdf); color: var(--navy); }
    .preview-symbol svg { width: 28px; height: 28px; fill: none; stroke: currentColor; stroke-width: 1.7; stroke-linecap: round; stroke-linejoin: round; }
    .results-preview h2 { margin: 0 0 8px; font-size: 23px; font-weight: 700; letter-spacing: -.5px; }
    .results-preview > p { margin: 0; color: var(--muted); font-size: 13px; line-height: 1.65; }
    .preview-divider { height: 1px; margin: 20px 0 15px; background: linear-gradient(90deg, var(--line), transparent); }
    .preview-detail { display: flex; align-items: center; gap: 10px; color: #4e667b; font-size: 11px; font-weight: 700; }
    .preview-detail + .preview-detail { margin-top: 10px; }
    .detail-check { display: grid; place-items: center; width: 22px; height: 22px; flex: 0 0 22px; border-radius: 7px; background: #eaf5ef; color: #327b59; font-size: 12px; font-weight: 900; }

    .section-heading { display: flex; align-items: flex-end; justify-content: space-between; gap: 14px; margin: 0 0 18px; }
    .section-heading h2 { margin: 0; font-size: clamp(1.6rem, 2.7vw, 2.15rem); font-weight: 700; letter-spacing: -.04em; }
    .section-heading p { margin: 5px 0 0; color: var(--muted); font-size: 13px; }
    .results-actions { margin-top: clamp(34px, 5vw, 60px); }
    .action-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 18px; }
    .action-card { position: relative; display: flex; flex-direction: column; min-width: 0; padding: clamp(22px, 3vw, 34px); overflow: hidden; border: 1px solid #e7eaf0; border-radius: 23px; background: rgba(255,255,255,.87); box-shadow: 0 10px 30px rgba(12,44,77,.055); transition: transform .25s, box-shadow .25s, border-color .25s; }
    .action-card:hover { transform: translateY(-4px); border-color: #d8e2e9; box-shadow: var(--shadow-hover); }
    .action-card::after { content: ""; position: absolute; width: 190px; height: 190px; right: -75px; top: -90px; border-radius: 50%; background: var(--accent-soft); opacity: .85; pointer-events: none; }
    .action-card.marksheet { --accent: #2c6a9a; --accent-soft: #edf5fb; }
    .action-card.toppers { --accent: #347b5c; --accent-soft: #eaf5ef; }
    .action-icon { position: relative; z-index: 1; display: grid; place-items: center; width: 54px; height: 54px; margin-bottom: 22px; border-radius: 16px; background: var(--accent-soft); color: var(--accent); }
    .action-icon svg { width: 27px; height: 27px; fill: none; stroke: currentColor; stroke-width: 1.7; stroke-linecap: round; stroke-linejoin: round; }
    .action-card h3 { position: relative; z-index: 1; margin: 0 0 10px; font-size: clamp(1.25rem, 2vw, 1.6rem); font-weight: 700; letter-spacing: -.025em; }
    .action-card p { position: relative; z-index: 1; flex: 1; margin: 0 0 24px; color: #6b7d8d; font-size: 13px; line-height: 1.75; }
    .action-meta { display: flex; align-items: center; gap: 8px; margin: -8px 0 22px; color: #61778a; font-size: 11px; font-weight: 700; }
    .action-meta .meta-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--accent); }
    .action-button { display: inline-flex; align-items: center; justify-content: center; align-self: flex-start; gap: 10px; min-height: 46px; padding: 12px 17px; border: 1px solid transparent; border-radius: 12px; background: linear-gradient(110deg, var(--navy), #1d5b87); color: #fff; text-decoration: none; font-size: 12px; font-weight: 800; box-shadow: 0 8px 18px rgba(12,44,77,.13); transition: transform .2s, box-shadow .2s; }
    .action-button:hover { color: #fff; transform: translateY(-2px); box-shadow: 0 12px 25px rgba(12,44,77,.2); }
    .toppers .action-button { background: linear-gradient(110deg, #27684d, #3e8a68); }
    .action-button span { font-size: 17px; line-height: 1; }

    .note-panel { display: grid; grid-template-columns: 42px minmax(0, 1fr); gap: 14px; align-items: start; margin-top: 22px; padding: 20px 22px; border: 1px solid #eadfc5; border-radius: 18px; background: linear-gradient(120deg, rgba(255,249,235,.92), rgba(255,253,248,.9)); }
    .note-icon { display: grid; place-items: center; width: 42px; height: 42px; border-radius: 13px; background: #f7ebcf; color: #987334; font-size: 18px; font-weight: 800; }
    .note-panel h3 { margin: 1px 0 4px; font-family: Inter, Arial, sans-serif; font-size: 13px; font-weight: 800; }
    .note-panel p { margin: 0; color: #6f6d61; font-size: 12px; line-height: 1.7; }

    .stats-section { margin-top: clamp(34px, 5vw, 60px); }
    .stats-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 13px; }
    .stat-card { display: flex; align-items: center; gap: 14px; min-width: 0; padding: 20px; border: 1px solid #e7e9e6; border-radius: 17px; background: rgba(255,255,255,.78); box-shadow: 0 8px 22px rgba(12,44,77,.04); }
    .stat-icon { display: grid; place-items: center; width: 44px; height: 44px; flex: 0 0 44px; border-radius: 13px; background: #f7efde; color: #a37c36; font-size: 19px; }
    .stat-card:nth-child(2) .stat-icon { background: #eaf5ef; color: #347b5c; }
    .stat-card:nth-child(3) .stat-icon { background: #edf5fb; color: #2c6a9a; }
    .stat-card h3 { margin: 0 0 3px; font-family: Inter, Arial, sans-serif; font-size: clamp(13px, 1.25vw, 16px); font-weight: 800; line-height: 1.3; }
    .stat-card p { margin: 0; color: var(--muted); font-size: 11px; line-height: 1.45; }

    /* Shared homepage footer. Keep contact details and visual treatment consistent. */
    footer {
      margin-top: 65px !important; padding: 32px 16px !important; border-top: 3px solid var(--gold);
      background: linear-gradient(110deg, #092744, #164c70) !important; color: #eaf1f5 !important;
      text-align: center; font-family: Arial, sans-serif;
    }
    footer .footer-school { font-size: 14px; font-weight: 600; margin-bottom: 6px; }
    footer .footer-contact { font-size: 13px; line-height: 1.5; margin-bottom: 10px; }
    footer a { color: #f1dba6 !important; text-decoration: none; }
    footer a:hover { color: #fff !important; }
    footer .footer-divider { height: 1px; width: 85%; max-width: 1100px; background: #ffffff35; margin: 12px auto; }
    footer small { color: #c5d4df !important; font-size: 12px; display: block; margin-top: 5px; }

    @media (max-width: 1100px) {
      .navbar .btn { padding: 9px 10px; font-size: 11px; }
      .navbar-nav { gap: 4px; }
      .results-hero { grid-template-columns: minmax(0, 1fr) minmax(270px, .82fr); gap: 24px; }
      .action-grid { gap: 14px; }
      .stat-card { padding: 16px; gap: 11px; }
    }
    @media (max-width: 767.98px) {
      html { scroll-padding-top: 78px; }
      body { font-size: 14px; }
      .ajm-ticker { height: 34px; min-height: 34px; gap: 8px; padding: 3px 8px; }
      .ajm-ticker-label { gap: 6px; font-size: 8px; letter-spacing: .65px; }
      .ticker-live-dot { width: 5px; height: 5px; }
      .ajm-ticker-window { flex: 1 1 auto; min-width: 0; }
      .ajm-ticker-track { animation-duration: 34s; }
      .ajm-ticker-track > span { gap: 7px; padding: 0 13px; font-size: 9.5px; line-height: 1.2; }
      .ajm-ticker-track .ui-icon { margin-right: 0; font-size: 10px; }
      .ticker-toggle { width: 25px; height: 25px; flex: 0 0 25px; font-size: 9px; }
      .navbar { position: sticky; top: 0; padding: 8px 12px; z-index: 1030; }
      .navbar > .container-fluid { gap: 8px; }
      .navbar-brand { font-size: 15px; line-height: 1.15; gap: 8px !important; white-space: normal; min-width: 0; }
      .navbar-brand img { width: 36px; height: 36px; flex: 0 0 36px; }
      .navbar-brand small { font-size: 10px !important; }
      .navbar-toggler { padding: 6px 8px; }
      .navbar-collapse { padding: 10px 0 4px; }
      .navbar-nav { align-items: stretch; gap: 5px; }
      .navbar .btn { width: 100%; text-align: left; padding: 10px 12px; font-size: 12px; }

      .page-shell { padding: 20px 13px 0; }
      .results-hero { grid-template-columns: 1fr; gap: 22px; padding: 23px 18px; border-radius: 21px; }
      .eyebrow { font-size: 8px; letter-spacing: 1.1px; margin-bottom: 10px; }
      .eyebrow::before { width: 18px; flex-basis: 18px; }
      .results-hero h1 { font-size: clamp(2.25rem, 10vw, 3.2rem); line-height: .99; margin-bottom: 11px; }
      .hero-description { font-size: 12.5px; line-height: 1.7; }
      .hero-pills { margin-top: 15px; gap: 6px; }
      .hero-pill { padding: 7px 9px; font-size: 9px; }
      .results-preview { padding: 18px; border-radius: 17px; }
      .preview-top { margin-bottom: 14px; }
      .preview-symbol { width: 46px; height: 46px; margin-bottom: 12px; border-radius: 13px; }
      .preview-symbol svg { width: 23px; height: 23px; }
      .results-preview h2 { font-size: 20px; }
      .results-preview > p { font-size: 12px; }
      .preview-divider { margin: 15px 0 12px; }
      .preview-detail { font-size: 10.5px; }
      .results-actions, .stats-section { margin-top: 32px; }
      .section-heading { align-items: flex-start; margin-bottom: 13px; }
      .section-heading h2 { font-size: 1.55rem; }
      .section-heading p { font-size: 11.5px; }
      .action-grid { grid-template-columns: 1fr; gap: 12px; }
      .action-card { padding: 20px; border-radius: 18px; }
      .action-icon { width: 46px; height: 46px; margin-bottom: 16px; border-radius: 13px; }
      .action-icon svg { width: 23px; height: 23px; }
      .action-card h3 { font-size: 1.25rem; }
      .action-card p { font-size: 12px; margin-bottom: 20px; }
      .action-meta { margin: -6px 0 18px; font-size: 10px; }
      .action-button { width: 100%; min-height: 44px; font-size: 11px; }
      .note-panel { grid-template-columns: 34px minmax(0, 1fr); gap: 10px; margin-top: 13px; padding: 14px; border-radius: 15px; }
      .note-icon { width: 34px; height: 34px; border-radius: 10px; font-size: 15px; }
      .note-panel h3 { font-size: 12px; }
      .note-panel p { font-size: 11px; }
      .stats-grid { grid-template-columns: 1fr; gap: 9px; }
      .stat-card { padding: 14px; gap: 11px; border-radius: 14px; }
      .stat-icon { width: 39px; height: 39px; flex-basis: 39px; border-radius: 11px; font-size: 17px; }
      .stat-card h3 { font-size: 13px; }
      .stat-card p { font-size: 10px; }
      footer { margin-top: 40px !important; padding: 26px 15px !important; }
      footer .footer-contact { display: flex; flex-wrap: wrap; justify-content: center; column-gap: 9px; row-gap: 3px; font-size: 12px; }
      footer .footer-divider { width: 92%; }
    }
    @media (max-width: 390px) {
      .ajm-ticker-label { font-size: 7.2px; letter-spacing: .45px; gap: 4px; }
      .ajm-ticker-track > span { padding: 0 10px; font-size: 9px; }
      .navbar-brand { font-size: 14px; }
      .results-hero { padding: 20px 15px; }
      .results-hero h1 { font-size: 2.18rem; }
      .hero-pill { font-size: 8.5px; }
      .preview-top { align-items: flex-start; flex-direction: column; gap: 8px; }
    }
    @media (prefers-reduced-motion: reduce) {
      html { scroll-behavior: auto; }
      *, *::before, *::after { animation-duration: .01ms !important; animation-iteration-count: 1 !important; transition-duration: .01ms !important; }
      .ajm-ticker-track { animation: none !important; }
    }
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
          <a class="btn btn-outline-light" href="fees.php">Pay Fees</a>
          <a class="btn btn-outline-light" href="gallery.php">Gallery</a>
          <a class="btn btn-outline-light" href="index.php#location">Contact</a>
          <a class="btn btn-light" href="login.php">Admin</a>
        </div>
      </div>
    </div>
  </nav>

  <main>
    <div class="page-shell">
     
      <section class="results-actions" aria-labelledby="results-options-title">
        <div class="section-heading">
          <div>
            <h2 id="results-options-title">Choose an option</h2>
            <p>Open the right portal in just one step.</p>
          </div>
        </div>

        <div class="action-grid">
          <article class="action-card marksheet">
            <div class="action-icon" aria-hidden="true">
              <svg viewBox="0 0 24 24"><path d="M6 3h8l4 4v14H6z"/><path d="M14 3v5h5M9 12h6M9 16h6"/><path d="M12 11v6M10 15l2 2 2-2"/></svg>
            </div>
            <h3>Download your marksheet</h3>
            <p>Students can securely access and download their official marksheet using their assigned roll number and password.</p>
            <div class="action-meta"><span class="meta-dot"></span> Registered students only</div>
            <a href="result-download-login.php" class="action-button">Continue to marksheet login <span aria-hidden="true">→</span></a>
          </article>

          <article class="action-card toppers">
            <div class="action-icon" aria-hidden="true">
              <svg viewBox="0 0 24 24"><path d="M8 21h8M12 17v4M7 4h10v5a5 5 0 0 1-10 0V4Z"/><path d="M7 6H4v2a4 4 0 0 0 4 4M17 6h3v2a4 4 0 0 1-4 4"/><path d="m12 7 .8 1.6 1.8.3-1.3 1.3.3 1.8-1.6-.8-1.6.8.3-1.8-1.3-1.3 1.8-.3z"/></svg>
            </div>
            <h3>View class-wise toppers</h3>
            <p>Explore the topper lists for each class. Public lists are presented without marks to respect student privacy.</p>
            <div class="action-meta"><span class="meta-dot"></span> Public access · No login required</div>
            <a href="public-topper-view.php" class="action-button">View class-wise toppers <span aria-hidden="true">→</span></a>
          </article>
        </div>

        <aside class="note-panel" aria-label="Important information">
          <div class="note-icon" aria-hidden="true">i</div>
          <div>
            <h3>Important information</h3>
            <p>Only registered students with their assigned credentials can download full marksheets. Topper lists are available publicly without marks. If you have trouble accessing your marksheet, please contact the school office.</p>
          </div>
        </aside>
      </section>

      <section class="stats-section" aria-label="School result information">
        <div class="section-heading">
          <div>
            <h2>At a glance</h2>
            <p>Academic information highlighted by the school.</p>
          </div>
        </div>
        <div class="stats-grid">
          <article class="stat-card">
            <div class="stat-icon" aria-hidden="true">▤</div>
            <div><h3>10 Classes</h3><p>From Class 1 to Class 10</p></div>
          </article>
          <article class="stat-card">
            <div class="stat-icon" aria-hidden="true">✓</div>
            <div><h3>100% Pass Rate</h3><p>Class 10 board results</p></div>
          </article>
          <article class="stat-card">
            <div class="stat-icon" aria-hidden="true">♙</div>
            <div><h3>50+ Students</h3><p>Appeared in 2025 exams</p></div>
          </article>
        </div>
      </section>
    </div>
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
    })();
  </script>
</body>
</html>
