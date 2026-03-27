<?php
include 'koneksi.php';
include 'auth.php';
requireLogin();

if (!isset($_GET['id_event']) || !is_numeric($_GET['id_event'])) {
    header('Location: seleksi.php');
    exit;
}

$id_event = $_GET['id_event'];

// Ambil detail event
$event_sql = $conn->prepare("SELECT nama_event, syarat_poin FROM event WHERE id_event = ?");
$event_sql->bind_param("i", $id_event);
$event_sql->execute();
$event_result = $event_sql->get_result();

if ($event_result->num_rows == 0) {
    echo "<script>alert('Event tidak ditemukan!'); window.location='seleksi.php';</script>";
    exit;
}

$event = $event_result->fetch_assoc();
$syarat_poin = intval($event['syarat_poin']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nim = $_POST['nim'];

    // Cek duplikasi
    $check_dup = $conn->prepare("SELECT id_seleksi FROM seleksi WHERE event = ? AND anggota = ?");
    $check_dup->bind_param("is", $id_event, $nim);
    $check_dup->execute();
    
    if ($check_dup->get_result()->num_rows > 0) {
        echo "<script>alert('Anggota sudah terdaftar di seleksi event ini!'); </script>";
    } else {
        $insert_sql = $conn->prepare("INSERT INTO seleksi (event, anggota) VALUES (?, ?)");
        $insert_sql->bind_param("is", $id_event, $nim);
        if ($insert_sql->execute()) {
            echo "<script>alert('Berhasil didaftarkan!'); window.location='seleksi_detail.php?id_event=$id_event';</script>";
        }
    }
}

// Ambil list anggota yang memenuhi syarat poin
$anggota = $conn->query("SELECT NIM, Nama, Poin FROM anggota WHERE Poin >= $syarat_poin ORDER BY Nama");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Seleksi - UKMPC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="UKM PC Logos.png">
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="page-wrapper">
    <nav class="top-nav">
        <a href="dashboard.php" class="nav-btn secondary">Dashboard</a>
        <a href="anggota.php" class="nav-btn primary">Anggota</a>
        <a href="seleksi.php" class="nav-btn info active">Seleksi Event</a>
        <a href="logout.php" class="nav-btn secondary" style="margin-left:auto;">Logout</a>
    </nav>

    <header class="page-header">
        <div class="header-eyebrow">Selection Process — <?php echo htmlspecialchars($event['nama_event']); ?></div>
        <h1 class="page-title">Tambah Seleksi</h1>
        <p class="page-subtitle">Hanya anggota dengan minimal <strong><?php echo $syarat_poin; ?> poin</strong> yang muncul dalam daftar ini.</p>
    </header>

    <section class="form-section">
        <form method="POST">
            <label class="form-label" for="nim">Pilih Anggota Berkualifikasi</label>
            <select class="form-select" id="nim" name="nim" required>
                <option value="">-- Pilih Anggota --</option>
                <?php while ($a = $anggota->fetch_assoc()): ?>
                    <option value="<?php echo $a['NIM']; ?>">
                        <?php echo htmlspecialchars($a['Nama']); ?> (Poin: <?php echo $a['Poin']; ?>)
                    </option>
                <?php endwhile; ?>
            </select>

            <div style="display:flex; gap:16px; margin-top:40px;">
                <a href="seleksi_detail.php?id_event=<?php echo $id_event; ?>" class="btn-modern secondary" style="flex:1;">Kembali</a>
                <button type="submit" class="btn-modern primary" style="flex:2;">Daftarkan Seleksi</button>
            </div>
        </form>
    </section>

    <footer class="page-footer">
        &copy; <?php echo date('Y'); ?> &nbsp;·&nbsp; UKMPC Event Selection System
    </footer>
</div>
</body>
</html>