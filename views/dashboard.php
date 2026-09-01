<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
echo "Halo, " . htmlspecialchars($_SESSION['nama']) . "! Role kamu: " . htmlspecialchars($_SESSION['role']);
?>