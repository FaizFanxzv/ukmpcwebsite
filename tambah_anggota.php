<?php
include 'koneksi.php';
include 'auth.php';

if (!hasFullAccess()) {
    header('Location: anggota.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nim = $_POST['NIM'];
    $nama = $_POST['nama'];
    $prodi = $_POST['prodi'];
    $no_telp = $_POST['no_telp'];
    $level_id = $_POST['level_id'];
    $poin = 0;

    $sql = "INSERT INTO anggota (NIM, Nama, Prodi, No_Telp, Level, Poin) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssisi", $nim, $nama, $prodi, $no_telp, $level_id, $poin);
    if ($stmt->execute()) {
        echo "<script>alert('Anggota berhasil ditambahkan!'); window.location='anggota.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Query untuk dropdown level
$levels = $conn->query("SELECT * FROM level");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Anggota - UKMPC</title>
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
        <a href="tambah_anggota.php" class="nav-btn primary active">Tambah Anggota</a>
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
        <div class="header-eyebrow">UKMPC — Members</div>
        <h1 class="page-title">Tambah Anggota</h1>
        <p class="page-subtitle">Daftarkan anggota baru ke sistem UKMPC. Poin dimulai dari 0. (Admin Only)</p>
    </header>

    <!-- Form Section -->
    <section class="form-section">
        <form method="POST">
            <label class="form-label" for="NIM">NIM</label>
            <input type="text" class="form-control" id="NIM" name="NIM" placeholder="Masukkan NIM mahasiswa" required>

            <label class="form-label" for="nama">Nama Lengkap</label>
            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama lengkap anggota" required>

            <label class="form-label" for="prodi">Program Studi</label>
            <input type="text" class="form-control" id="prodi" name="prodi" placeholder="Contoh: Teknik Informatika" required>

            <label class="form-label" for="no_telp">Nomor Telepon</label>
            <input type="tel" class="form-control" id="no_telp" name="no_telp" placeholder="08xxxxxxxxxx" required>

            <label class="form-label" for="level_id">Level / Kelas</label>
            <select class="form-select" id="level_id" name="level_id" required>
                <option value="" selected>Pilih Kelas</option>
                <?php while ($level = $levels->fetch_assoc()): ?>
                    <option value="<?php echo $level['Id_Level']; ?>"><?php echo htmlspecialchars($level['Nama_Level']); ?></option>
                <?php endwhile; ?>
            </select>

            <label class="form-label" for="poin">Poin Awal</label>
            <input type="number" class="form-control" id="poin" name="poin" value="0" readonly style="background: var(--surface); color: var(--muted);">

            <div style="display:flex; gap:16px; margin-top:40px;">
                <a href="anggota.php" class="btn-modern secondary" style="flex:1;">Batal</a>
                <button type="submit" class="btn-modern primary" style="flex:2;">Tambah Anggota</button>
            </div>
        </form>
    </section>

    <!-- Footer -->
    <footer class="page-footer">
        &copy; <?php echo date('Y'); ?> &nbsp;·&nbsp; UKMPC Member Registration &nbsp;·&nbsp; Admin Panel
    </footer>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
</body>
</html>

