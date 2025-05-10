<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_POST['username'];
$email = $_POST['email'];

$stmt = $conn->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
$stmt->bind_param("ssi", $username, $email, $user_id);

if ($stmt->execute()) {
    $_SESSION['username'] = $username;
    header("Location: dashboard.php");
} else {
    echo "Failed to update profile.";
}
?>
