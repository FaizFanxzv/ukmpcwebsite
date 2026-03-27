<?php
include 'koneksi.php';
header('Content-Type: application/json');
if (isset($_POST['nim'])) {
  $stmt = $conn->prepare("SELECT Prodi, Poin FROM anggota WHERE NIM = ?");
  $stmt->bind_param('s', $_POST['nim']);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($row = $result->fetch_assoc()) {
    echo json_encode(['prodi' => $row['Prodi'], 'poin' => $row['Poin']]);
  } else {
    echo json_encode(['prodi' => '', 'poin' => 0]);
  }
}
?>

