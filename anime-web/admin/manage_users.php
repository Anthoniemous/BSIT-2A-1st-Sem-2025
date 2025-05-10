<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';

// Handle user deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM users WHERE id = $id");
    header("Location: manage_users.php");
}

// Fetch users
$users = $conn->query("SELECT id, username, email, role FROM users");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Users</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      padding: 40px;
      background: #1e1e2f;
      font-family: 'Poppins', sans-serif;
      color: #fff;
    }

    h1 {
      text-align: center;
      margin-bottom: 30px;
    }

    .dashboard-container {
      max-width: 1000px;
      margin: 0 auto;
    }

    .add-btn, .logout-btn {
      display: inline-block;
      margin-bottom: 20px;
      background-color: #28a745;
      color: white;
      padding: 10px 20px;
      border-radius: 6px;
      text-decoration: none;
      font-weight: bold;
      transition: background 0.3s;
    }

    .add-btn:hover {
      background-color: #218838;
    }

    .logout-btn {
      background-color: #007bff;
    }

    .logout-btn:hover {
      background-color: #0056b3;
    }

    .user-table {
      width: 100%;
      border-collapse: collapse;
      background: #2c2c3e;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 0 10px rgba(0,0,0,0.3);
    }

    .user-table th,
    .user-table td {
      padding: 15px;
      text-align: left;
      border-bottom: 1px solid #444;
    }

    .user-table th {
      background-color: #383854;
      color: #f0f0f0;
      font-weight: 600;
    }

    .user-table td {
      color: #ccc;
    }

    .user-table tr:hover {
      background-color: #3c3c55;
    }

    .action-links a {
      color: #17a2b8;
      text-decoration: none;
      margin-right: 10px;
    }

    .action-links a:hover {
      text-decoration: underline;
    }

    .action-links a.delete {
      color: #dc3545;
    }

    .bottom-links {
      text-align: center;
      margin-top: 30px;
    }
  </style>
</head>
<body>

<div class="dashboard-container">
  <h1>Manage Users</h1>

  <a href="add_user.php" class="add-btn">➕ Add New User</a>

  <table class="user-table">
    <tr>
      <th>ID</th>
      <th>Username</th>
      <th>Email</th>
      <th>Role</th>
      <th>Actions</th>
    </tr>
    <?php while($user = $users->fetch_assoc()): ?>
      <tr>
        <td><?= $user['id'] ?></td>
        <td><?= htmlspecialchars($user['username']) ?></td>
        <td><?= htmlspecialchars($user['email']) ?></td>
        <td><?= htmlspecialchars($user['role']) ?></td>
        <td class="action-links">
          <a href="edit_user.php?id=<?= $user['id'] ?>">✏️ Edit</a>
          <a href="?delete=<?= $user['id'] ?>" class="delete" onclick="return confirm('Delete this user?')">🗑️ Delete</a>
        </td>
      </tr>
    <?php endwhile; ?>
  </table>

  <div class="bottom-links">
    <a class="logout-btn" href="dashboard.php">← Back to Dashboard</a>
  </div>
</div>

</body>
</html>
