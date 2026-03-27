<?php
include 'koneksi.php';
include 'auth.php';
requireLogin();

$search = trim($_GET['search'] ?? '');

$sql = "SELECT id_user, username, nama, jabatan FROM user";
$params = [];
$types = '';
if (!empty($search)) {
    $sql .= " WHERE (username LIKE ? OR nama LIKE ? OR jabatan LIKE ?)";
    $params = ["%$search%", "%$search%", "%$search%"];
    $types = 'sss';
}
$sql .= " ORDER BY nama ASC";

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
    <title>Kelola User - UKMPC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="UKM PC Logos.png">
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="page-wrapper">

    <!-- Navigation -->
    <nav class="top-nav">
        <a href="user.php" class="nav-btn danger active">Kelola User</a>
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
        <h1 class="page-title">Kelola User<?php if (!empty($search)): ?> - "<?php echo htmlspecialchars($search); ?>"<?php endif; ?></h1>
        <p class="page-subtitle">Daftar pengguna sistem. Hanya BPH/AK dapat edit/hapus. (Admin Only)</p>
    </header>

    <!-- Search & Actions -->
    <section class="search-section">
        <form method="GET" style="flex:1;">
            <input type="text" class="search-input" name="search" placeholder="Cari username, nama, jabatan..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="nav-btn primary">Cari</button>
            <?php if (!empty($search)): ?>
            <a href="user.php" class="nav-btn secondary">Reset</a>
            <?php endif; ?>
        </form>
        <?php if (hasFullAccess()): ?>
        <a href="tambah_user.php" class="nav-btn primary">Tambah User</a>
        <?php endif; ?>
    </section>

    <!-- Table -->
    <div class="data-table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <?php if (hasFullAccess()): ?>
                    <th>Aksi</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($row['username']); ?></strong></td>
                            <td><?php echo htmlspecialchars($row['nama']); ?></td>
                            <td><span style="background: rgba(91,124,250,0.1); padding:4px 8px; border-radius:6px; font-size:12px;"><?php echo htmlspecialchars($row['jabatan']); ?></span></td>
                            <?php if (hasFullAccess()): ?>
                            <td>
                                <a href="edit_user.php?id=<?php echo $row['id_user']; ?>" class="nav-btn warning btn-action">Edit</a>
                                <a href="hapus_user.php?id=<?php echo $row['id_user']; ?>" class="nav-btn danger btn-action" onclick="return confirm('Yakin hapus?')">Hapus</a>
                            </td>
                            <?php endif; ?>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="<?php echo hasFullAccess() ? 4 : 3; ?>">Belum ada data user. <?php if (hasFullAccess()): ?><a href="tambah_user.php" style="color: var(--accent);">Tambah sekarang</a><?php endif; ?></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <footer class="page-footer">
        &copy; <?php echo date('Y'); ?> &nbsp;·&nbsp; UKMPC User Management &nbsp;·&nbsp; Admin Only
    </footer>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
</body>
</html>

