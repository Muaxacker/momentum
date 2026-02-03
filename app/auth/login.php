<?php
// app/auth/login.php
require_once __DIR__ . '/../database/db.php';

function loginUser($email, $password) {
    global $pdo;

    // 1 Basic validation
    if (empty($email) || empty($password)) {
        return ['success' => false, 'message' => 'All fields are required.'];
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return ['success' => false, 'message' => 'Invalid email format.'];
    }

    // 2 Check if user exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        return ['success' => false, 'message' => 'Email not registered.'];
    }

    // 3 Verify password
    if (!password_verify($password, $user['password'])) {
        return ['success' => false, 'message' => 'Incorrect password.'];
    }

    // 4 Start session and store user ID
    session_start();
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['name'];

    return ['success' => true, 'message' => 'Login successful!'];
}
