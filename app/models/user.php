<?php

require_once __DIR__ . '/../../config/database.php';

class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    //daftarkan new user
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

    //cari user berdasarkan email
    public function findByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //cek email sudah terdaftar/belum
    public function emailExists($email) {
        return $this->findByEmail($email) !== false;
    }

    //verifikasi password saat login
    public function verifyPassword($password, $hashedPassword) {
        return password_verify($password, $hashedPassword);
    }
}
?>