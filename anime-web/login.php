<?php
session_start();
include 'includes/db.php';

if (isset($_POST['login'])) {
    $email    = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user   = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['role']     = $user['role'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['avatar']   = $user['avatar']; // ✅ Avatar support

        header("Location: " . ($user['role'] == 'admin' ? "admin/dashboard.php" : "user/dashboard.php"));
        exit();
    } else {
        $error = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login | Anime Portal</title>
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

    .login-box {
      background: #2e2e42;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.3);
      width: 100%;
      max-width: 400px;
      box-sizing: border-box;
    }

    .login-box h2 {
      margin-bottom: 20px;
      font-weight: 500;
      text-align: center;
    }

    .login-box input[type="email"],
    .login-box input[type="password"] {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: none;
      border-radius: 5px;
      background: #44445e;
      color: #fff;
      font-size: 14px;
    }

    .login-box input::placeholder {
      color: #bbb;
    }

    .login-box button {
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

    .login-box button:hover {
      background: #e03a4a;
    }

    .error {
      color: #ff7878;
      text-align: center;
      margin-bottom: 10px;
    }

    .login-box .footer-link {
      display: block;
      margin-top: 15px;
      text-align: center;
      font-size: 14px;
      color: #ccc;
    }

    .login-box .footer-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<div class="login-box">
  <h2>Login to Anime Portal</h2>

  <?php if (isset($error)): ?>
    <div class="error"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="POST">
    <input type="email" name="email" required placeholder="Email">
    <input type="password" name="password" required placeholder="Password">
    <button type="submit" name="login">Login</button>
  </form>

  <a href="register.php" class="footer-link">Don't have an account? Register</a>
</div>

</body>
</html>
