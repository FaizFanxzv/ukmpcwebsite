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

// Check if event has seleksi data (optional safety)
$stmt = $conn->prepare("SELECT COUNT(*) as count FROM seleksi WHERE event=?");
$stmt->bind_param("i", $id_event);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
if ($row['count'] > 0) {
    echo "<script>alert('Event ini memiliki data seleksi, hapus data seleksi terlebih dahulu!'); window.location='seleksi.php';</script>";
    $stmt->close();
    exit;
}
$stmt->close();

if ($_GET['confirm'] == 'yes') {
    $stmt = $conn->prepare("DELETE FROM event WHERE id_event=?");
    $stmt->bind_param("i", $id_event);
    if ($stmt->execute()) {
        echo "<script>alert('Event berhasil dihapus!'); window.location='seleksi.php';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
    $stmt->close();
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Event - UKMPC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Konfirmasi Hapus Event</h1>
        <nav class="mb-4">
            <a href="seleksi.php" class="btn btn-secondary">Kembali ke Daftar Event</a>
        </nav>
        <div class="alert alert-warning">
            <p>Apakah Anda yakin ingin menghapus event ini? Tindakan ini tidak dapat dibatalkan.</p>
            <p><strong>ID Event:</strong> <?php echo $id_event; ?></p>
        </div>
        <a href="hapus_event.php?id=<?php echo $id_event; ?>&confirm=yes" class="btn btn-danger" onclick="return confirm('Yakin hapus?')">Ya, Hapus</a>
        <a href="seleksi.php" class="btn btn-secondary">Batal</a>
    </div>
</body>
</html>

