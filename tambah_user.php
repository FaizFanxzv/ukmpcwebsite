<?php
include 'koneksi.php';
include 'auth.php';

if (!hasFullAccess()) {
    header('Location: user.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $nama = trim($_POST['nama']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $jabatan = $_POST['jabatan'];

    $stmt = $conn->prepare("INSERT INTO user (username, nama, password, jabatan) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $nama, $password, $jabatan);
    
    if ($stmt->execute()) {
        echo "<script>alert('User berhasil ditambahkan!'); window.location='user.php';</script>";
    } else {
        $error = "Error: " . $stmt->error;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User - UKMPC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="UKM PC Logos.png">
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="page-wrapper">

    <!-- Navigation -->
    <nav class="top-nav">
        <a href="user.php" class="nav-btn danger">Kelola User</a>
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
        <div class="header-eyebrow">UKMPC — Admin</div>
        <h1 class="page-title">Tambah User</h1>
        <p class="page-subtitle">Buat akun pengguna baru untuk sistem UKMPC. (Admin Only)</p>
    </header>

    <!-- Form Section -->
    <?php if ($error): ?>
    <div style="background: rgba(248,113,113,0.15); border:1px solid rgba(248,113,113,0.3); border-radius:16px; padding:20px; margin-bottom:32px; color: var(--danger);">
        <?php echo htmlspecialchars($error); ?>
    </div>
    <?php endif; ?>

    <section class="form-section">
        <form method="POST">
            <label class="form-label" for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>

            <label class="form-label" for="nama">Nama Lengkap</label>
            <input type="text" class="form-control" id="nama" name="nama" required>

            <label class="form-label" for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>

            <label class="form-label" for="jabatan">Jabatan</label>
            <select class="form-select" id="jabatan" name="jabatan" required>
                <option value="">Pilih Jabatan</option>
                <option value="BPH">BPH</option>
                <option value="AK">AK</option>
                <option value="Anggota">Anggota</option>
                <option value="KOMINFO">KOMINFO</option>
                <option value="PSDU">PSDU</option>
            </select>

            <div style="display:flex; gap:16px; margin-top:32px;">
                <a href="user.php" class="btn-modern secondary" style="flex:1;">Batal</a>
                <button type="submit" class="btn-modern primary" style="flex:2;">Tambah User</button>
            </div>
        </form>
    </section>

    <!-- Footer -->
    <footer class="page-footer">
        &copy; <?php echo date('Y'); ?> &nbsp;·&nbsp; UKMPC User Creation &nbsp;·&nbsp; Secure Admin Panel
    </footer>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
</body>
</html>

