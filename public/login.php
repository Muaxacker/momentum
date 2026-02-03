<?php
session_start();
require_once __DIR__ . '/../app/auth/login.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $result = loginUser($email, $password);
    $message = $result['message'];

    if ($result['success']) {
        header("Location: dashboard.php"); // Protected page
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Momentum</title>
</head>
<body>
    <h2>Login</h2>
    <?php if ($message) echo "<p>$message</p>"; ?>
    <form action="" method="post">
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="register.php">Register here</a></p>
</body>
</html>
