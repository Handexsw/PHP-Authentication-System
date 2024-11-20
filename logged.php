<?php
require_once 'db.php';

if (isset($_COOKIE['token'])) {
    $token = $_COOKIE['token'];

    $stmt = $conn->prepare("SELECT id FROM users WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        header("Location: /dashboard.php"); // Menu that can only be accessed in your account
        exit();
    }
}