<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="auth.css">
</head>
<body>

<div class="container">
    <div class="card">
        <h2>Register</h2>

        <?php if(isset($_GET['error'])): ?>
            <p style="color:red;"><?php echo $_GET['error']; ?></p>
        <?php endif; ?>

        <form action="process_register.php" method="POST">

            <div class="input-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>

            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>

            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit" class="btn">Register</button>

            <div class="link">
                Sudah punya akun? <a href="login.php">Login disini</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
