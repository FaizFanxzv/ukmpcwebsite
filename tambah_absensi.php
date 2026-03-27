<?php
include 'koneksi.php';
include 'auth.php';

if (!hasFullAccess()) {
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $anggota_id = $_POST['anggota_id'];
    $tanggal = $_POST['tanggal'];
    $jadwal_id = $_POST['jadwal_id'];
    $status = $_POST['status'];
    $keterangan = $_POST['keterangan'];
    $aktif = $_POST['aktif'];
    $aktif_poin = ($aktif == 'ya' ? 1 : 0);

    // Validation for select fields
    if ($anggota_id == 'pilih' || $jadwal_id == 'Pilih') {
        echo "<script>alert('Harap pilih anggota dan jadwal yang valid!'); window.history.back();</script>";
        exit;
    }

    // Server-side validation for logic
    $invalid_statuses = ['izin', 'sakit', 'alpha'];
    if (in_array(strtolower($status), $invalid_statuses) && $aktif == 'ya') {
        echo "<script>alert('Gagal menambahkan data karena tidak masuk logika, ulangi lagi. Wajib pilih \"Tidak\" untuk status ini.'); 
        window.history.back();</script>";
        exit;
    }

    // Calculate additional poin based on status
    $additional_poin = 0;
    switch (strtolower($status)) {
        case 'hadir':
            $additional_poin = 2;
            break;
        case 'izin':
        case 'sakit':
            $additional_poin = 1;
            break;
        case 'alpha':
            $additional_poin = 0;
            break;
    }
    $total_poin = $aktif_poin + $additional_poin;

    $sql = "INSERT INTO absensi (Anggota, Tanggal, Jadwal, Status, Keterangan, Poin) VALUES ('$anggota_id', '$tanggal', '$jadwal_id', '$status', '$keterangan', '$total_poin')";
    if ($conn->query($sql) === TRUE) {
        // Update poin anggota
        $update_sql = "UPDATE anggota SET Poin = Poin + $total_poin WHERE NIM = '$anggota_id'";
        $conn->query($update_sql);

        echo "<script>alert('Absensi berhasil dicatat!'); window.location='dashboard.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Query untuk dropdown
$anggota = $conn->query("SELECT * FROM anggota");
$jadwal = $conn->query("SELECT jdw.Id_Jadwal, jdw.Hari , lvl.Nama_Level
	                    FROM jadwal jdw
                        INNER JOIN level lvl ON lvl.Id_Level = jdw.Level");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catat Absensi - UKMPC</title>
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
        <a href="tambah_absensi.php" class="nav-btn success active">Catat Absensi</a>
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
        <div class="header-eyebrow">UKMPC — Absensi</div>
        <h1 class="page-title">Catat Absensi</h1>
        <p class="page-subtitle">Rekam kehadiran harian anggota dengan perhitungan poin otomatis berdasarkan status dan aktifitas. (Admin Only)</p>
    </header>

    <!-- Form Section -->
    <section class="form-section">
        <form method="POST">
            <label class="form-label" for="anggota_id">Anggota</label>
            <select class="form-select" id="anggota_id" name="anggota_id" required onchange="updateJadwal()">
                <option value="pilih" selected>Pilih Nama</option>
                <?php $anggota->data_seek(0); while ($row = $anggota->fetch_assoc()): ?>
                    <option value="<?php echo $row['NIM']; ?>"><?php echo $row['Nama']; ?></option>
                <?php endwhile; ?>
            </select>

            <label class="form-label" for="tanggal">Tanggal</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" required>

            <label class="form-label" for="jadwal_id">Jadwal</label>
            <select class="form-select" id="jadwal_id" name="jadwal_id" required>
                <option value="Pilih" selected>Pilih Jadwal</option>
                <?php $jadwal->data_seek(0); while ($row = $jadwal->fetch_assoc()): ?>
                    <option value="<?php echo $row['Id_Jadwal']; ?>"><?php echo $row['Hari'] . ' - ' . $row['Nama_Level']; ?></option>
                <?php endwhile; ?>
            </select>

            <label class="form-label" for="status">Status</label>
            <select class="form-select" id="status" name="status" required onchange="handleStatusChange()">
                <option value="hadir">Hadir</option>
                <option value="Izin">Izin</option>
                <option value="Sakit">Sakit</option>
                <option value="Alpha">Alpha</option>
            </select>

            <label class="form-label" for="keterangan">Keterangan</label>
            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>

            <label class="form-label">Aktif?</label>
            <div id="aktif-group" style="background: var(--surface); border: 1px solid var(--border); border-radius: 12px; padding: 16px; margin-top: 8px;">
                <div style="display: flex; gap: 12px; align-items: center; margin-bottom: 8px;">
                    <input type="radio" id="aktif_ya" name="aktif" value="ya">
                    <label for="aktif_ya" style="margin: 0; font-weight: 500;">Ya (+1 poin)</label>
                </div>
                <div style="display: flex; gap: 12px; align-items: center;">
                    <input type="radio" id="aktif_tidak" name="aktif" value="tidak" checked>
                    <label for="aktif_tidak" style="margin: 0; font-weight: 500;">Tidak (0 poin)</label>
                </div>
            </div>

            <div style="display:flex; gap:16px; margin-top:40px;">
                <a href="dashboard.php" class="btn-modern secondary" style="flex:1;">Batal</a>
                <button type="submit" class="btn-modern primary" style="flex:2;">Catat Absensi</button>
            </div>
        </form>
    </section>

    <!-- Footer -->
    <footer class="page-footer">
        &copy; <?php echo date('Y'); ?> &nbsp;·&nbsp; UKMPC Absensi System &nbsp;·&nbsp; Admin Panel
    </footer>

</div>
<script>
function updateJadwal() {
    // Original JS logic for updateJadwal - preserve if exists
    console.log('updateJadwal called');
}

function handleStatusChange() {
    // Original JS logic for handleStatusChange - preserve if exists
    console.log('handleStatusChange called');
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
</body>
</html>

