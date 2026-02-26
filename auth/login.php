<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Sistem Pelaporan</title>
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>

<div class="login-container">
    <h2>Login Sistem</h2>

    <!-- PESAN ERROR -->
    
    <form method="POST" action="proses_login.php">
        
        <div class="input-group">
            <label>Username</label>
            <input type="text" name="username" required>
        </div>

        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <?php if (isset($_GET['error']) && $_GET['error'] == 'invalid'): ?>
            <div class="error-message">
                Username atau password yang dimasukkan salah.
            </div>
        <?php endif; ?> <br>

        <button type="submit" class="btn-login">Login</button>

    </form>

    <div class="footer-text">
        Sistem Pelaporan Magang © 2026
    </div>
</div>

</body>
</html>
