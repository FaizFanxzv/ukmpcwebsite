<?php
include 'koneksi.php';
include 'auth.php';

if (!hasFullAccess()) {
    header('Location: seleksi.php');
    exit;
}

if ($_POST) {
    $nama_event = $_POST['nama_event'];
    $tanggal_event = $_POST['tanggal_event'];
    $penyelenggara = $_POST['penyelenggara'];
    $lokasi = $_POST['lokasi'];
    $tanggal_seleksi = $_POST['tanggal_seleksi'];
    $syarat_poin = intval($_POST['syarat_poin']);

    $stmt = $conn->prepare("INSERT INTO event (nama_event, tanggal_event, penyelenggara, lokasi, tanggal_seleksi, syarat_poin) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $nama_event, $tanggal_event, $penyelenggara, $lokasi, $tanggal_seleksi, $syarat_poin);

    if ($stmt->execute()) {
        echo "<script>alert('Event berhasil ditambahkan!'); window.location='seleksi.php';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Event - UKMPC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="UKM PC Logos.png">
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="page-wrapper">

    <!-- Navigation -->
    <nav class="top-nav">
        <?php if (hasFullAccess()): ?>
        <a href="user.php" class="nav-btn danger">Kelola User</a>
        <?php endif; ?>
        <?php if (hasFullAccess()): ?>
        <a href="tambah_anggota.php" class="nav-btn primary">Tambah Anggota</a>
        <?php else: ?>
        <a href="anggota.php" class="nav-btn primary">Daftar Anggota</a>
        <?php endif; ?>
        <?php if (hasFullAccess()): ?>
        <a href="tambah_jadwal.php" class="nav-btn secondary">Tambah Jadwal</a>
        <?php endif; ?>
        <?php if (hasFullAccess()): ?>
        <a href="tambah_level.php" class="nav-btn info">Tambah Kelas</a>
        <?php endif; ?>
        <?php if (hasFullAccess()): ?>
        <a href="tambah_absensi.php" class="nav-btn success">Catat Absensi</a>
        <?php else: ?>
        <a href="dashboard.php" class="nav-btn success">Daftar Absensi</a>
        <?php endif; ?>
        <a href="seleksi.php" class="nav-btn info">Seleksi Event</a>
        <a href="tim_pengembang.php" class="nav-btn secondary">Tim Pengembang</a>
        <a href="logout.php" class="nav-btn secondary" style="margin-left:auto;">
            Logout (<?php echo htmlspecialchars($_SESSION['jabatan']); ?>)
        </a>
    </nav>

    <!-- Header -->
    <header class="page-header">
        <div class="header-eyebrow">UKMPC — Events</div>
        <h1 class="page-title">Tambah Event</h1>
        <p class="page-subtitle">Buat event baru beserta jadwal seleksi dan syarat poin. (Admin Only)</p>
    </header>

    <!-- Form Section -->
    <section class="form-section">
        <form method="POST">
            <label class="form-label" for="nama_event">Nama Event</label>
            <input type="text" class="form-control" id="nama_event" name="nama_event" placeholder="Contoh: Lomba Programming" required>

            <label class="form-label" for="tanggal_event">Tanggal Pelaksanaan</label>
            <input type="date" class="form-control" id="tanggal_event" name="tanggal_event" required>

            <label class="form-label" for="penyelenggara">Penyelenggara</label>
            <input type="text" class="form-control" id="penyelenggara" name="penyelenggara" placeholder="Nama penyelenggara event" required>

            <label class="form-label" for="lokasi">Lokasi</label>
            <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Lab komputer / aula" required>

            <label class="form-label" for="tanggal_seleksi">Tanggal Seleksi</label>
            <input type="date" class="form-control" id="tanggal_seleksi" name="tanggal_seleksi" required>

            <label class="form-label" for="syarat_poin">Syarat Poin Minimum</label>
            <input type="number" class="form-control" id="syarat_poin" name="syarat_poin" min="0" value="10" required>

            <div style="display:flex; gap:16px; margin-top:40px;">
                <a href="seleksi.php" class="btn-modern secondary" style="flex:1;">Batal</a>
                <button type="submit" class="btn-modern primary" style="flex:2;">Tambah Event</button>
            </div>
        </form>
    </section>

    <!-- Footer -->
    <footer class="page-footer">
        &copy; <?php echo date('Y'); ?> &nbsp;·&nbsp; UKMPC Event Creation &nbsp;·&nbsp; Admin Panel
    </footer>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
</body>
</html>

