<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="auth.css">
</head>
<body>

<div class="container">
    <div class="card">
        <h2>Login</h2>

        <?php if(isset($_GET['error'])): ?>
            <p style="color:red;"><?php echo $_GET['error']; ?></p>
        <?php endif; ?>

        <form action="process_login.php" method="POST">
            <div class="input-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>

            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit" class="btn">Login</button>

            <div class="link">
                Belum punya akun? <a href="register.php">Daftar disini</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
