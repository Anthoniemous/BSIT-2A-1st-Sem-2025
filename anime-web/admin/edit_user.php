<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';

$id = $_GET['id'];
$user = $conn->query("SELECT * FROM users WHERE id = $id")->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET username=?, email=?, password=?, role=? WHERE id=?");
        $stmt->bind_param("ssssi", $username, $email, $password, $role, $id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET username=?, email=?, role=? WHERE id=?");
        $stmt->bind_param("sssi", $username, $email, $role, $id);
    }

    $stmt->execute();
    header("Location: manage_users.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #1e1e2f;
            font-family: 'Poppins', sans-serif;
            color: #fff;
            padding: 40px;
        }

        .dashboard-container {
            max-width: 500px;
            margin: auto;
            background-color: #2c2c3e;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
        }

        h1 {
            text-align: center;
            margin-bottom: 25px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin: 10px 0 5px;
            font-weight: 500;
        }

        input, select {
            padding: 10px;
            border: none;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 16px;
        }

        input[type="text"], input[type="email"], input[type="password"], select {
            background-color: #3c3c55;
            color: #fff;
        }

        input[type="text"]::placeholder,
        input[type="email"]::placeholder,
        input[type="password"]::placeholder {
            color: #ccc;
        }

        button {
            background-color: #28a745;
            color: white;
            padding: 12px;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s;
        }

        button:hover {
            background-color: #218838;
        }

        .logout-btn {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
            font-weight: 500;
        }

        .logout-btn:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="dashboard-container">
    <h1>Edit User</h1>
    <form method="POST">
        <label>Username</label>
        <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

        <label>New Password (optional)</label>
        <input type="password" name="password" placeholder="Leave blank to keep current password">

        <label>Role</label>
        <select name="role">
            <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>User</option>
            <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
        </select>

        <button type="submit">Update User</button>
    </form>
    <a class="logout-btn" href="manage_users.php">← Back to User Management</a>
</div>
</body>
</html>
