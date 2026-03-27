<?php
include 'koneksi.php';
include 'auth.php';

if (!hasFullAccess()) {
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hari = $_POST['hari'];
    $level = $_POST['level_id'];

    $sql = "INSERT INTO jadwal (Hari, Level) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $hari, $level);
    
    if ($stmt->execute()) {
        echo "<script>alert('Jadwal berhasil ditambahkan!'); window.location='dashboard.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}

$levels = $conn->query("SELECT * FROM level");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Jadwal - UKMPC</title>
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
        <a href="tambah_jadwal.php" class="nav-btn secondary active">Tambah Jadwal</a>
        <a href="tambah_level.php" class="nav-btn info">Tambah Kelas</a>
        <a href="tambah_absensi.php" class="nav-btn success">Catat Absensi</a>
        <a href="seleksi.php" class="nav-btn info">Seleksi Event</a>
        <a href="logout.php" class="nav-btn secondary" style="margin-left:auto;">Logout</a>
    </nav>

    <header class="page-header">
        <div class="header-eyebrow">UKMPC — Schedules</div>
        <h1 class="page-title">Tambah Jadwal</h1>
        <p class="page-subtitle">Atur jadwal latihan rutin untuk setiap level/kelas yang tersedia.</p>
    </header>

    <section class="form-section">
        <form method="POST">
            <label class="form-label" for="hari">Hari</label>
            <select name="hari" id="hari" class="form-select" required>
                <option value="" selected>Pilih Hari</option>
                <option value="Senin">Senin</option>
                <option value="Selasa">Selasa</option>
                <option value="Rabu">Rabu</option>
                <option value="Kamis">Kamis</option>
                <option value="Jumat">Jumat</option>
                <option value="Sabtu">Sabtu</option>
                <option value="Minggu">Minggu</option>
            </select>

            <label class="form-label" for="level_id" style="margin-top:20px;">Level / Kelas</label>
            <select class="form-select" id="level_id" name="level_id" required>
                <option value="" selected>Pilih Kelas</option>
                <?php while ($lvl = $levels->fetch_assoc()): ?>
                    <option value="<?php echo $lvl['Id_Level']; ?>"><?php echo htmlspecialchars($lvl['Nama_Level']); ?></option>
                <?php endwhile; ?>
            </select>

            <div style="display:flex; gap:16px; margin-top:40px;">
                <a href="dashboard.php" class="btn-modern secondary" style="flex:1;">Batal</a>
                <button type="submit" class="btn-modern primary" style="flex:2;">Simpan Jadwal</button>
            </div>
        </form>
    </section>

    <footer class="page-footer">
        &copy; <?php echo date('Y'); ?> &nbsp;·&nbsp; UKMPC Schedule Management
    </footer>
</div>
</body>
</html>