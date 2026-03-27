<?php
include 'koneksi.php';
include 'auth.php';

if (!hasFullAccess()) {
    header('Location: seleksi.php');
    exit;
}

$id_event = $_GET['id'] ?? 0;
if ($id_event == 0) {
    echo "<script>alert('ID event tidak valid!'); window.location='seleksi.php';</script>";
    exit;
}

if ($_POST) {
    $nama_event = $_POST['nama_event'];
    $tanggal_event = $_POST['tanggal_event'];
    $penyelenggara = $_POST['penyelenggara'];
    $lokasi = $_POST['lokasi'];
    $tanggal_seleksi = $_POST['tanggal_seleksi'];
    $syarat_poin = intval($_POST['syarat_poin']);

    $stmt = $conn->prepare("UPDATE event SET nama_event=?, tanggal_event=?, penyelenggara=?, lokasi=?, tanggal_seleksi=?, syarat_poin=? WHERE id_event=?");
    $stmt->bind_param("sssssii", $nama_event, $tanggal_event, $penyelenggara, $lokasi, $tanggal_seleksi, $syarat_poin, $id_event);

    if ($stmt->execute()) {
        echo "<script>alert('Event berhasil diupdate!'); window.location='seleksi.php';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
    $stmt->close();
}

$stmt = $conn->prepare("SELECT * FROM event WHERE id_event=?");
$stmt->bind_param("i", $id_event);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
if (!$row) {
    echo "<script>alert('Event tidak ditemukan!'); window.location='seleksi.php';</script>";
    exit;
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event - UKMPC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="UKM PC Logos.png">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Event</h1>
        <nav class="mb-4">
            <a href="seleksi.php" class="btn btn-secondary">Kembali ke Daftar Event</a>
        </nav>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Nama Event</label>
                <input type="text" class="form-control" name="nama_event" value="<?php echo htmlspecialchars($row['nama_event']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tanggal Event</label>
                <input type="date" class="form-control" name="tanggal_event" value="<?php echo $row['tanggal_event']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Penyelenggara</label>
                <input type="text" class="form-control" name="penyelenggara" value="<?php echo htmlspecialchars($row['penyelenggara']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Lokasi</label>
                <input type="text" class="form-control" name="lokasi" value="<?php echo htmlspecialchars($row['lokasi']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tanggal Seleksi</label>
                <input type="date" class="form-control" name="tanggal_seleksi" value="<?php echo $row['tanggal_seleksi']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Syarat Poin Minimum</label>
                <input type="number" class="form-control" name="syarat_poin" min="0" value="<?php echo intval($row['syarat_poin']); ?>" required>
            </div>
            <button type="submit" class="btn btn-warning">Update Event</button>
        </form>
    </div>
</body>
</html>

