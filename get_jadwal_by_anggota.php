<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['anggota_id']) && $_POST['anggota_id'] != 'pilih') {
    $anggota_id = $_POST['anggota_id'];
    
    // Get member's level
    $stmt = $conn->prepare("SELECT Level FROM anggota WHERE NIM = ?");
    $stmt->bind_param("s", $anggota_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $level_id = $row['Level'];
        
        // Get jadwals for this level
        $jadwals = $conn->query("SELECT j.Id_Jadwal, j.Hari, l.Nama_Level 
                                 FROM jadwal j 
                                 INNER JOIN level l ON j.Level = l.Id_Level 
                                 WHERE j.Level = '$level_id' 
                                 ORDER BY j.Hari");
        
        $options = [];
        while ($jadwal = $jadwals->fetch_assoc()) {
            $options[] = [
                'id' => $jadwal['Id_Jadwal'],
                'text' => $jadwal['Hari'] . ' - ' . $jadwal['Nama_Level']
            ];
        }
        
        header('Content-Type: application/json');
        echo json_encode($options);
    } else {
        echo json_encode([]);
    }
} else {
    echo json_encode([]);
}
?>

