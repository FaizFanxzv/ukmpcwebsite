<?php
include 'koneksi.php';
include 'auth.php';

if (!hasFullAccess()) {
    header('Location: seleksi_detail.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_seleksi'])) {
    $id_seleksi = intval($_POST['id_seleksi']);
    
    $delete_stmt = $conn->prepare("DELETE FROM seleksi WHERE id_seleksi = ?");
    $delete_stmt->bind_param("i", $id_seleksi);
    if ($delete_stmt->execute()) {
        echo "<script>alert('Seleksi berhasil dihapus!'); 
        window.history.back();</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
    $delete_stmt->close();

} else {
    echo "<script>window.history.back();</script>";
}
?>

