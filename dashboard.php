<?php
include 'koneksi.php';
include 'auth.php';
requireLogin();

$search = trim($_GET['search'] ?? '');

$sql = "SELECT absen.Id_Absensi, absen.Tanggal , jdw.Hari , angg.Nama, lvl.Nama_Level, absen.Status, absen.Keterangan, absen.Poin
        FROM absensi absen
        INNER JOIN anggota angg ON absen.Anggota = angg.NIM
        INNER JOIN jadwal jdw ON absen.Jadwal = jdw.Id_Jadwal
        INNER JOIN level lvl ON angg.Level = lvl.id_level";

$params = [];
$types = '';
if (!empty($search)) {
    $sql .= " WHERE (angg.Nama LIKE ? OR absen.Status LIKE ? OR absen.Keterangan LIKE ?)";
    $params = ["%$search%", "%$search%", "%$search%"];
    $types = 'sss';
}

$sql .= " ORDER BY absen.Tanggal DESC";

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
    <title>Daftar Absensi - UKMPC</title>
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
        <a href="dashboard.php" class="nav-btn active success">Daftar Absensi</a>
        <?php endif; ?>
        <a href="anggota.php" class="nav-btn warning">Daftar Anggota</a>
        <a href="seleksi.php" class="nav-btn info">Seleksi Event</a>
        <a href="tim_pengembang.php" class="nav-btn secondary">Tim Pengembang</a>
        <a href="logout.php" class="nav-btn secondary" style="margin-left:auto;">
            Logout (<?php echo htmlspecialchars($_SESSION['jabatan']); ?>)
        </a>
    </nav>

    <!-- Header -->
    <header class="page-header">
        <div class="header-eyebrow">UKMPC — Absensi</div>
        <h1 class="page-title">Daftar Absensi<?php if (!empty($search)): ?> <span style="font-weight:400;">— "<?php echo htmlspecialchars($search); ?>"</span><?php endif; ?></h1>
        <p class="page-subtitle">Riwayat lengkap kehadiran anggota dengan detail hari, status, dan poin.</p>
    </header>

    <!-- Search -->
    <section class="search-section">
        <form method="GET">
            <input type="text" class="search-input" name="search" placeholder="Cari nama, status, atau keterangan..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="nav-btn primary">Cari</button>
            <?php if (!empty($search)): ?>
            <a href="dashboard.php" class="nav-btn secondary">Reset</a>
            <?php endif; ?>
        </form>
    </section>

    <!-- Data Table -->
    <div class="data-table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Hari</th>
                    <th>Nama Anggota</th>
                    <th>Level</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th>Poin</th>
                    <?php if (hasFullAccess()): ?>
                    <th>Aksi</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['Tanggal']); ?></td>
                        <td><?php echo htmlspecialchars($row['Hari']); ?></td>
                        <td><?php echo htmlspecialchars($row['Nama']); ?></td>
                        <td><?php echo htmlspecialchars($row['Nama_Level']); ?></td>
                        <td><span style="background: rgba(52,211,153,0.2); padding:4px 12px; border-radius:20px; font-size:12px; font-weight:600; color: var(--accent3);"><?php echo htmlspecialchars($row['Status']); ?></span></td>
                        <td><?php echo htmlspecialchars($row['Keterangan']); ?></td>
                        <td><strong style="color: var(--accent3);"><?php echo $row['Poin']; ?></strong></td>
                        <?php if (hasFullAccess()): ?>
                        <td>
                            <a href="edit_absensi.php?id=<?php echo $row['Id_Absensi']; ?>" class="nav-btn warning btn-action" style="padding:6px 12px;">Edit</a>
                            <form method="POST" action="delete_absensi.php" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $row['Id_Absensi']; ?>">
                                <button type="submit" class="nav-btn danger btn-action" style="padding:6px 12px;" onclick="return confirm('Yakin hapus absensi ini?')">Hapus</button>
                            </form>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="<?php echo hasFullAccess() ? 8 : 7; ?>" style="text-align:center; padding:48px; color: var(--muted);">Belum ada data absensi.<?php if (hasFullAccess()): ?> <a href="tambah_absensi.php" style="color: var(--accent);">Mulai catat sekarang</a><?php endif; ?></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <footer class="page-footer">
        &copy; <?php echo date('Y'); ?> &nbsp;·&nbsp; UKMPC Absensi System &nbsp;·&nbsp; Powered by Modern Design
    </footer>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
</body>
</html>

