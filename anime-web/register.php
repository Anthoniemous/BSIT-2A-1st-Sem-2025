<?php
session_start();
include 'includes/db.php';

$message = '';

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role     = $_POST['role'];

    $avatarFilename = null;
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $avatarTmpPath = $_FILES['avatar']['tmp_name'];
        $avatarName    = basename($_FILES['avatar']['name']);
        $avatarExt     = pathinfo($avatarName, PATHINFO_EXTENSION);
        $avatarFilename = uniqid('avatar_') . '.' . $avatarExt;
        $uploadDir     = 'uploads/avatars/';
        $uploadPath    = $uploadDir . $avatarFilename;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        move_uploaded_file($avatarTmpPath, $uploadPath);
    }

    $check = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $message = "Email already registered!";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, role, avatar) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $email, $password, $role, $avatarFilename);

        if ($stmt->execute()) {
            $message = "Registration successful. <a href='login.php'>Login here</a>";
        } else {
            $message = "Registration failed.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register | Anime Portal</title>
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

    .register-box {
      background: #2e2e42;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.3);
      width: 100%;
      max-width: 450px;
      box-sizing: border-box;
    }

    .register-box h2 {
      margin-bottom: 20px;
      font-weight: 500;
      text-align: center;
    }

    .register-box input,
    .register-box select {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: none;
      border-radius: 5px;
      background: #44445e;
      color: #fff;
      font-size: 14px;
    }

    .register-box input::placeholder {
      color: #bbb;
    }

    .register-box button {
      width: 100%;
      padding: 12px;
      background: #ff4b5c;
      border: none;
      border-radius: 5px;
      color: #fff;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s;
      margin-top: 15px;
    }

    .register-box button:hover {
      background: #e03a4a;
    }

    .register-box .message {
      margin-top: 10px;
      text-align: center;
      color: #ffc107;
    }

    .register-box .footer-link {
      display: block;
      margin-top: 15px;
      text-align: center;
      font-size: 14px;
      color: #ccc;
    }

    .register-box .footer-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<div class="register-box">
  <h2>Create an Account</h2>

  <?php if (!empty($message)): ?>
    <div class="message"><?= $message ?></div>
  <?php endif; ?>

  <form method="POST" enctype="multipart/form-data">
    <input type="text" name="username" required placeholder="Username">
    <input type="email" name="email" required placeholder="Email">
    <input type="password" name="password" required placeholder="Password">
    <select name="role">
      <option value="user">User</option>
      <option value="admin">Admin</option>
    </select>
    <input type="file" name="avatar" accept="image/*">
    <button type="submit" name="register">Register</button>
  </form>

  <a href="login.php" class="footer-link">Already have an account? Login</a>
</div>

</body>
</html>
