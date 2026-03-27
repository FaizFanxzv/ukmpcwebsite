<?php
include 'koneksi.php';
include 'auth.php';
requireLogin();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tim Pengembang - Sistem UKMPC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="UKM PC Logos.png">
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #0a0a0f;
            --surface: #111118;
            --card-bg: #16161f;
            --border: rgba(255,255,255,0.06);
            --accent: #5b7cfa;
            --accent2: #a78bfa;
            --accent3: #34d399;
            --text: #e8e8f0;
            --muted: #6b6b80;
            --danger: #f87171;
            --warning: #fbbf24;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'Syne', sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Ambient background */
        body::before {
            content: '';
            position: fixed;
            top: -20%;
            left: -10%;
            width: 60vw;
            height: 60vw;
            background: radial-gradient(circle, rgba(91,124,250,0.07) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }
        body::after {
            content: '';
            position: fixed;
            bottom: -20%;
            right: -10%;
            width: 50vw;
            height: 50vw;
            background: radial-gradient(circle, rgba(167,139,250,0.06) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }

        .page-wrapper {
            position: relative;
            z-index: 1;
            max-width: 1100px;
            margin: 0 auto;
            padding: 48px 24px 80px;
        }

        /* ── TOP NAV ── */
        .top-nav {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 8px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 14px 20px;
            margin-bottom: 56px;
            backdrop-filter: blur(8px);
        }

        .nav-btn {
            font-family: 'Space Mono', monospace;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding: 7px 16px;
            border-radius: 8px;
            border: 1px solid transparent;
            text-decoration: none;
            transition: all 0.2s;
            white-space: nowrap;
        }
        .nav-btn:hover { transform: translateY(-1px); filter: brightness(1.15); }
        .nav-btn.primary   { background: rgba(91,124,250,0.15); border-color: rgba(91,124,250,0.3); color: #7c9cfc; }
        .nav-btn.danger    { background: rgba(248,113,113,0.12); border-color: rgba(248,113,113,0.25); color: var(--danger); }
        .nav-btn.secondary { background: rgba(107,107,128,0.12); border-color: rgba(107,107,128,0.2); color: var(--muted); }
        .nav-btn.success   { background: rgba(52,211,153,0.1); border-color: rgba(52,211,153,0.22); color: var(--accent3); }
        .nav-btn.warning   { background: rgba(251,191,36,0.1); border-color: rgba(251,191,36,0.22); color: var(--warning); }
        .nav-btn.info      { background: rgba(167,139,250,0.12); border-color: rgba(167,139,250,0.25); color: var(--accent2); }
        .nav-btn.active    { background: var(--accent); border-color: var(--accent); color: #fff; }

        /* ── HEADER ── */
        .page-header {
            text-align: center;
            margin-bottom: 64px;
        }

        .header-eyebrow {
            font-family: 'Space Mono', monospace;
            font-size: 11px;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }
        .header-eyebrow::before,
        .header-eyebrow::after {
            content: '';
            display: block;
            width: 40px;
            height: 1px;
            background: var(--accent);
            opacity: 0.5;
        }

        .page-title {
            font-size: clamp(2.2rem, 5vw, 3.4rem);
            font-weight: 800;
            line-height: 1.1;
            letter-spacing: -0.02em;
            background: linear-gradient(135deg, #e8e8f0 30%, var(--accent2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 16px;
        }

        .page-subtitle {
            font-size: 15px;
            color: var(--muted);
            max-width: 440px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* ── TEAM CARDS ── */
        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 28px;
        }

        .member-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 24px;
            overflow: hidden;
            transition: transform 0.3s, border-color 0.3s, box-shadow 0.3s;
            position: relative;
        }
        .member-card:hover {
            transform: translateY(-6px);
            border-color: rgba(91,124,250,0.3);
            box-shadow: 0 24px 60px rgba(0,0,0,0.4), 0 0 0 1px rgba(91,124,250,0.15);
        }

        /* Gradient top strip */
        .member-card::before {
            content: '';
            display: block;
            height: 3px;
            background: linear-gradient(90deg, var(--accent), var(--accent2));
            opacity: 0;
            transition: opacity 0.3s;
        }
        .member-card:hover::before { opacity: 1; }

        .card-photo-wrap {
            position: relative;
            background: linear-gradient(135deg, #1a1a2e, #0f0f1a);
            padding: 36px 36px 0;
            display: flex;
            justify-content: center;
        }

        .card-photo-wrap .orb {
            position: absolute;
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(91,124,250,0.2), transparent 70%);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
        }

        .member-avatar {
            width: 130px;
            height: 130px;
            border-radius: 20px;
            object-fit: cover;
            border: 2px solid var(--border);
            position: relative;
            z-index: 1;
            transition: border-color 0.3s;
        }
        .member-card:hover .member-avatar {
            border-color: rgba(91,124,250,0.4);
        }

        .card-body {
            padding: 28px;
        }

        .member-number {
            font-family: 'Space Mono', monospace;
            font-size: 10px;
            letter-spacing: 0.15em;
            color: var(--accent);
            text-transform: uppercase;
            margin-bottom: 8px;
            opacity: 0.7;
        }

        .member-name {
            font-size: 1.4rem;
            font-weight: 800;
            letter-spacing: -0.01em;
            color: var(--text);
            margin-bottom: 10px;
        }

        .member-prodi {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-family: 'Space Mono', monospace;
            font-size: 11px;
            color: var(--muted);
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 5px 12px;
            margin-bottom: 24px;
        }
        .member-prodi .dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: var(--accent3);
            flex-shrink: 0;
        }

        .member-divider {
            height: 1px;
            background: var(--border);
            margin-bottom: 20px;
        }

        .instagram-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 12px 20px;
            background: rgba(91,124,250,0.1);
            border: 1px solid rgba(91,124,250,0.2);
            color: #7c9cfc;
            border-radius: 12px;
            text-decoration: none;
            font-family: 'Space Mono', monospace;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.05em;
            transition: all 0.25s;
        }
        .instagram-btn:hover {
            background: var(--accent);
            border-color: var(--accent);
            color: #fff;
            box-shadow: 0 8px 24px rgba(91,124,250,0.35);
        }
        .instagram-btn svg {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
        }

        /* ── FOOTER ── */
        .page-footer {
            margin-top: 72px;
            text-align: center;
            font-family: 'Space Mono', monospace;
            font-size: 11px;
            color: var(--muted);
            letter-spacing: 0.05em;
        }

        /* Fade-in animation */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .page-header  { animation: fadeUp 0.5s ease both; }
        .member-card  { animation: fadeUp 0.5s ease both; }
        .member-card:nth-child(1) { animation-delay: 0.1s; }
        .member-card:nth-child(2) { animation-delay: 0.2s; }
        .member-card:nth-child(3) { animation-delay: 0.3s; }
        .member-card:nth-child(4) { animation-delay: 0.4s; }
    </style>
</head>
<body>
<div class="page-wrapper">

    <!-- Navigation -->
    <nav class="top-nav">
        <?php if (hasFullAccess()): ?>
        <a href="user.php"          class="nav-btn danger">Kelola User</a>
        <a href="tambah_anggota.php" class="nav-btn primary">Tambah Anggota</a>
        <a href="tambah_jadwal.php" class="nav-btn secondary">Tambah Jadwal</a>
        <a href="tambah_level.php"  class="nav-btn info">Tambah Kelas</a>
        <a href="tambah_absensi.php" class="nav-btn success">Catat Absensi</a>
        <?php else: ?>
        <a href="anggota.php"       class="nav-btn primary">Daftar Anggota</a>
        <a href="dashboard.php"     class="nav-btn success">Daftar Absensi</a>
        <?php endif; ?>
        <a href="anggota.php"       class="nav-btn warning">Daftar Anggota</a>
        <a href="seleksi.php"       class="nav-btn info">Seleksi Event</a>
        <a href="tim_pengembang.php" class="nav-btn active">Tim Pengembang</a>
        <a href="logout.php"        class="nav-btn secondary" style="margin-left:auto;">
            Logout (<?php echo htmlspecialchars($_SESSION['jabatan']); ?>)
        </a>
    </nav>

    <!-- Header -->
    <header class="page-header">
        <div class="header-eyebrow">UKMPC — Developer Team</div>
        <h1 class="page-title">Tim Pengembang</h1>
        <p class="page-subtitle">Orang-orang di balik layar yang membangun dan menjaga sistem UKMPC tetap berjalan.</p>
    </header>

    <!-- Team Grid -->
    <div class="team-grid">

        <!-- Card 1 -->
        <div class="member-card">
            <div class="card-photo-wrap">
                <div class="orb"></div>
                <img src="aron_photos.jpg"
                     class="member-avatar" alt="Foto Apis">
            </div>
            <div class="card-body">
                <div class="member-number">// Pengembang 1</div>
                <div class="member-name">Fata Favian Cannavaro</div>
                <div class="member-prodi">
                    <span class="dot"></span>
                    Pendidikan teknologi Informasi
                </div>
                <div class="member-prodi">
                    <span class="dot"></span>
                    Atlet & Kepelatihan
                </div>
                <div class="member-divider"></div>
                <a href="https://instagram.com/fatafavian_" class="instagram-btn" target="_blank">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                        <circle cx="12" cy="12" r="4"/>
                        <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/>
                    </svg>
                    @fatafavian_
                </a>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="member-card">
            <div class="card-photo-wrap">
                <div class="orb" style="background: radial-gradient(circle, rgba(167,139,250,0.2), transparent 70%);"></div>
                <img src="FAIZ.png.jpg"
                     class="member-avatar" alt="Foto John Doe">
            </div>
            <div class="card-body">
                <div class="member-number">// Pengembang 2</div>
                <div class="member-name">Muhammad Faiz R R</div>
                <div class="member-prodi">
                    <span class="dot" style="background: var(--accent2);"></span>
                    Pendidikan Teknologi Informasi
                </div>
                <div class="member-prodi">
                    <span class="dot" style="background: var(--accent2);"></span>
                    Atlet & Kepelatihan
                </div>
                <div class="member-divider"></div>
                <a href="https://instagram.com/faizzz_fanxzv_2045" class="instagram-btn" target="_blank"
                   style="background: rgba(167,139,250,0.1); border-color: rgba(167,139,250,0.2); color: var(--accent2);"
                   onmouseover="this.style.background='var(--accent2)';this.style.borderColor='var(--accent2)';this.style.color='#fff';this.style.boxShadow='0 8px 24px rgba(167,139,250,0.35)'"
                   onmouseout="this.style.background='rgba(167,139,250,0.1)';this.style.borderColor='rgba(167,139,250,0.2)';this.style.color='var(--accent2)';this.style.boxShadow=''">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                        <circle cx="12" cy="12" r="4"/>
                        <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/>
                    </svg>
                    @faizzz_fanxzv_2045
                </a>
            </div>
        </div>

    </div>

    <!-- Footer -->
    <footer class="page-footer">
        &copy; <?php echo date('Y'); ?> &nbsp;·&nbsp; UKMPC Developer Team &nbsp;·&nbsp; Built with ♥
    </footer>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
</body>
</html>