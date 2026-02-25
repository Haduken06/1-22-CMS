<?php 
  include "../db_connect.php";
  // Session / user auth (uncomment when ready)
  // if (!isset($_SESSION['username'])) { ... }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Book a Court</title>
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Source+Code+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

    :root {
      --bg:       #f0f2f5;
      --white:    #ffffff;
      --primary:  #1a56db;
      --primary-h:#1648c0;
      --success:  #057a55;
      --warn:     #c27803;
      --danger:   #c81e1e;
      --text:     #111928;
      --muted:    #6b7280;
      --border:   #e4e7ec;
      --radius:   14px;
      --shadow:   0 1px 3px rgba(0,0,0,.08), 0 4px 16px rgba(0,0,0,.06);
      --receipt-bg: #fffdf8;
      --receipt-dark: #1a1a2e;
    }

    body {
      background: var(--bg);
      color: var(--text);
      font-family: 'Outfit', sans-serif;
      min-height: 100vh;
    }

    /* ── TOPBAR ── */
    .topbar {
      background: var(--white);
      border-bottom: 1px solid var(--border);
      padding: 0 28px;
      height: 62px;
      display: flex;
      align-items: center;
      gap: 16px;
      position: sticky;
      top: 0;
      z-index: 300;
      box-shadow: 0 1px 8px rgba(0,0,0,.06);
    }

    .back-btn {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      text-decoration: none;
      color: var(--primary);
      font-weight: 600;
      font-size: 0.875rem;
      padding: 7px 16px;
      border-radius: 9px;
      border: 1.5px solid var(--border);
      background: var(--white);
      transition: all .2s;
      font-family: 'Outfit', sans-serif;
    }
    .back-btn:hover { background: #eff6ff; border-color: var(--primary); transform: translateX(-2px); }

    .topbar-title {
      font-weight: 800;
      font-size: 1.1rem;
      color: var(--text);
      letter-spacing: -.02em;
    }
    .topbar-title span { color: var(--primary); }

    /* ── PAGE BODY ── */
    .page {
      max-width: 1100px;
      margin: 32px auto;
      padding: 0 24px 60px;
    }

    .page-heading {
      font-size: 1.6rem;
      font-weight: 800;
      margin-bottom: 4px;
      letter-spacing: -.02em;
    }

    .page-sub {
      color: var(--muted);
      font-size: 0.9rem;
      margin-bottom: 26px;
    }

    /* ── CALENDAR CARD ── */
    .cal-card {
      background: var(--white);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      padding: 26px;
      box-shadow: var(--shadow);
    }

    /* ── FULLCALENDAR OVERRIDES ── */
    .fc {
      --fc-border-color: var(--border);
      --fc-button-bg-color: var(--white);
      --fc-button-border-color: var(--border);
      --fc-button-hover-bg-color: #eff6ff;
      --fc-button-text-color: var(--text);
      --fc-today-bg-color: #eff6ff;
      --fc-page-bg-color: transparent;
      color: var(--text);
      font-family: 'Outfit', sans-serif;
    }
    .fc .fc-toolbar-title { font-size: 1.15rem; font-weight: 800; color: var(--text); letter-spacing: -.02em; }
    .fc .fc-col-header-cell-cushion { font-size: 0.72rem; font-weight: 700; letter-spacing: .07em; text-transform: uppercase; color: var(--muted); text-decoration: none; }
    .fc .fc-daygrid-day-number { font-size: 0.85rem; font-weight: 600; color: var(--text); text-decoration: none; padding: 6px 8px; }
    .fc .fc-day-other .fc-daygrid-day-number { display: none; }
    .fc .fc-day-other { background: transparent !important; pointer-events: none; }
    .fc .fc-day-other .fc-daygrid-day-events { display: none; }
    .fc .fc-daygrid-day { cursor: pointer; transition: background .15s; }
    .fc .fc-daygrid-day:not(.fc-day-other):hover { background: #eff6ff !important; }
    .fc-day-today .fc-daygrid-day-number { background: var(--primary); color: #fff !important; border-radius: 7px; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; }
    .fc .fc-button { border-radius: 9px !important; font-family: 'Outfit', sans-serif !important; font-weight: 700 !important; font-size: 0.8rem !important; padding: 7px 14px !important; box-shadow: none !important; transition: all .2s !important; }
    .fc .fc-button-primary:not(:disabled):active, .fc .fc-button-primary:not(:disabled).fc-button-active { background: #eff6ff !important; border-color: var(--primary) !important; color: var(--primary) !important; box-shadow: none !important; }
    .fc .fc-daygrid-event { border-radius: 5px !important; font-size: 0.7rem; font-weight: 600; border: none !important; padding: 2px 6px; }

    /* ── BOOKING MODAL ── */
    .modal {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0,0,0,.6);
      backdrop-filter: blur(6px);
      z-index: 500;
      align-items: center;
      justify-content: center;
      padding: 16px;
      overflow-y: auto;
    }

    .modal-box {
      background: var(--white);
      border-radius: 20px;
      width: 100%;
      max-width: 1200px;
      box-shadow: 0 32px 80px rgba(0,0,0,.25);
      animation: pop .28s cubic-bezier(.34,1.4,.64,1);
      overflow: hidden;
      margin: auto;
    }

    @keyframes pop {
      from { opacity: 0; transform: scale(.95) translateY(20px); }
      to   { opacity: 1; transform: scale(1) translateY(0); }
    }

    .modal-head {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 22px 28px;
      background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
      position: relative;
      overflow: hidden;
    }
    .modal-head::before { content:''; position:absolute; width:260px; height:260px; border-radius:50%; background:rgba(255,255,255,.05); top:-120px; right:100px; }
    .modal-head::after  { content:''; position:absolute; width:140px; height:140px; border-radius:50%; background:rgba(255,255,255,.04); bottom:-60px; right:30px; }
    .modal-head-left { position:relative; z-index:1; }
    .modal-head-eyebrow { font-size:0.68rem; font-weight:700; letter-spacing:.12em; text-transform:uppercase; color:rgba(255,255,255,.5); margin-bottom:4px; }
    .modal-head h2 { font-size:1.5rem; font-weight:800; color:#fff; letter-spacing:-.02em; }
    .modal-head .selected-date { font-size:0.85rem; color:rgba(255,255,255,.65); margin-top:4px; font-weight:400; }
    .modal-head-right { display:flex; align-items:center; gap:14px; position:relative; z-index:1; }
    .modal-head-icon { width:52px; height:52px; background:rgba(255,255,255,.12); border:1.5px solid rgba(255,255,255,.2); border-radius:14px; display:flex; align-items:center; justify-content:center; font-size:1.4rem; color:#fff; }
    .close-x { width:36px; height:36px; border-radius:10px; border:1.5px solid rgba(255,255,255,.2); background:rgba(255,255,255,.1); color:rgba(255,255,255,.8); font-size:0.95rem; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:all .2s; }
    .close-x:hover { background:rgba(220,38,38,.6); border-color:rgba(220,38,38,.6); color:#fff; }

    .modal-body { display:flex; flex-direction:column; }

    .res-panel {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
      padding: 24px 28px;
      background: #eef2ff;
      border-bottom: 1px solid #c7d2fe;
    }

    .period-card { border-radius:16px; overflow:hidden; box-shadow:0 6px 24px rgba(0,0,0,.1); }
    .period-card-head { padding:18px 20px; display:flex; align-items:center; gap:14px; }
    .pch-icon { width:46px; height:46px; border-radius:12px; background:rgba(255,255,255,.22); display:flex; align-items:center; justify-content:center; font-size:1.2rem; color:#fff; flex-shrink:0; }
    .pch-title { font-size:1.2rem; font-weight:800; color:#fff; letter-spacing:-.02em; }
    .pch-sub { font-size:0.75rem; color:rgba(255,255,255,.7); font-weight:500; margin-top:2px; }
    .pch-count { margin-left:auto; background:rgba(255,255,255,.2); color:#fff; font-size:0.75rem; font-weight:800; padding:3px 10px; border-radius:20px; }
    .period-card.am .period-card-head { background:linear-gradient(135deg,#1e40af 0%,#3b82f6 100%); }
    .period-card.pm .period-card-head { background:linear-gradient(135deg,#78350f 0%,#f59e0b 100%); }
    .period-card-body { background:#fff; padding:14px; min-height:160px; max-height:280px; overflow-y:auto; }

    .res-card { background:#f8fafc; border:1.5px solid #e2e8f0; border-left:4px solid #3b82f6; border-radius:10px; padding:12px 14px; margin-bottom:10px; transition:all .15s; }
    .res-card:last-child { margin-bottom:0; }
    .period-card.pm .res-card { border-left-color:#f59e0b; }
    .res-card:hover { transform:translateX(2px); box-shadow:0 3px 12px rgba(0,0,0,.08); }
    .res-card .rc-time { font-size:0.9rem; font-weight:800; color:#1d4ed8; margin-bottom:6px; display:flex; align-items:center; gap:7px; }
    .period-card.pm .res-card .rc-time { color:#b45309; }
    .res-card .rc-row { display:flex; align-items:center; gap:7px; font-size:0.82rem; color:#374151; margin-bottom:3px; font-weight:500; }
    .res-card .rc-row i { color:#9ca3af; width:13px; font-size:0.7rem; flex-shrink:0; }
    .rc-status { display:inline-flex; align-items:center; padding:3px 10px; border-radius:20px; font-size:0.68rem; font-weight:700; text-transform:uppercase; letter-spacing:.05em; margin-top:7px; }
    .rc-status.pending  { background:#fef3c7; color:#92400e; }
    .rc-status.accepted { background:#dcfce7; color:#14532d; }
    .rc-status.rejected { background:#fee2e2; color:#991b1b; }
    .period-empty { text-align:center; padding:30px 0; color:#9ca3af; font-size:0.85rem; }
    .period-empty i { display:block; font-size:2rem; margin-bottom:8px; opacity:.25; }

    .form-panel { padding:24px 28px; background:var(--white); }
    .form-panel h3 { font-size:0.75rem; font-weight:800; letter-spacing:.1em; text-transform:uppercase; color:var(--muted); margin-bottom:16px; }
    .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:0 20px; }
    .form-grid .fg.full { grid-column:1 / -1; }
    .fg { margin-bottom:13px; }
    .fg label { display:block; font-size:0.72rem; font-weight:700; color:var(--muted); letter-spacing:.05em; text-transform:uppercase; margin-bottom:5px; }
    .fg input, .fg select { width:100%; padding:10px 13px; border:1.5px solid var(--border); border-radius:9px; font-family:'Outfit',sans-serif; font-size:0.875rem; color:var(--text); background:var(--white); outline:none; transition:border-color .2s,box-shadow .2s; }
    .fg input[readonly] { background:#f0f4ff; color:var(--primary); font-weight:700; cursor:default; }
    .fg input:focus, .fg select:focus { border-color:var(--primary); box-shadow:0 0 0 3px rgba(37,99,235,.12); }
    .form-footer { display:flex; align-items:center; justify-content:flex-end; padding-top:6px; }
    .submit-btn { padding:12px 32px; background:linear-gradient(135deg,#1d4ed8,#2563eb); color:#fff; border:none; border-radius:11px; font-family:'Outfit',sans-serif; font-weight:800; font-size:0.95rem; cursor:pointer; display:flex; align-items:center; gap:9px; transition:all .2s; box-shadow:0 4px 16px rgba(37,99,235,.35); }
    .submit-btn:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(37,99,235,.45); }

    /* ════════════════════════════════════
       RECEIPT CONFIRMATION MODAL
       ════════════════════════════════════ */
    .receipt-overlay {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(5,10,25,.85);
      backdrop-filter: blur(12px);
      z-index: 700;
      align-items: center;
      justify-content: center;
      padding: 20px;
      overflow-y: auto;
    }

    /* The receipt wrapper — centering + drop shadow */
    .receipt-wrapper {
      display: flex;
      flex-direction: column;
      align-items: center;
      width: 100%;
      max-width: 480px;
      margin: auto;
      animation: receiptSlide .45s cubic-bezier(.34,1.5,.64,1);
    }

    @keyframes receiptSlide {
      from { opacity:0; transform:translateY(60px) scale(.94); }
      to   { opacity:1; transform:translateY(0) scale(1); }
    }

    /* Paper receipt */
    .receipt {
      background: var(--receipt-bg);
      width: 100%;
      border-radius: 10px 10px 0 0;
      box-shadow:
        0 0 0 1px rgba(0,0,0,.08),
        0 20px 60px rgba(0,0,0,.45),
        4px 0 0 rgba(0,0,0,.04),
        -4px 0 0 rgba(0,0,0,.04);
      position: relative;
      overflow: visible;
    }

    /* Torn top edge — zigzag via SVG-like clip path */
    .receipt::before {
      content: '';
      position: absolute;
      top: -10px;
      left: 0; right: 0;
      height: 12px;
      background: var(--receipt-bg);
      clip-path: polygon(
        0% 100%, 2% 0%, 4% 100%, 6% 0%, 8% 100%, 10% 0%, 12% 100%,
        14% 0%, 16% 100%, 18% 0%, 20% 100%, 22% 0%, 24% 100%, 26% 0%,
        28% 100%, 30% 0%, 32% 100%, 34% 0%, 36% 100%, 38% 0%, 40% 100%,
        42% 0%, 44% 100%, 46% 0%, 48% 100%, 50% 0%, 52% 100%, 54% 0%,
        56% 100%, 58% 0%, 60% 100%, 62% 0%, 64% 100%, 66% 0%, 68% 100%,
        70% 0%, 72% 100%, 74% 0%, 76% 100%, 78% 0%, 80% 100%, 82% 0%,
        84% 100%, 86% 0%, 88% 100%, 90% 0%, 92% 100%, 94% 0%, 96% 100%,
        98% 0%, 100% 100%
      );
      filter: drop-shadow(0 -2px 2px rgba(0,0,0,.08));
    }

    /* Header of receipt */
    .receipt-header {
      background: var(--receipt-dark);
      padding: 24px 28px 20px;
      text-align: center;
      position: relative;
      border-radius: 10px 10px 0 0;
    }

    .receipt-logo {
      width: 52px; height: 52px;
      background: var(--primary);
      border-radius: 14px;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.4rem;
      color: #fff;
      margin: 0 auto 12px;
      box-shadow: 0 4px 16px rgba(26,86,219,.5);
    }

    .receipt-org {
      font-size: 0.72rem;
      font-weight: 700;
      letter-spacing: .15em;
      text-transform: uppercase;
      color: rgba(255,255,255,.45);
      margin-bottom: 4px;
    }

    .receipt-title {
      font-size: 1.3rem;
      font-weight: 900;
      color: #fff;
      letter-spacing: -.01em;
    }

    .receipt-subtitle {
      font-size: 0.75rem;
      color: rgba(255,255,255,.45);
      margin-top: 4px;
    }

    /* Status badge */
    .receipt-status {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: rgba(255,179,0,.15);
      border: 1px solid rgba(255,179,0,.4);
      color: #fbbf24;
      font-size: 0.7rem;
      font-weight: 800;
      letter-spacing: .1em;
      text-transform: uppercase;
      padding: 5px 14px;
      border-radius: 20px;
      margin-top: 12px;
    }

    /* Perforated divider */
    .perf {
      position: relative;
      height: 1px;
      margin: 0;
      background: repeating-linear-gradient(
        to right,
        transparent,
        transparent 6px,
        #d1d5db 6px,
        #d1d5db 12px
      );
    }

    /* Circles on perf edges (hole punches) */
    .perf::before, .perf::after {
      content: '';
      position: absolute;
      width: 20px; height: 20px;
      border-radius: 50%;
      background: rgba(5,10,25,.85);
      top: 50%;
      transform: translateY(-50%);
    }
    .perf::before { left: -10px; }
    .perf::after  { right: -10px; }

    /* Body */
    .receipt-body { padding: 22px 28px; }

    /* Date strip */
    .receipt-date-strip {
      text-align: center;
      margin-bottom: 20px;
    }

    .rds-label {
      font-size: 0.65rem;
      font-weight: 700;
      letter-spacing: .12em;
      text-transform: uppercase;
      color: var(--muted);
    }

    .rds-date {
      font-size: 1rem;
      font-weight: 800;
      color: var(--text);
      margin-top: 2px;
      letter-spacing: -.01em;
    }

    /* Detail rows — receipt line items */
    .receipt-section-label {
      font-size: 0.6rem;
      font-weight: 800;
      letter-spacing: .14em;
      text-transform: uppercase;
      color: var(--muted);
      margin-bottom: 10px;
      margin-top: 18px;
    }
    .receipt-section-label:first-of-type { margin-top: 0; }

    .receipt-row {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      padding: 7px 0;
      border-bottom: 1px solid #f3f4f6;
      gap: 12px;
    }
    .receipt-row:last-child { border-bottom: none; }

    .rr-key {
      font-size: 0.78rem;
      color: var(--muted);
      font-weight: 500;
      flex-shrink: 0;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .rr-key i {
      width: 14px;
      font-size: 0.7rem;
      color: #c4c9d4;
    }

    .rr-val {
      font-size: 0.82rem;
      font-weight: 700;
      color: var(--text);
      text-align: right;
      word-break: break-word;
      max-width: 60%;
    }

    /* Booking code section */
    .receipt-code-section {
      background: #f8f9ff;
      border: 1.5px dashed #c7d2fe;
      border-radius: 12px;
      padding: 16px;
      text-align: center;
      margin: 18px 0;
    }

    .rcs-label {
      font-size: 0.62rem;
      font-weight: 800;
      letter-spacing: .15em;
      text-transform: uppercase;
      color: var(--muted);
      margin-bottom: 8px;
    }

    .rcs-code {
      font-family: 'Source Code Pro', monospace;
      font-size: 2.6rem;
      font-weight: 700;
      letter-spacing: .22em;
      color: var(--primary);
      line-height: 1;
    }

    .rcs-hint {
      font-size: 0.68rem;
      color: var(--muted);
      margin-top: 6px;
    }

    /* Barcode */
    .receipt-barcode {
      display: flex;
      flex-direction: column;
      align-items: center;
      margin: 16px 0 8px;
    }

    .barcode-bars {
      display: flex;
      gap: 2px;
      height: 40px;
      align-items: flex-end;
    }

    .barcode-bars span {
      display: inline-block;
      background: #1a1a2e;
      border-radius: 1px;
    }

    .barcode-num {
      font-family: 'Source Code Pro', monospace;
      font-size: 0.65rem;
      color: var(--muted);
      margin-top: 5px;
      letter-spacing: .1em;
    }

    /* Copy button */
    .receipt-copy-btn {
      width: 100%;
      padding: 11px;
      background: var(--primary);
      color: #fff;
      border: none;
      border-radius: 10px;
      font-family: 'Outfit', sans-serif;
      font-weight: 800;
      font-size: 0.9rem;
      cursor: pointer;
      display: flex; align-items: center; justify-content: center; gap: 8px;
      transition: all .2s;
      margin-bottom: 10px;
    }
    .receipt-copy-btn:hover { background: var(--primary-h); transform: translateY(-1px); }
    .receipt-copy-btn.copied { background: var(--success); }

    /* Footer of receipt */
    .receipt-footer {
      text-align: center;
      padding: 16px 28px 22px;
      border-top: 1px dashed #e5e7eb;
    }

    .rf-text {
      font-size: 0.7rem;
      color: #9ca3af;
      line-height: 1.7;
    }

    .rf-text strong { color: var(--muted); }

    /* Torn bottom edge */
    .receipt-tear-bottom {
      width: 100%;
      height: 14px;
      background: var(--receipt-bg);
      clip-path: polygon(
        0% 0%, 2% 100%, 4% 0%, 6% 100%, 8% 0%, 10% 100%, 12% 0%,
        14% 100%, 16% 0%, 18% 100%, 20% 0%, 22% 100%, 24% 0%, 26% 100%,
        28% 0%, 30% 100%, 32% 0%, 34% 100%, 36% 0%, 38% 100%, 40% 0%,
        42% 100%, 44% 0%, 46% 100%, 48% 0%, 50% 100%, 52% 0%, 54% 100%,
        56% 0%, 58% 100%, 60% 0%, 62% 100%, 64% 0%, 66% 100%, 68% 0%,
        70% 100%, 72% 0%, 74% 100%, 76% 0%, 78% 100%, 80% 0%, 82% 100%,
        84% 0%, 86% 100%, 88% 0%, 90% 100%, 92% 0%, 94% 100%, 96% 0%,
        98% 100%, 100% 0%
      );
      box-shadow: 0 6px 16px rgba(0,0,0,.12);
    }

    /* Countdown + action buttons below receipt */
    .receipt-actions {
      background: #0f172a;
      width: 100%;
      border-radius: 0 0 14px 14px;
      padding: 16px 24px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
    }

    .receipt-timer {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .rt-ring {
      position: relative;
      width: 44px; height: 44px;
      flex-shrink: 0;
    }

    .rt-ring svg { transform: rotate(-90deg); }

    .rt-track { fill: none; stroke: #1e293b; stroke-width: 4; }
    .rt-fill  { fill: none; stroke: #22c55e; stroke-width: 4; stroke-linecap: round; stroke-dasharray: 113.1; stroke-dashoffset: 0; transition: stroke-dashoffset 1s linear, stroke .3s; }

    .rt-num {
      position: absolute; inset: 0;
      display: flex; align-items: center; justify-content: center;
      font-size: 0.9rem;
      font-weight: 800;
      color: #fff;
      font-family: 'Source Code Pro', monospace;
    }

    .rt-text {
      font-size: 0.75rem;
      color: #64748b;
      line-height: 1.4;
    }

    .rt-text strong { color: #94a3b8; display: block; font-size: 0.8rem; }

    .receipt-action-btns { display: flex; gap: 8px; }

    .btn-back {
      padding: 9px 18px;
      border-radius: 9px;
      border: 1px solid #334155;
      background: #1e293b;
      font-family: 'Outfit', sans-serif;
      font-weight: 700;
      font-size: 0.82rem;
      cursor: pointer;
      color: #94a3b8;
      transition: all .2s;
      display: flex; align-items: center; gap: 6px;
      white-space: nowrap;
    }
    .btn-back:hover { background: #273549; color: #fff; }

    .btn-submit {
      padding: 9px 20px;
      border-radius: 9px;
      border: none;
      background: linear-gradient(135deg, #16a34a, #15803d);
      color: #fff;
      font-family: 'Outfit', sans-serif;
      font-weight: 800;
      font-size: 0.82rem;
      cursor: pointer;
      display: flex; align-items: center; gap: 6px;
      transition: all .2s;
      box-shadow: 0 3px 12px rgba(22,163,74,.35);
      white-space: nowrap;
    }
    .btn-submit:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(22,163,74,.45); }

    /* ── CONFIRMATION (pre-receipt) OVERLAY ── */
    .confirm-overlay {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(8,15,36,0.82);
      backdrop-filter: blur(10px);
      z-index: 600;
      align-items: center;
      justify-content: center;
      padding: 16px;
      overflow-y: auto;
    }

    .confirm-shell {
      width: 100%;
      max-width: 980px;
      margin: auto;
      animation: pop .3s cubic-bezier(.34,1.4,.64,1);
    }

    .cf-banner {
      background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 50%, #2563eb 100%);
      border-radius: 20px 20px 0 0;
      padding: 28px 32px 24px;
      display: flex; align-items: center; justify-content: space-between; gap: 16px;
      position: relative; overflow: hidden;
    }
    .cf-banner::before { content:''; position:absolute; border-radius:50%; opacity:.12; background:#fff; width:200px; height:200px; top:-80px; right:60px; }
    .cf-banner::after  { content:''; position:absolute; border-radius:50%; opacity:.12; background:#fff; width:120px; height:120px; bottom:-50px; right:20px; }
    .cf-banner-left { position:relative; z-index:1; }
    .cf-banner-eyebrow { font-size:0.7rem; font-weight:700; letter-spacing:.12em; text-transform:uppercase; color:rgba(255,255,255,.6); margin-bottom:6px; }
    .cf-banner h2 { font-size:1.6rem; font-weight:800; color:#fff; letter-spacing:-.02em; }
    .cf-banner-date { margin-top:6px; font-size:0.88rem; color:rgba(255,255,255,.75); font-weight:500; }
    .cf-banner-icon { position:relative; z-index:1; width:64px; height:64px; background:rgba(255,255,255,.15); border:2px solid rgba(255,255,255,.25); border-radius:18px; display:flex; align-items:center; justify-content:center; font-size:1.8rem; color:#fff; flex-shrink:0; }

    .cf-cards { background:#f0f4ff; padding:20px; display:grid; grid-template-columns:1fr 1fr 1.15fr; gap:16px; }
    .cf-card { border-radius:16px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,.09); display:flex; flex-direction:column; }
    .cf-card-head { padding:14px 18px; display:flex; align-items:center; gap:10px; }
    .cf-card-head .ch-icon { width:36px; height:36px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:1rem; flex-shrink:0; }
    .cf-card-head .ch-title { font-size:1rem; font-weight:800; letter-spacing:-.01em; }
    .cf-card-head .ch-sub { font-size:0.72rem; font-weight:500; margin-top:1px; opacity:.7; }
    .cf-card.am   .cf-card-head { background:#1d4ed8; color:#fff; }
    .cf-card.am   .cf-card-head .ch-icon { background:rgba(255,255,255,.2); color:#fff; }
    .cf-card.pm   .cf-card-head { background:#b45309; color:#fff; }
    .cf-card.pm   .cf-card-head .ch-icon { background:rgba(255,255,255,.2); color:#fff; }
    .cf-card.newbook .cf-card-head { background:#15803d; color:#fff; }
    .cf-card.newbook .cf-card-head .ch-icon { background:rgba(255,255,255,.2); color:#fff; }
    .cf-card-body { background:var(--white); flex:1; padding:14px; overflow-y:auto; max-height:320px; }

    .cf-entry { background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:12px 14px; margin-bottom:8px; }
    .cf-entry:last-child { margin-bottom:0; }
    .cf-entry .ce-time { font-size:0.88rem; font-weight:800; color:var(--primary); margin-bottom:6px; display:flex; align-items:center; gap:6px; }
    .cf-entry .ce-row { display:flex; align-items:center; gap:7px; font-size:0.8rem; color:#374151; margin-bottom:3px; }
    .cf-entry .ce-row i { color:#9ca3af; width:12px; font-size:0.68rem; flex-shrink:0; }
    .cf-status { display:inline-flex; align-items:center; gap:4px; padding:3px 9px; border-radius:20px; font-size:0.65rem; font-weight:700; text-transform:uppercase; letter-spacing:.05em; margin-top:7px; }
    .cf-status.pending  { background:#fef3c7; color:#92400e; }
    .cf-status.accepted { background:#dcfce7; color:#14532d; }
    .cf-status.rejected { background:#fee2e2; color:#991b1b; }
    .cf-empty { text-align:center; padding:24px 0; color:#9ca3af; font-size:0.82rem; }
    .cf-empty i { display:block; font-size:1.8rem; margin-bottom:8px; opacity:.35; }

    .nb-detail-row { display:flex; align-items:flex-start; padding:9px 0; border-bottom:1px solid #f1f5f9; }
    .nb-detail-row:last-child { border-bottom:none; }
    .nb-icon-wrap { width:30px; height:30px; border-radius:8px; background:#eff6ff; display:flex; align-items:center; justify-content:center; flex-shrink:0; margin-right:10px; font-size:0.72rem; color:var(--primary); }
    .nb-label { font-size:0.7rem; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:.06em; margin-bottom:1px; }
    .nb-value { font-size:0.875rem; font-weight:700; color:#111827; word-break:break-word; }
    .booking-code-chip { display:inline-flex; align-items:center; gap:6px; background:#1d4ed8; color:#fff; padding:4px 12px; border-radius:8px; font-size:0.9rem; font-weight:800; letter-spacing:.04em; }

    .cf-footer { background:#1e293b; border-radius:0 0 20px 20px; padding:18px 24px; display:flex; align-items:center; justify-content:space-between; gap:12px; }
    .cf-footer-note { font-size:0.78rem; color:#94a3b8; max-width:400px; line-height:1.5; }
    .cf-footer-note i { color:#f59e0b; margin-right:4px; }
    .cf-btns { display:flex; gap:10px; }
    .btn-cancel { padding:11px 22px; border-radius:10px; border:1px solid #334155; background:#0f172a; font-family:'Outfit',sans-serif; font-weight:600; font-size:0.875rem; cursor:pointer; color:#cbd5e1; transition:all .2s; display:flex; align-items:center; gap:7px; }
    .btn-cancel:hover { background:#1e293b; border-color:#475569; color:#fff; }
    .btn-confirm { padding:11px 26px; border-radius:10px; border:none; background:linear-gradient(135deg,#16a34a,#15803d); color:#fff; font-family:'Outfit',sans-serif; font-weight:800; font-size:0.9rem; cursor:pointer; display:flex; align-items:center; gap:8px; transition:all .2s; box-shadow:0 4px 14px rgba(22,163,74,.4); }
    .btn-confirm:hover { transform:translateY(-1px); box-shadow:0 6px 20px rgba(22,163,74,.5); }

    /* ── RESPONSIVE ── */
    @media (max-width: 720px) {
      .res-panel { grid-template-columns:1fr; }
      .form-grid { grid-template-columns:1fr; }
      .form-grid .fg.full { grid-column:1; }
      .cf-cards { grid-template-columns:1fr; }
      .cf-banner h2 { font-size:1.2rem; }
      .cf-footer { flex-direction:column; align-items:stretch; }
      .cf-btns { justify-content:flex-end; }
      .modal-head h2 { font-size:1.1rem; }
      .receipt-actions { flex-direction:column; }
    }

    ::-webkit-scrollbar { width: 5px; }
    ::-webkit-scrollbar-track { background: #f9fafb; }
    ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 10px; }
  </style>
</head>
<body>

<!-- TOPBAR -->
<header class="topbar">
  <a href="../index.php" class="back-btn">
    <i class="fas fa-arrow-left"></i> Back
  </a>
</header>

<!-- PAGE -->
<div class="page">
  <div class="page-heading">Book a Court</div>
  <div class="page-sub">Click on any date to view availability and make a reservation.</div>
  <div class="cal-card">
    <div id="calendar"></div>
  </div>
</div>

<!-- ====== BOOKING MODAL ====== -->
<div id="bookingModal" class="modal">
  <div class="modal-box">
    <div class="modal-head">
      <div class="modal-head-left">
        <div class="modal-head-eyebrow">Barangay Ermita Reservation</div>
        <h2>Book a Court</h2>
        <div class="selected-date" id="modalDateLabel">Select a date from the calendar</div>
      </div>
      <div class="modal-head-right">
        <div class="modal-head-icon"><i class="fas fa-basketball-ball"></i></div>
        <button class="close-x" id="closeBooking"><i class="fas fa-times"></i></button>
      </div>
    </div>

    <div class="modal-body">
      <div class="res-panel">
        <div class="period-card am">
          <div class="period-card-head">
            <div class="pch-icon"><i class="fas fa-sun"></i></div>
            <div><div class="pch-title">AM</div><div class="pch-sub">Morning Reservations</div></div>
            <div class="pch-count" id="amCount">0 booked</div>
          </div>
          <div class="period-card-body">
            <div id="amList"><div class="period-empty"><i class="fas fa-sun"></i>No AM bookings yet</div></div>
          </div>
        </div>
        <div class="period-card pm">
          <div class="period-card-head">
            <div class="pch-icon"><i class="fas fa-cloud-sun"></i></div>
            <div><div class="pch-title">PM</div><div class="pch-sub">Afternoon Reservations</div></div>
            <div class="pch-count" id="pmCount">0 booked</div>
          </div>
          <div class="period-card-body">
            <div id="pmList"><div class="period-empty"><i class="fas fa-cloud"></i>No PM bookings yet</div></div>
          </div>
        </div>
      </div>

      <div class="form-panel">
        <h3>Your Booking Details</h3>
        <form id="bookingForm">
          <input type="hidden" id="dbDate" name="date">
          <input type="hidden" id="bookingCode" name="booking_code">
          <div class="form-grid">
            <div class="fg full"><label>Selected Date</label><input type="text" id="displayDate" readonly placeholder="Click a date on the calendar"></div>
            <div class="fg"><label>Full Name *</label><input type="text" id="f_name" name="fullname" placeholder="Juan dela Cruz" required></div>
            <div class="fg"><label>Phone Number *</label><input type="tel" id="f_phone" name="phonenumber" placeholder="+63 9XX XXX XXXX" required></div>
            <div class="fg"><label>Email Address</label><input type="email" id="f_email" name="email" placeholder="your@email.com"></div>
            <div class="fg"><label>Purpose / Activity</label><input type="text" id="f_purpose" name="purpose" placeholder="e.g. Basketball practice"></div>
            <div class="fg"><label>Start Time *</label><input type="time" id="start_time" name="start_time" required></div>
            <div class="fg"><label>End Time *</label><input type="time" id="end_time" name="end_time" required></div>
          </div>
          <div class="form-footer">
            <button type="submit" class="submit-btn"><i class="fas fa-receipt"></i> Review Booking</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- ====== CONFIRM MODAL (review step) ====== -->
<div id="confirmOverlay" class="confirm-overlay">
  <div class="confirm-shell">
    <div class="cf-banner">
      <div class="cf-banner-left">
        <div class="cf-banner-eyebrow">Review Before Submitting</div>
        <h2>Confirm Your Booking</h2>
        <div class="cf-banner-date" id="cf-date-label">—</div>
      </div>
      <div class="cf-banner-icon"><i class="fas fa-calendar-check"></i></div>
    </div>
    <div class="cf-cards">
      <div class="cf-card am">
        <div class="cf-card-head"><div class="ch-icon"><i class="fas fa-sun"></i></div><div><div class="ch-title">AM</div><div class="ch-sub">Reservations</div></div></div>
        <div class="cf-card-body" id="cf-am-list"><div class="cf-empty"><i class="fas fa-moon"></i>No AM bookings</div></div>
      </div>
      <div class="cf-card pm">
        <div class="cf-card-head"><div class="ch-icon"><i class="fas fa-cloud-sun"></i></div><div><div class="ch-title">PM</div><div class="ch-sub">Reservations</div></div></div>
        <div class="cf-card-body" id="cf-pm-list"><div class="cf-empty"><i class="fas fa-cloud"></i>No PM bookings</div></div>
      </div>
      <div class="cf-card newbook">
        <div class="cf-card-head"><div class="ch-icon"><i class="fas fa-star"></i></div><div><div class="ch-title">Your Booking</div><div class="ch-sub">New Reservation</div></div></div>
        <div class="cf-card-body">
          <div class="nb-detail-row"><div class="nb-icon-wrap"><i class="fas fa-user"></i></div><div><div class="nb-label">Full Name</div><div class="nb-value" id="cf-name">—</div></div></div>
          <div class="nb-detail-row"><div class="nb-icon-wrap"><i class="fas fa-phone"></i></div><div><div class="nb-label">Phone</div><div class="nb-value" id="cf-phone">—</div></div></div>
          <div class="nb-detail-row"><div class="nb-icon-wrap"><i class="fas fa-envelope"></i></div><div><div class="nb-label">Email</div><div class="nb-value" id="cf-email">—</div></div></div>
          <div class="nb-detail-row"><div class="nb-icon-wrap"><i class="fas fa-tag"></i></div><div><div class="nb-label">Purpose</div><div class="nb-value" id="cf-purpose">—</div></div></div>
          <div class="nb-detail-row"><div class="nb-icon-wrap"><i class="fas fa-clock"></i></div><div><div class="nb-label">Time Slot</div><div class="nb-value" id="cf-time">—</div></div></div>
         <div class="nb-detail-row"><div class="nb-icon-wrap"><i class="fas fa-hashtag"></i></div><div><div class="nb-label">Booking Code</div><div class="nb-value"><span class="booking-code-chip" id="cf-code">—</span></div></div></div>
        </div>
      </div>
    </div>
    <div class="cf-footer">
      <div class="cf-footer-note"><i class="fas fa-triangle-exclamation"></i> By confirming, your reservation will be submitted for approval.</div>
      <div class="cf-btns">
        <button class="btn-cancel" id="confirmNo"><i class="fas fa-arrow-left"></i> Go Back</button>
        <button class="btn-confirm" id="confirmYes"><i class="fas fa-receipt"></i> Generate Receipt</button>
      </div>
    </div>
  </div>
</div>

<!-- ====== RECEIPT MODAL ====== -->
<div id="receiptOverlay" class="receipt-overlay">
  <div class="receipt-wrapper">

    <div class="receipt">
      <!-- HEADER -->
      <div class="receipt-header">
        <div class="receipt-logo"><i class="fas fa-basketball-ball"></i></div>
        <div class="receipt-org">Barangay Ermita</div>
        <div class="receipt-title">Court Reservation</div>
        <div class="receipt-subtitle">Official Booking Slip</div>
        <div class="receipt-status"><i class="fas fa-clock"></i> Pending Approval</div>
      </div>

      <div class="perf"></div>

      <!-- BODY -->
      <div class="receipt-body">

        <!-- Date -->
        <div class="receipt-date-strip">
          <div class="rds-label">Reservation Date</div>
          <div class="rds-date" id="rcp-date">—</div>
        </div>

        <div class="perf"></div>

        <!-- Booker Details -->
        <div class="receipt-section-label">Booker Information</div>
        <div class="receipt-row"><span class="rr-key"><i class="fas fa-user"></i>Name</span><span class="rr-val" id="rcp-name">—</span></div>
        <div class="receipt-row"><span class="rr-key"><i class="fas fa-phone"></i>Phone</span><span class="rr-val" id="rcp-phone">—</span></div>
        <div class="receipt-row"><span class="rr-key"><i class="fas fa-envelope"></i>Email</span><span class="rr-val" id="rcp-email">—</span></div>
        <div class="receipt-row"><span class="rr-key"><i class="fas fa-tag"></i>Purpose</span><span class="rr-val" id="rcp-purpose">—</span></div>

        <div class="perf" style="margin:14px 0;"></div>

        <!-- Time Details -->
        <div class="receipt-section-label">Schedule</div>
        <div class="receipt-row"><span class="rr-key"><i class="fas fa-hourglass-start"></i>Start</span><span class="rr-val" id="rcp-start">—</span></div>
        <div class="receipt-row"><span class="rr-key"><i class="fas fa-hourglass-end"></i>End</span><span class="rr-val" id="rcp-end">—</span></div>
        <div class="receipt-row"><span class="rr-key"><i class="fas fa-clock"></i>Duration</span><span class="rr-val" id="rcp-duration">—</span></div>

        <div class="perf" style="margin:14px 0;"></div>

        <!-- Booking Code -->
        <div class="receipt-code-section">
          <div class="rcs-code" id="rcp-code">——————</div>
          <div class="rcs-hint">Present this code upon check-in</div>
        </div>

        <!-- Copy button -->
        <button class="receipt-copy-btn" id="rcpCopyBtn">
          <i class="fas fa-copy" id="rcpCopyIcon"></i>
          <span id="rcpCopyText">Copy Booking Code</span>
        </button>

        <!-- Barcode (decorative, generated from code) -->
        <div class="receipt-barcode">
          <div class="barcode-bars" id="barcodeEl"></div>
          <div class="barcode-num" id="barcodeNum">* 000000 *</div>
        </div>

      </div>

      <!-- FOOTER -->
      <div class="receipt-footer">
        <div class="rf-text">
          <strong>Barangay Ermita Court</strong><br>
          This receipt is your booking confirmation.<br>
          Subject to approval by the barangay office.
        </div>
      </div>
    </div>

    <!-- Torn bottom -->
    <div class="receipt-tear-bottom"></div>

    <!-- Actions bar -->
    <div class="receipt-actions">
      <div class="receipt-timer">
        </div>
        <div class="rt-text">
          <center>Copy your code</center>
        </div>
      </div>
      <div class="receipt-action-btns">
        <button class="btn-back" id="receiptBack"><i class="fas fa-arrow-left"></i> Go Back</button>
        <button class="btn-submit" id="receiptSubmit"><i class="fas fa-check"></i> Confirm Now</button>
      </div>
    </div>

  </div>
</div>

<!-- Hidden real form -->
<form action="booking_process.php" method="post" id="realSubmitForm" style="display:none;">
  <input type="hidden" name="date"         id="rs_date">
  <input type="hidden" name="fullname"     id="rs_name">
  <input type="hidden" name="email"        id="rs_email">
  <input type="hidden" name="phonenumber"  id="rs_phone">
  <input type="hidden" name="purpose"      id="rs_purpose">
  <input type="hidden" name="start_time"   id="rs_start">
  <input type="hidden" name="end_time"     id="rs_end">
  <input type="hidden" name="booking_code" id="rs_code">
</form>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

  const bookingModal   = document.getElementById('bookingModal');
  const confirmOverlay = document.getElementById('confirmOverlay');
  const receiptOverlay = document.getElementById('receiptOverlay');
  const closeBooking   = document.getElementById('closeBooking');
  const modalDateLabel = document.getElementById('modalDateLabel');
  const displayDate    = document.getElementById('displayDate');
  const dbDate         = document.getElementById('dbDate');
  const amList         = document.getElementById('amList');
  const pmList         = document.getElementById('pmList');
  const bookingForm    = document.getElementById('bookingForm');
  const realSubmitForm = document.getElementById('realSubmitForm');

  let countdownTimer = null;

  function genCode() { return String(Math.floor(100000 + Math.random() * 900000)); }

  function fmt12(t) {
    if (!t) return '';
    const [h, m] = t.split(':').map(Number);
    const ampm = h >= 12 ? 'PM' : 'AM';
    const h12  = h % 12 || 12;
    return `${h12}:${String(m).padStart(2,'0')} ${ampm}`;
  }

  function calcDuration(start, end) {
    const [sh, sm] = start.split(':').map(Number);
    const [eh, em] = end.split(':').map(Number);
    const mins = (eh * 60 + em) - (sh * 60 + sm);
    const h = Math.floor(mins / 60), m = mins % 60;
    return h > 0 ? `${h}h ${m > 0 ? m + 'm' : ''}`.trim() : `${m}m`;
  }

  function statusClass(s) {
    const map = { pending:'pending', accepted:'accepted', approved:'accepted', rejected:'rejected', declined:'rejected' };
    return map[(s||'').toLowerCase()] || 'pending';
  }

  function buildResList(container, rows, countId) {
    container.innerHTML = '';
    const countEl = countId ? document.getElementById(countId) : null;
    if (!rows.length) {
      container.innerHTML = '<div class="period-empty"><i class="fas fa-calendar-times"></i>No reservations</div>';
      if (countEl) countEl.textContent = '0 booked';
      return;
    }
    if (countEl) countEl.textContent = rows.length + ' booked';
    rows.forEach(r => {
      const card = document.createElement('div');
      card.className = 'res-card';
      card.innerHTML = `
        <div class="rc-time"><i class="fas fa-clock"></i>${r.time}</div>
        <div class="rc-row"><i class="fas fa-user"></i>${r.fullname}</div>
        ${r.email   ? `<div class="rc-row"><i class="fas fa-envelope"></i>${r.email}</div>` : ''}
        ${r.phone   ? `<div class="rc-row"><i class="fas fa-phone"></i>${r.phone}</div>` : ''}
        ${r.purpose ? `<div class="rc-row"><i class="fas fa-tag"></i>${r.purpose}</div>` : ''}
        <span class="rc-status ${statusClass(r.status)}">${r.status || 'Pending'}</span>
      `;
      container.appendChild(card);
    });
  }

  /* barcode generator — decorative */
  function generateBarcode(code) {
    const el  = document.getElementById('barcodeEl');
    const num = document.getElementById('barcodeNum');
    el.innerHTML = '';
    const seed = Array.from(code).reduce((a, c) => a + c.charCodeAt(0), 0);
    const bars = 52;
    for (let i = 0; i < bars; i++) {
      const w = ((seed * (i + 7) * 13) % 3) + 1;
      const h = 20 + ((seed * (i + 3)) % 20);
      const s = document.createElement('span');
      s.style.width  = w + 'px';
      s.style.height = h + 'px';
      el.appendChild(s);
    }
    num.textContent = '* ' + code + ' *';
  }

  /* countdown */
  function startCountdown(onDone) {
    const TOTAL = 15;
    const fill  = document.getElementById('rt-fill');
    const num   = document.getElementById('rt-num');
    const circ  = 2 * Math.PI * 18; // 113.1
    fill.style.strokeDasharray  = circ;
    fill.style.strokeDashoffset = 0;
    fill.style.stroke = '#22c55e';
    num.style.color   = '#fff';
    num.textContent   = TOTAL;
    let remaining = TOTAL;

    if (countdownTimer) clearInterval(countdownTimer);
    countdownTimer = setInterval(function () {
      remaining--;
      num.textContent = remaining;
      fill.style.strokeDashoffset = circ * (1 - remaining / TOTAL);
      if (remaining <= 5) {
        fill.style.stroke = '#ef4444';
        num.style.color   = '#ef4444';
      }
      if (remaining <= 0) {
        clearInterval(countdownTimer);
        onDone();
      }
    }, 1000);
  }

  /* show receipt */
  function showReceipt(data) {
    document.getElementById('rcp-date').textContent    = data.date;
    document.getElementById('rcp-name').textContent    = data.name;
    document.getElementById('rcp-phone').textContent   = data.phone;
    document.getElementById('rcp-email').textContent   = data.email || '—';
    document.getElementById('rcp-purpose').textContent = data.purpose || '—';
    document.getElementById('rcp-start').textContent   = fmt12(data.start);
    document.getElementById('rcp-end').textContent     = fmt12(data.end);
    document.getElementById('rcp-duration').textContent = calcDuration(data.start, data.end);
    document.getElementById('rcp-code').textContent    = data.code;
    generateBarcode(data.code);

    // copy button
    const copyBtn  = document.getElementById('rcpCopyBtn');
    const copyIcon = document.getElementById('rcpCopyIcon');
    const copyText = document.getElementById('rcpCopyText');
    copyBtn.className = 'receipt-copy-btn';
    copyIcon.className = 'fas fa-copy';
    copyText.textContent = 'Copy Booking Code';

    copyBtn.onclick = function () {
      navigator.clipboard.writeText(data.code).catch(() => {
        const ta = document.createElement('textarea');
        ta.value = data.code;
        document.body.appendChild(ta);
        ta.select();
        document.execCommand('copy');
        document.body.removeChild(ta);
      }).finally ? null : null;
      // Always show copied state
      copyBtn.className = 'receipt-copy-btn copied';
      copyIcon.className = 'fas fa-check';
      copyText.textContent = 'Copied!';
      setTimeout(() => {
        copyBtn.className = 'receipt-copy-btn';
        copyIcon.className = 'fas fa-copy';
        copyText.textContent = 'Copy Booking Code';
      }, 2500);
    };

    receiptOverlay.style.display = 'flex';
    startCountdown(() => realSubmitForm.submit());
  }

  /* Calendar */
  const calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
    initialView: 'dayGridMonth',
    showNonCurrentDates: false,
    fixedWeekCount: false,
    events: 'fetch_bookings.php',
    headerToolbar: { left:'prev,next today', center:'title', right:'' },
    dateClick: function (info) {
      dbDate.value = info.dateStr;
      const d = new Date(info.dateStr + 'T00:00:00');
      const label = d.toLocaleDateString('en-US', { weekday:'long', year:'numeric', month:'long', day:'numeric' });
      displayDate.value = label;
      modalDateLabel.textContent = label;

      amList.innerHTML = '<div class="period-empty"><i class="fas fa-spinner fa-spin"></i>Loading…</div>';
      pmList.innerHTML = '<div class="period-empty"><i class="fas fa-spinner fa-spin"></i>Loading…</div>';

      fetch('fetch_bookings.php?date=' + info.dateStr)
        .then(r => r.json())
        .then(rows => {
          buildResList(amList, rows.filter(r => parseInt(r.time.split(':')[0]) < 12), 'amCount');
          buildResList(pmList, rows.filter(r => parseInt(r.time.split(':')[0]) >= 12), 'pmCount');
        })
        .catch(() => {
          amList.innerHTML = '<div class="period-empty"><i class="fas fa-triangle-exclamation"></i>Failed to load</div>';
          pmList.innerHTML = '<div class="period-empty"><i class="fas fa-triangle-exclamation"></i>Failed to load</div>';
        });

      bookingModal.style.display = 'flex';
    }
  });
  calendar.render();

  /* Booking form submit → confirm modal */
  bookingForm.addEventListener('submit', function (e) {
    e.preventDefault();
    const start   = document.getElementById('start_time').value;
    const end     = document.getElementById('end_time').value;
    const name    = document.getElementById('f_name').value.trim();
    const phone   = document.getElementById('f_phone').value.trim();
    const email   = document.getElementById('f_email').value.trim();
    const purpose = document.getElementById('f_purpose').value.trim();
    const dateVal = dbDate.value;

    if (!start || !end)  { alert('Please select both start and end time.'); return; }
    if (start >= end)    { alert('End time must be later than start time.'); return; }
    if (!name || !phone) { alert('Name and phone number are required.'); return; }

    const code = genCode();

    document.getElementById('cf-date-label').textContent = displayDate.value;
    document.getElementById('cf-name').textContent    = name;
    document.getElementById('cf-phone').textContent   = phone;
    document.getElementById('cf-email').textContent   = email || '—';
    document.getElementById('cf-purpose').textContent = purpose || '—';
    document.getElementById('cf-time').textContent    = `${fmt12(start)} – ${fmt12(end)}`;
    document.getElementById('cf-code').textContent    = `#${code}`;

    function buildConfirmList(container, sourceContainer) {
      container.innerHTML = '';
      const cards = sourceContainer.querySelectorAll('.res-card');
      if (!cards.length) { container.innerHTML = '<div class="cf-empty"><i class="fas fa-calendar-times"></i>No bookings</div>'; return; }
      cards.forEach(c => {
        const entry = document.createElement('div');
        entry.className = 'cf-entry';
        const timeEl   = c.querySelector('.rc-time');
        const statusEl = c.querySelector('.rc-status');
        const allRows  = c.querySelectorAll('.rc-row');
        let rows = '';
        allRows.forEach(r => {
          const icon = r.querySelector('i') ? r.querySelector('i').className : 'fas fa-info-circle';
          rows += `<div class="ce-row"><i class="${icon}"></i>${r.textContent.trim()}</div>`;
        });
        const statusTxt = statusEl ? statusEl.textContent.trim() : 'Pending';
        const statusCls = statusEl ? statusEl.className.replace('rc-status','').trim() : 'pending';
        const timeTxt   = timeEl   ? timeEl.textContent.trim() : '';
        entry.innerHTML = `<div class="ce-time"><i class="fas fa-clock"></i>${timeTxt}</div>${rows}<span class="cf-status ${statusCls}">${statusTxt}</span>`;
        container.appendChild(entry);
      });
    }
    buildConfirmList(document.getElementById('cf-am-list'), amList);
    buildConfirmList(document.getElementById('cf-pm-list'), pmList);

    document.getElementById('rs_date').value    = dateVal;
    document.getElementById('rs_name').value    = name;
    document.getElementById('rs_email').value   = email;
    document.getElementById('rs_phone').value   = phone;
    document.getElementById('rs_purpose').value = purpose;
    document.getElementById('rs_start').value   = start;
    document.getElementById('rs_end').value     = end;
    document.getElementById('rs_code').value    = code;

    // Store for receipt
    bookingForm._data = { date: displayDate.value, name, phone, email, purpose, start, end, code };

    confirmOverlay.style.display = 'flex';
  });

  /* Confirm YES → show receipt */
  document.getElementById('confirmYes').addEventListener('click', function () {
    confirmOverlay.style.display = 'none';
    showReceipt(bookingForm._data);
  });

  document.getElementById('confirmNo').addEventListener('click', () => confirmOverlay.style.display = 'none');

  /* Receipt actions */
  document.getElementById('receiptSubmit').addEventListener('click', function () {
    if (countdownTimer) clearInterval(countdownTimer);
    realSubmitForm.submit();
  });

  document.getElementById('receiptBack').addEventListener('click', function () {
    if (countdownTimer) clearInterval(countdownTimer);
    receiptOverlay.style.display = 'none';
    confirmOverlay.style.display = 'flex';
  });

  closeBooking.onclick = () => bookingModal.style.display = 'none';
  window.addEventListener('click', e => {
    if (e.target === bookingModal)   bookingModal.style.display = 'none';
    if (e.target === confirmOverlay) confirmOverlay.style.display = 'none';
  });
});
</script>
</body>
</html>