<?php
/**
 * Authentication helper for UKMPC
 * Ensures session is started and provides access checks.
 */

// Ensure session is started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Require login (READ access for all logged-in users)
function requireLogin() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
}

// Full access (BPH, AK only) for WRITE operations
function hasFullAccess() {
    return isset($_SESSION['jabatan']) && in_array($_SESSION['jabatan'], ['BPH', 'AK']);
}
?>

