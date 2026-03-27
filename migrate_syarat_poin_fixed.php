<?php
include 'koneksi.php';
if ($conn->query("ALTER TABLE event ADD COLUMN syarat_poin INT DEFAULT 0;") === TRUE) {
    echo "Migration successful: syarat_poin column added to event table with DEFAULT 0.\n";
} else {
    echo "Error: " . $conn->error . "\n";
}
$conn->close();
?>

