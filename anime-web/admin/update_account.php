<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Update Account</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      padding: 0;
      background: #1e1e2f;
      font-family: 'Poppins', sans-serif;
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .form-box {
      background: #2e2e42;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.3);
      width: 100%;
      max-width: 500px;
      box-sizing: border-box;
    }

    .form-box h2 {
      margin-bottom: 20px;
      text-align: center;
      font-weight: 500;
    }

    .form-group {
      margin-bottom: 15px;
      display: flex;
      flex-direction: column;
    }

    .form-group label {
      margin-bottom: 5px;
      font-size: 14px;
      font-weight: 500;
    }

    .form-group input {
      padding: 12px;
      border: none;
      border-radius: 5px;
      background: #44445e;
      color: #fff;
      font-size: 14px;
    }

    .form-group input::placeholder {
      color: #bbb;
    }

    .form-group input[type="submit"] {
      background: #28a745;
      color: #fff;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s;
    }

    .form-group input[type="submit"]:hover {
      background: #218838;
    }

    .back-link {
      display: block;
      text-align: center;
      margin-top: 20px;
      text-decoration: none;
      color: #17a2b8;
      font-size: 14px;
    }

    .back-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<div class="form-box">
  <h2>Update Your Account</h2>
  <form action="process_update_account.php" method="POST">
    <div class="form-group">
      <label for="username">New Username</label>
      <input type="text" id="username" name="username" value="<?= htmlspecialchars($_SESSION['username']) ?>" required>
    </div>

    <div class="form-group">
      <label for="email">New Email</label>
      <input type="email" id="email" name="email" value="<?= isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : '' ?>" required>
    </div>

    <div class="form-group">
      <label for="password">New Password</label>
      <input type="password" id="password" name="password" placeholder="Leave blank to keep current password">
    </div>

    <div class="form-group">
      <input type="submit" value="Update Account">
    </div>
  </form>
  <a class="back-link" href="dashboard.php">← Back to Dashboard</a>
</div>

</body>
</html>
