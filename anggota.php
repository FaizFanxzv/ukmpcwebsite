<?php
include 'koneksi.php';
include 'auth.php';
requireLogin();

$search = trim($_GET['search'] ?? '');

// Query untuk menampilkan anggota dengan join tabel level
$sql = "SELECT angg.NIM, angg.Nama, angg.Prodi, angg.No_Telp, lvl.Nama_Level, angg.Poin
        FROM anggota angg
        INNER JOIN level lvl ON angg.Level = lvl.Id_Level";

$params = [];
$types = '';
if (!empty($search)) {
    $sql .= " WHERE (angg.NIM LIKE ? OR angg.Nama LIKE ? OR angg.Prodi LIKE ?)";
    $params = ["%$search%", "%$search%", "%$search%"];
    $types = 'sss';
}

$sql .= " ORDER BY angg.Nama ASC";

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
    <title>Daftar Anggota - UKMPC</title>
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
        <a href="anggota.php" class="nav-btn active primary">Daftar Anggota</a>
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
        <h1 class="page-title">Daftar Anggota<?php if (!empty($search)): ?> <span style="font-weight:400;">— "<?php echo htmlspecialchars($search); ?>"</span><?php endif; ?></h1>
        <p class="page-subtitle">Data lengkap seluruh anggota UKMPC dengan level dan total poin akumulasi.</p>
    </header>

    <!-- Search & Actions -->
    <section class="search-section">
        <form method="GET">
            <input type="text" class="search-input" name="search" placeholder="Cari NIM, nama, atau prodi..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="nav-btn primary">Cari</button>
            <?php if (!empty($search)): ?>
            <a href="anggota.php" class="nav-btn secondary">Reset</a>
            <?php endif; ?>
        </form>
        <?php if (hasFullAccess()): ?>
        <a href="tambah_anggota.php" class="nav-btn primary">Tambah Anggota Baru</a>
        <?php endif; ?>
    </section>

    <!-- Data Table -->
    <div class="data-table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Prodi</th>
                    <th>No. Telp</th>
                    <th>Level</th>
                    <th>Poin</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($row['NIM']); ?></strong></td>
                        <td><?php echo htmlspecialchars($row['Nama']); ?></td>
                        <td><?php echo htmlspecialchars($row['Prodi']); ?></td>
                        <td><?php echo htmlspecialchars($row['No_Telp']); ?></td>
                        <td><span style="background: rgba(91,124,250,0.15); padding:4px 12px; border-radius:20px; font-size:12px; color: var(--accent);"><?php echo htmlspecialchars($row['Nama_Level']); ?></span></td>
                        <td><strong style="color: var(--accent3);"><?php echo $row['Poin']; ?></strong></td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="6" style="text-align:center; padding:48px; color: var(--muted);">Belum ada data anggota. <?php if (hasFullAccess()): ?><a href="tambah_anggota.php" style="color: var(--accent);">Tambah anggota pertama</a><?php endif; ?></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <footer class="page-footer">
        &copy; <?php echo date('Y'); ?> &nbsp;·&nbsp; UKMPC Anggota Directory &nbsp;·&nbsp; Complete Member List
    </footer>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
</body>
</html>

