<?php
include 'koneksi.php';
include 'auth.php';

if (!hasFullAccess()) {
    header('Location: dashboard.php');
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "<script>alert('ID absensi tidak ditemukan!'); window.location='dashboard.php';</script>";
    exit;
}

// Fetch existing data
$sql = "SELECT absen.*, angg.Nama as Anggota_Nama, jdw.Hari, lvl.Nama_Level
        FROM absensi absen
        INNER JOIN anggota angg ON absen.Anggota = angg.NIM
        INNER JOIN jadwal jdw ON absen.Jadwal = jdw.Id_Jadwal
        INNER JOIN level lvl ON angg.Level = lvl.id_level
        WHERE absen.Id_Absensi = '$id'";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    echo "<script>alert('Data absensi tidak ditemukan!'); window.location='dashboard.php';</script>";
    exit;
}
$row = $result->fetch_assoc();

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
        echo "<script>alert('Gagal menambahkan data karena tidak masuk logika, ulangi lagi. Wajib pilih \"Tidak\" untuk status ini.'); window.history.back();</script>";
        exit;
    }

    // Calculate new total poin
    $new_status_poin = 0;
    switch (strtolower($status)) {
        case 'hadir':
            $new_status_poin = 1;
            break;
        case 'izin':
        case 'sakit':
            $new_status_poin = 1;
            break;
        case 'alpha':
            $new_status_poin = 0;
            break;
    }
    $new_total_poin = $aktif_poin + $new_status_poin;

    // Update absensi
    $update_sql = "UPDATE absensi SET Anggota='$anggota_id', Tanggal='$tanggal', Jadwal='$jadwal_id', Status='$status', Keterangan='$keterangan', Poin='$new_total_poin' WHERE Id_Absensi='$id'";
    if ($conn->query($update_sql) === TRUE) {
        // Update poin anggota: subtract old total, add new total
        $old_anggota = $row['Anggota'];
        $conn->query("UPDATE anggota SET Poin = Poin - {$row['Poin']} WHERE NIM = '$old_anggota'");
        $conn->query("UPDATE anggota SET Poin = Poin + $new_total_poin WHERE NIM = '$anggota_id'");

        echo "<script>alert('Absensi berhasil diupdate!'); window.location='dashboard.php';</script>";
    } else {
        echo "Error: " . $update_sql . "<br>" . $conn->error;
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
    <title>Edit Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="UKM PC Logos.png">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Absensi</h1>
        <nav class="mb-4">
            <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
        </nav>
        <form method="POST">
            <div class="mb-3">
                <label for="anggota_id" class="form-label">Anggota</label>
                <select class="form-control" id="anggota_id" name="anggota_id" required onchange="updateJadwal()">
                    <option value="pilih" selected>Pilih Nama</option>
                    <?php while ($anggota_row = $anggota->fetch_assoc()): ?>
                        <option value="<?php echo $anggota_row['NIM']; ?>" <?php echo ($anggota_row['NIM'] == $row['Anggota']) ? 'selected' : ''; ?>><?php echo $anggota_row['Nama']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?php echo $row['Tanggal']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="jadwal_id" class="form-label">Jadwal</label>
                <select class="form-control" id="jadwal_id" name="jadwal_id" required>
                    <option value="Pilih" selected>Pilih Jadwal</option>
                    <?php while ($jadwal_row = $jadwal->fetch_assoc()): ?>
                        <option value="<?php echo $jadwal_row['Id_Jadwal']; ?>" <?php echo ($jadwal_row['Id_Jadwal'] == $row['Jadwal']) ? 'selected' : ''; ?>><?php echo $jadwal_row['Hari'] . ' - ' . $jadwal_row['Nama_Level']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control" id="status" name="status" required onchange="handleStatusChange()">
                    <option value="hadir" <?php echo (strtolower($row['Status']) == 'hadir') ? 'selected' : ''; ?>>Hadir</option>
                    <option value="Izin" <?php echo (strtolower($row['Status']) == 'izin') ? 'selected' : ''; ?> >Izin</option>
                    <option value="Sakit" <?php echo (strtolower($row['Status']) == 'sakit') ? 'selected' : ''; ?>>Sakit</option>
                    <option value="Alpha" <?php echo (strtolower($row['Status']) == 'alpha') ? 'selected' : ''; ?>>Alpha</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control" id="keterangan" name="keterangan" rows="3"><?php echo $row['Keterangan']; ?></textarea>
            </div>
            <div class="mb-3" id="aktif-group">
                <label class="form-label">Aktif?</label>
                <div>
                    <input type="radio" id="aktif_ya" name="aktif" value="ya" required>
                    <label for="aktif_ya"> Ya (+1 poin)</label>
                </div>
                <div>
                    <input type="radio" id="aktif_tidak" name="aktif" value="tidak" checked>
                    <label for="aktif_tidak"> Tidak (0 poin)</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html>

