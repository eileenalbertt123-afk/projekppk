<?php
// public/login-process.php

session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/models/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        header('Location: ../views/login.php?error=Email dan password wajib diisi');
        exit;
    }

    $userModel = new User($pdo);
    $user = $userModel->findByEmail($email);

    if (!$user || !$userModel->verifyPassword($password, $user['password'])) {
        header('Location: ../views/login.php?error=Email atau password salah');
        exit;
    }

    // Login berhasil, simpan session
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['nama'] = $user['nama'];
    $_SESSION['role'] = $user['role'];

    // Redirect sesuai role (nanti disambungkan ke dashboard masing-masing role)
    header('Location: ../views/dashboard.php');
    exit;

} else {
    header('Location: ../views/login.php');
    exit;
}
?>