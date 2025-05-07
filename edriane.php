<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Echo and Print</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #a1c4fd, #c2e9fb);
            margin: 0;
            padding: 0;
        }

        .container {
            background-color: #f0faff;
            max-width: 500px;
            margin: 80px auto;
            padding: 40px 30px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            color: #4a90e2;
            font-size: 28px;
            margin-bottom: 20px;
        }

        .info {
            background-color: #d6f0ff;
            padding: 20px;
            border-radius: 15px;
            margin: 10px 0;
            color: #2e3a59;
            font-size: 18px;
            border: 2px dashed #a0cfff;
        }

        .message {
            margin-top: 25px;
            font-size: 20px;
            color: #5c9ded;
        }

        .emoji {
            font-size: 24px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome to Edriane's Corner! 💙</h2>
        <?php
        $fname = "Edriane";
        $lname = "Manicdog";

        echo "<div class='info'>First Name: $fname</div>";
        echo "<div class='info'>Last Name: $lname</div>";

        print "<div class='message'>Thanks for stopping by! <span class='emoji'>✨</span></div>";
        ?>
    </div>
</body>
</html>
