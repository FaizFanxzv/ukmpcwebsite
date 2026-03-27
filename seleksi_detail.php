<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'koneksi.php';
include 'auth.php';
requireLogin();

if (!isset($_GET['id_event']) || !is_numeric($_GET['id_event'])) {
    echo "<script>alert('ID Event tidak valid!'); window.location='seleksi.php';</script>";
    exit;
}
$id_event = intval($_GET['id_event']);

// Cek event exists
$event_check = $conn->prepare("SELECT nama_event FROM event WHERE id_event = ?");
$event_check->bind_param("i", $id_event);
$event_check->execute();
$event_result = $event_check->get_result();
if ($event_result->num_rows == 0) {
    echo "<script>alert('Event tidak ditemukan!'); window.location='seleksi.php';</script>";
    exit;
}
$event = $event_result->fetch_assoc();

// List seleksi for this event
$search = trim($_GET['search'] ?? '');

$sql = "SELECT s.id_seleksi, s.anggota, a.Nama, a.Prodi 
        FROM seleksi s 
        INNER JOIN anggota a ON s.anggota = a.NIM 
        WHERE s.event = ?";
$params = [$id_event];
$types = 'i';
if (!empty($search)) {
    $sql .= " AND (a.Nama LIKE ? OR a.Prodi LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $types .= 'ss';
}

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleksi <?php echo htmlspecialchars($event['nama_event']); ?> - UKMPC</title>
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
        <div class="header-eyebrow">UKMPC — Seleksi Detail</div>
        <h1 class="page-title">Seleksi Anggota<br><span style="font-weight:600; font-size:0.65em; color: var(--accent); letter-spacing:0.1em; text-transform:uppercase;"><?php echo htmlspecialchars($event['nama_event']); ?></span></h1>
        <p class="page-subtitle">Anggota yang terdaftar untuk seleksi event ini.<?php if (!empty($search)): ?> Hasil pencarian "<?php echo htmlspecialchars($search); ?>"<?php endif; ?></p>
    </header>

    <!-- Search & Actions -->
    <section class="search-section">
        <form method="GET">
            <input type="hidden" name="id_event" value="<?php echo $id_event; ?>">
            <input type="text" class="search-input" name="search" placeholder="Cari nama atau prodi..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="nav-btn primary">Cari</button>
            <?php if (!empty($search)): ?>
            <a href="?id_event=<?php echo $id_event; ?>" class="nav-btn secondary">Reset</a>
            <?php endif; ?>
        </form>
        <?php if (hasFullAccess()): ?>
        <a href="tambah_seleksi.php?id_event=<?php echo $id_event; ?>" class="nav-btn primary">Tambah Seleksi</a>
        <?php endif; ?>
        <a href="seleksi.php" class="nav-btn secondary">← Daftar Event</a>
    </section>

    <!-- Table -->
    <?php if ($result->num_rows > 0): ?>
    <div class="data-table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID Seleksi</th>
                    <th>NIM</th>
                    <th>Nama Anggota</th>
                    <th>Prodi</th>
                    <?php if (hasFullAccess()): ?>
                    <th>Aksi</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><strong>#<?php echo $row['id_seleksi']; ?></strong></td>
                    <td><?php echo htmlspecialchars($row['anggota']); ?></td>
                    <td><?php echo htmlspecialchars($row['Nama']); ?></td>
                    <td><?php echo htmlspecialchars($row['Prodi']); ?></td>
                    <?php if (hasFullAccess()): ?>
                    <td>
                        <form method="POST" action="hapus_seleksi.php" style="display:inline;" onsubmit="return confirm('Yakin hapus?');">
                            <input type="hidden" name="id_seleksi" value="<?php echo $row['id_seleksi']; ?>">
                            <button type="submit" class="nav-btn danger btn-action" style="font-size:10px;padding:4px 8px;">Hapus</button>
                        </form>
                    </td>
                    <?php endif; ?>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <div style="text-align:center; padding: 80px 32px; background: var(--card-bg); border:1px solid var(--border); border-radius:24px; color: var(--muted);">
        <h3 style="font-size:2.2rem; margin-bottom:16px; color: var(--text);">Tidak ada data seleksi</h3>
        <p>Belum ada anggota yang terdaftar untuk event ini.</p>
        <?php if (hasFullAccess()): ?>
        <a href="tambah_seleksi.php?id_event=<?php echo $id_event; ?>" class="nav-btn primary" style="font-size:14px; padding:14px 32px; margin-top:24px;">Tambah Seleksi Sekarang</a>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <!-- Footer -->
    <footer class="page-footer">
        &copy; <?php echo date('Y'); ?> &nbsp;·&nbsp; UKMPC Seleksi Detail &nbsp;·&nbsp; Event #<?php echo $id_event; ?>
    </footer>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
</body>
</html>

