<?php
include 'koneksi.php';
include 'auth.php';
requireLogin();

$search = trim($_GET['search'] ?? '');

// Query untuk menampilkan semua event
$sql = "SELECT * FROM event";

$params = [];
$types = '';
if (!empty($search)) {
    $sql .= " WHERE (nama_event LIKE ? OR penyelenggara LIKE ?)";
    $params = ["%$search%", "%$search%"];
    $types = 'ss';
}

$sql .= " ORDER BY tanggal_event DESC";

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleksi Event - UKMPC</title>
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
        <a href="seleksi.php" class="nav-btn info active">Seleksi Event</a>
        <a href="tim_pengembang.php" class="nav-btn secondary">Tim Pengembang</a>
        <a href="logout.php" class="nav-btn secondary" style="margin-left:auto;">
            Logout (<?php echo htmlspecialchars($_SESSION['jabatan']); ?>)
        </a>
    </nav>

    <!-- Header -->
    <header class="page-header">
        <div class="header-eyebrow">UKMPC — Events</div>
        <h1 class="page-title">Seleksi Event<?php if (!empty($search)): ?> - "<?php echo htmlspecialchars($search); ?>"<?php endif; ?></h1>
        <p class="page-subtitle">Daftar event dan seleksi dengan syarat poin minimum.</p>
    </header>

    <!-- Search & Actions -->
    <section class="search-section">
        <form method="GET">
            <input type="text" class="search-input" name="search" placeholder="Cari nama event, penyelenggara..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="nav-btn primary">Cari</button>
            <?php if (!empty($search)): ?>
            <a href="seleksi.php" class="nav-btn secondary">Reset</a>
            <?php endif; ?>
        </form>
        <?php if (hasFullAccess()): ?>
        <a href="tambah_event.php" class="nav-btn primary">Tambah Event</a>
        <?php endif; ?>
    </section>

    <?php if ($result->num_rows > 0): ?>
    <!-- Table -->
    <div class="data-table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nama Event</th>
                    <th>Tanggal Event</th>
                    <th>Penyelenggara</th>
                    <th>Lokasi</th>
                    <th>Tanggal Seleksi</th>
                    <th>Syarat Poin</th>
                    <?php if (hasFullAccess()): ?>
                    <th>Aksi</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($row['nama_event']); ?></strong></td>
                        <td><?php echo htmlspecialchars($row['tanggal_event']); ?></td>
                        <td><?php echo htmlspecialchars($row['penyelenggara']); ?></td>
                        <td><?php echo htmlspecialchars($row['lokasi']); ?></td>
                        <td><?php echo htmlspecialchars($row['tanggal_seleksi']); ?></td>
                        <td><strong style="color: var(--warning);"><?php echo htmlspecialchars($row['syarat_poin']); ?></strong></td>
                        <td>
                            <a href="seleksi_detail.php?id_event=<?php echo $row['id_event']; ?>" class="nav-btn info btn-action">Lihat Seleksi</a>
                            <?php if (hasFullAccess()): ?>
                            <a href="edit_event.php?id=<?php echo $row['id_event']; ?>" class="nav-btn warning btn-action">Edit</a>
                            <a href="hapus_event.php?id=<?php echo $row['id_event']; ?>" class="nav-btn danger btn-action" onclick="return confirm('Yakin hapus event ini?')">Hapus</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <div style="text-align:center; padding: 64px 32px; color: var(--muted);">
        <h3 style="font-size:2rem; margin-bottom:16px; color: var(--text);">Belum ada data event</h3>
        <p>Event pertama dapat ditambahkan oleh admin.</p>
        <?php if (hasFullAccess()): ?>
        <a href="tambah_event.php" class="nav-btn primary" style="font-size:14px; padding:12px 24px;">Tambah Event Pertama</a>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <!-- Footer -->
    <footer class="page-footer">
        &copy; <?php echo date('Y'); ?> &nbsp;·&nbsp; UKMPC Event Seleksi &nbsp;·&nbsp; Built with ♥
    </footer>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
</body>
</html>

