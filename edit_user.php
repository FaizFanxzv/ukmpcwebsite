<?php
include 'koneksi.php';
include 'auth.php';

if (!hasFullAccess()) {
    header('Location: user.php');
    exit;
}

$id = $_GET['id'] ?? 0;
if (!$id) {
    header('Location: user.php');
    exit;
}

$user = null;
$stmt = $conn->prepare("SELECT * FROM user WHERE id_user = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($user = $result->fetch_assoc()) {
    // Data loaded
} else {
    echo "<script>alert('User tidak ditemukan!'); window.location='user.php';</script>";
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $nama = trim($_POST['nama']);
    $jabatan = $_POST['jabatan'];
    $password = trim($_POST['password']);
    
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE user SET username = ?, nama = ?, jabatan = ?, password = ? WHERE id_user = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $username, $nama, $jabatan, $hashed_password, $id);
    } else {
        $sql = "UPDATE user SET username = ?, nama = ?, jabatan = ? WHERE id_user = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $username, $nama, $jabatan, $id);
    }
    
    if ($stmt->execute()) {
        echo "<script>alert('User berhasil diupdate!'); window.location='user.php';</script>";
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
    <title>Edit User - UKMPC</title>
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
        <h1 class="page-title">Edit User #<?php echo $id; ?></h1>
        <p class="page-subtitle">Update data user <?php echo htmlspecialchars($user['username']); ?>. Kosongkan password jika tidak ingin ubah. (Admin Only)</p>
    </header>

    <!-- Form Section -->
    <?php if ($error): ?>
    <div style="background: rgba(248,113,113,0.15); border:1px solid rgba(248,113,113,0.3); border-radius:16px; padding:24px; margin-bottom:32px; color: var(--danger);">
        <?php echo htmlspecialchars($error); ?>
    </div>
    <?php endif; ?>

    <section class="form-section">
        <form method="POST">
            <label class="form-label" for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>

            <label class="form-label" for="nama">Nama Lengkap</label>
            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($user['nama']); ?>" required>

            <label class="form-label" for="password">Password Baru</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Kosongkan jika tidak diubah">

            <label class="form-label" for="jabatan">Jabatan</label>
            <select class="form-select" id="jabatan" name="jabatan" required>
                <option value="BPH" <?php echo ($user['jabatan']=='BPH') ? 'selected' : ''; ?>>BPH</option>
                <option value="AK" <?php echo ($user['jabatan']=='AK') ? 'selected' : ''; ?>>AK</option>
                <option value="Anggota" <?php echo ($user['jabatan']=='Anggota') ? 'selected' : ''; ?>>Anggota</option>
                <option value="KOMINFO" <?php echo ($user['jabatan']=='KOMINFO') ? 'selected' : ''; ?>>KOMINFO</option>
                <option value="PSDU" <?php echo ($user['jabatan']=='PSDU') ? 'selected' : ''; ?>>PSDU</option>
            </select>

            <div style="display:flex; gap:16px; margin-top:40px;">
                <a href="user.php" class="btn-modern secondary" style="flex:1;">Batal</a>
                <button type="submit" class="btn-modern primary" style="flex:2;">Update User</button>
            </div>
        </form>
    </section>

    <!-- Footer -->
    <footer class="page-footer">
        &copy; <?php echo date('Y'); ?> &nbsp;·&nbsp; UKMPC User Editor &nbsp;·&nbsp; ID #<?php echo $id; ?>
    </footer>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
</body>
</html>

