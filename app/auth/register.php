<?php
// app/auth/register.php
require_once __DIR__ . '/../database/db.php'; // DB connection

function registerUser($name, $email, $password) {
    global $pdo;

    // 1 Basic validation
    if (empty($name) || empty($email) || empty($password)) {
        return ['success' => false, 'message' => 'All fields are required.'];
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return ['success' => false, 'message' => 'Invalid email format.'];
    }

    // 2 Check if email already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    if ($stmt->rowCount() > 0) {
        return ['success' => false, 'message' => 'Email already registered.'];
    }

    // 3 Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // 4 Insert user into database
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
    $success = $stmt->execute([
        'name' => $name,
        'email' => $email,
        'password' => $hashedPassword
    ]);

    if ($success) {
        return ['success' => true, 'message' => 'Registration successful! You can now login.'];
    } else {
        return ['success' => false, 'message' => 'Registration failed. Try again later.'];
    }
}
