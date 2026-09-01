<?php

require_once __DIR__ . '/../../config/database.php';

class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Daftarkan user baru
    public function create($nama, $email, $password, $role = 'pengguna') {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (nama, email, password, role) VALUES (:nama, :email, :password, :role)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'nama' => $nama,
            'email' => $email,
            'password' => $hashedPassword,
            'role' => $role
        ]);
    }

    // Cari user berdasarkan email
    public function findByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Cek email sudah terdaftar atau belum
    public function emailExists($email) {
        return $this->findByEmail($email) !== false;
    }

    // Verifikasi password saat login
    public function verifyPassword($password, $hashedPassword) {
        return password_verify($password, $hashedPassword);
    }
}
?>