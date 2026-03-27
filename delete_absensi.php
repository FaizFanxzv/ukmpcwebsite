<?php
include 'koneksi.php';
include 'auth.php';

if (!hasFullAccess()) {
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    // Fetch the absensi record to get poin and anggota
    $sql = "SELECT Anggota, Poin FROM absensi WHERE Id_Absensi = '$id'";
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
        echo "<script>alert('Data absensi tidak ditemukan!'); window.location='dashboard.php';</script>";
        exit;
    }
    $row = $result->fetch_assoc();
    $anggota_nim = $row['Anggota'];
    $poin = $row['Poin'];

    // Delete the absensi record
    $delete_sql = "DELETE FROM absensi WHERE Id_Absensi = '$id'";
    if ($conn->query($delete_sql) === TRUE) {
        // Subtract poin from anggota
        $update_sql = "UPDATE anggota SET Poin = Poin - $poin WHERE NIM = '$anggota_nim'";
        $conn->query($update_sql);

        echo "<script>alert('Absensi berhasil dihapus!'); window.location='dashboard.php';</script>";
    } else {
        echo "Error: " . $delete_sql . "<br>" . $conn->error;
    }
} else {
    echo "<script>alert('Metode tidak valid!'); window.location='dashboard.php';</script>";
}
?>

