<?php
include 'auth.php';
requireLogin(); // Optional, but safe
session_destroy();
header('Location: login.php');
exit;
?>

