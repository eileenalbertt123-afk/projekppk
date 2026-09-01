<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi - Sistem Reservasi Fasilitas</title>
</head>
<body>
    <h2>Registrasi Akun</h2>

    <?php if (isset($_GET['error'])): ?>
        <p style="color:red;"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif; ?>

    <form id="formRegister" action="../public/register_process.php" method="POST">
        <label>Nama:</label><br>
        <input type="text" name="nama" id="nama"><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" id="email"><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" id="password"><br><br>

        <button type="submit">Daftar</button>
    </form>

    <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>

    <script>
        document.getElementById('formRegister').addEventListener('submit', function(e) {
            const nama = document.getElementById('nama').value.trim();
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;

            if (nama === '' || email === '' || password === '') {
                alert('Semua field wajib diisi!');
                e.preventDefault();
                return;
            }

            if (password.length < 6) {
                alert('Password minimal 6 karakter!');
                e.preventDefault();
                return;
            }

            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                alert('Format email tidak valid!');
                e.preventDefault();
                return;
            }
        });
    </script>
</body>
</html>