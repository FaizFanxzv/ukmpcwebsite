<?php
include 'koneksi.php';

// Function to simulate the new logic from tambah_absensi.php
function test_absensi_logic($post_data) {
    global $conn;

    $anggota_id = $post_data['anggota_id'];
    $tanggal = $post_data['tanggal'];
    $jadwal_id = $post_data['jadwal_id'];
    $status = $post_data['status'];
    $keterangan = $post_data['keterangan'];
$aktif = $post_data['aktif'] ?? 'tidak';
    $aktif_poin = ($aktif == 'ya' ? 1 : 0);

    // Validation for select fields
    if ($anggota_id == 'pilih' || $jadwal_id == 'Pilih') {
        return ['error' => 'Validation failed: Harap pilih anggota dan jadwal yang valid!'];
    }

    // Calculate additional poin based on status
    $additional_poin = 0;
    switch (strtolower($status)) {
        case 'hadir':
            $additional_poin = 1;
            break;
        case 'izin':
        case 'sakit':
            $additional_poin = 1;
            break;
        case 'alpha':
            $additional_poin = 0;
            break;
    }
    $total_poin = $aktif_poin + $additional_poin;

    $sql = "INSERT INTO absensi (Anggota, Tanggal, Jadwal, Status, Keterangan, Poin) VALUES ('$anggota_id', '$tanggal', '$jadwal_id', '$status', '$keterangan', '$total_poin')";
    if ($conn->query($sql) === TRUE) {
        // Update poin anggota
        $update_sql = "UPDATE anggota SET Poin = Poin + $total_poin WHERE NIM = '$anggota_id'";
        $conn->query($update_sql);

        return ['success' => 'Absensi berhasil dicatat!', 'total_poin' => $total_poin];
    } else {
        return ['error' => 'Error: ' . $conn->error];
    }
}

// Get sample anggota
$anggota = $conn->query("SELECT NIM, Nama, Poin FROM anggota LIMIT 1")->fetch_assoc();
echo "Sample Anggota: NIM=" . $anggota['NIM'] . ", Nama=" . $anggota['Nama'] . ", Poin sebelum=" . $anggota['Poin'] . "\n";

// Get sample jadwal
$jadwal = $conn->query("SELECT Id_Jadwal, Hari FROM jadwal LIMIT 1")->fetch_assoc();
echo "Sample Jadwal: Id=" . $jadwal['Id_Jadwal'] . ", Hari=" . $jadwal['Hari'] . "\n";

// Test cases
$test_cases = [
    [
        'name' => 'Valid Hadir',
        'data' => [
            'anggota_id' => $anggota['NIM'],
            'tanggal' => '2023-10-01',
            'jadwal_id' => $jadwal['Id_Jadwal'],
            'status' => 'hadir',
            'keterangan' => 'Test hadir',
'aktif' => 'ya'
        ],
        'expected_additional' => 1,
        'expected_total' => 2
    ],
    [
        'name' => 'Valid Izin',
        'data' => [
            'anggota_id' => $anggota['NIM'],
            'tanggal' => '2023-10-02',
            'jadwal_id' => $jadwal['Id_Jadwal'],
            'status' => 'Izin',
            'keterangan' => 'Test izin',
'aktif' => 'tidak'
        ],
        'expected_additional' => 1,
        'expected_total' => 1
    ],
    [
        'name' => 'Valid Sakit',
        'data' => [
            'anggota_id' => $anggota['NIM'],
            'tanggal' => '2023-10-03',
            'jadwal_id' => $jadwal['Id_Jadwal'],
            'status' => 'Sakit',
            'keterangan' => 'Test sakit',
'aktif' => 'ya'
        ],
        'expected_additional' => 1,
        'expected_total' => 2
    ],
    [
        'name' => 'Valid Alpha',
        'data' => [
            'anggota_id' => $anggota['NIM'],
            'tanggal' => '2023-10-04',
            'jadwal_id' => $jadwal['Id_Jadwal'],
            'status' => 'Alpha',
            'keterangan' => 'Test alpha',
'aktif' => 'tidak'
        ],
        'expected_additional' => 0,
        'expected_total' => 0
    ],
    [
        'name' => 'Invalid Anggota',
        'data' => [
            'anggota_id' => 'pilih',
            'tanggal' => '2023-10-05',
            'jadwal_id' => $jadwal['Id_Jadwal'],
            'status' => 'hadir',
            'keterangan' => 'Test invalid',
'aktif' => 'tidak'
        ],
        'expected_error' => true
    ],
    [
        'name' => 'Invalid Jadwal',
        'data' => [
            'anggota_id' => $anggota['NIM'],
            'tanggal' => '2023-10-06',
            'jadwal_id' => 'Pilih',
            'status' => 'hadir',
            'keterangan' => 'Test invalid',
'aktif' => 'ya'
        ],
        'expected_error' => true
    ]
];

foreach ($test_cases as $test) {
    echo "\n--- Testing: " . $test['name'] . " ---\n";
    $result = test_absensi_logic($test['data']);
    if (isset($result['error'])) {
        echo "Result: " . $result['error'] . "\n";
        if (isset($test['expected_error'])) {
            echo "✓ Validation works as expected.\n";
        } else {
            echo "✗ Unexpected error.\n";
        }
    } else {
        echo "Result: " . $result['success'] . "\n";
        echo "Total Poin: " . $result['total_poin'] . "\n";
        if ($result['total_poin'] == $test['expected_total']) {
            echo "✓ Poin calculation correct.\n";
        } else {
            echo "✗ Poin calculation incorrect. Expected: " . $test['expected_total'] . "\n";
        }
    }
}

// Check final poin of anggota
$final_anggota = $conn->query("SELECT Poin FROM anggota WHERE NIM = '{$anggota['NIM']}'")->fetch_assoc();
echo "\nFinal Poin Anggota: " . $final_anggota['Poin'] . "\n";

$conn->close();
?>
