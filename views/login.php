<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistem Reservasi Fasilitas</title>
</head>
<body>
    <h2>Login</h2>

    <?php if (isset($_GET['error'])): ?>
        <p style="color:red;"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif; ?>

    <form id="formLogin" action="../public/login_process.php" method="POST">
        <label>Email:</label><br>
        <input type="email" name="email" id="email"><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" id="password"><br><br>

        <button type="submit">Login</button>
    </form>

    <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>

    <script>
        document.getElementById('formLogin').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;

            if (email === '' || password === '') {
                alert('Email dan password wajib diisi!');
                e.preventDefault();
                return;
            }
        });
    </script>
</body>
</html>