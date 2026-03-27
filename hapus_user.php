<?php
include 'koneksi.php';
include 'auth.php';

if (!hasFullAccess()) {
    header('Location: user.php');
    exit;
}

$id = $_GET['id'] ?? $_POST['id'] ?? 0;
if (!$id || $id == $_SESSION['user_id']) {
    echo "<script>alert('Aksi tidak valid!'); window.location='user.php';</script>";
    exit;
}

$stmt = $conn->prepare("DELETE FROM user WHERE id_user = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "<script>alert('User berhasil dihapus!'); window.location='user.php';</script>";
} else {
    echo "<script>alert('Error: " . $conn->error . "'); window.location='user.php';</script>";
}
?>

