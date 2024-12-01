<?php
require_once 'dbConfig.php';
require_once 'models.php';  // Ensure models.php is included once

function registerUser($pdo, $username, $password) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    if ($stmt->execute([$username, $hashedPassword])) {
        logActivity($pdo, $username, 'Registration', 'User successfully registered');
        return true;
    }
    return false;
}

function isLoggedIn() {
    session_start();
    return isset($_SESSION['username']);
}

function logout($pdo) {
    if (isLoggedIn()) {
        $username = $_SESSION['username'];
        logActivity($pdo, $username, 'Logout', 'User logged out');
        session_destroy();
    }
    header("Location: ../login.php");
    exit();
}

function logActivity($pdo, $username, $action, $details) {
    $stmt = $pdo->prepare("INSERT INTO activity_logs (username, action, details, date_added) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$username, $action, $details]);
}
?>
