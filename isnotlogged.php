<?php
require_once 'db.php';

if(!isset($_COOKIE['token'])) {
    header("Location: /login.php");
    exit();
}

$token = $_COOKIE['token'];

$stmt = $conn->prepare("SELECT id FROM users WHERE token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$stmt->bind_result($user_id);
$stmt->fetch();
$stmt->close();

if(empty($user_id)) {
    header("Location: /login.php");
    exit();
}
?>
