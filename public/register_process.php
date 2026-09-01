<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/models/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nama = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    //validasi sisi server
    if ($nama === '' || $email === '' || $password === '') {
        header('Location: ../views/register.php?error=Semua field wajib diisi');
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: ../views/register.php?error=Format email tidak valid');
        exit;
    }

    if (strlen($password) < 6) {
        header('Location: ../views/register.php?error=Password minimal 6 karakter');
        exit;
    }

    $userModel = new User($pdo);

    //cek email sdh terdaftar
    if ($userModel->emailExists($email)) {
        header('Location: ../views/register.php?error=Email sudah terdaftar');
        exit;
    }

    //simpan new user
    $success = $userModel->create($nama, $email, $password);

    if ($success) {
        header('Location: ../views/login.php?success=Registrasi berhasil, silakan login');
        exit;
    } else {
        header('Location: ../views/register.php?error=Registrasi gagal, coba lagi');
        exit;
    }

} else {
    header('Location: ../views/register.php');
    exit;
}
?>