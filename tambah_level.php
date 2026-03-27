<?php
include 'koneksi.php';
include 'auth.php';

if (!hasFullAccess()) {
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_level = $_POST['Nama_Kelas'];

    $sql = "INSERT INTO level (Nama_Level) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nama_level);
    
    if ($stmt->execute()) {
        echo "<script>alert('Level berhasil ditambahkan!'); window.location='dashboard.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Level - UKMPC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="UKM PC Logos.png">
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="page-wrapper">
    <nav class="top-nav">
        <?php if (hasFullAccess()): ?>
        <a href="user.php" class="nav-btn danger">Kelola User</a>
        <?php endif; ?>
        <a href="tambah_anggota.php" class="nav-btn primary">Tambah Anggota</a>
        <a href="tambah_jadwal.php" class="nav-btn secondary">Tambah Jadwal</a>
        <a href="tambah_level.php" class="nav-btn info active">Tambah Kelas</a>
        <a href="tambah_absensi.php" class="nav-btn success">Catat Absensi</a>
        <a href="seleksi.php" class="nav-btn info">Seleksi Event</a>
        <a href="logout.php" class="nav-btn secondary" style="margin-left:auto;">Logout</a>
    </nav>

    <header class="page-header">
        <div class="header-eyebrow">UKMPC — Kela    s</div>
        <h1 class="page-title">Tambah Kelas</h1>
        <p class="page-subtitle">Buat tingkatan atau kategori kelas baru untuk klasifikasi anggota.</p>
    </header>

    <section class="form-section">
        <form method="POST">
            <label class="form-label" for="Nama_Kelas">Nama Kelas / Level</label>
            <input type="text" class="form-control" id="Nama_Kelas" name="Nama_Kelas" placeholder="Contoh: Basic, Intermediate, Expert" required>

            <div style="display:flex; gap:16px; margin-top:40px;">
                <a href="dashboard.php" class="btn-modern secondary" style="flex:1;">Batal</a>
                <button type="submit" class="btn-modern primary" style="flex:2;">Simpan Kelas</button>
            </div>
        </form>
    </section>

    <footer class="page-footer">
        &copy; <?php echo date('Y'); ?> &nbsp;·&nbsp; UKMPC Level System
    </footer>
</div>
</body>
</html>