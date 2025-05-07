<?php
$fname = "Jessa";
$lname = "Andres";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>echo and print </title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background-color: #f0f7f2;
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .card {
      background: linear-gradient(to bottom right, #e6f4ec, #ffffff);
      border: 2px solid #cce3d7;
      border-radius: 28px;
      padding: 50px 40px;
      width: 400px;
      text-align: center;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
      position: relative;
    }

    .green-heart {
      font-size: 40px;
      color: #6fbf73;
      margin-bottom: 20px;
      animation: float 2s ease-in-out infinite;
    }

    @keyframes float {
      0% { transform: translateY(0); }
      50% { transform: translateY(-6px); }
      100% { transform: translateY(0); }
    }

    .name {
      font-size: 20px;
      color: #446c57;
      margin: 5px 0;
      font-weight: 500;
    }

    .divider {
      width: 60%;
      height: 1px;
      background-color: #d7eadd;
      margin: 20px auto;
    }

    .message {
      font-size: 16px;
      color: #5c7d6a;
      margin-top: 10px;
    }

    .box-decor {
      position: absolute;
      top: -15px;
      right: -15px;
      width: 40px;
      height: 40px;
      background-color: #d4efdf;
      border-radius: 50%;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>

<div class="card">
  <div class="box-decor"></div>
  <div class="green-heart">💚</div>

  <div class="name">
    <?php echo "First Name: $fname"; ?>
  </div>
  <div class="name">
    <?php echo "Last Name: $lname"; ?>
  </div>

  <div class="divider"></div>

  <div class="message">
    <?php print "Welcome to my soft green space 💚"; ?>
  </div>
</div>

</body>
</html>