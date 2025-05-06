<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CHAN DONQUE</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #1f1f2e;
            color: #f0f0f0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            background-color: #2d2d44;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
            width: 90%;
            max-width: 500px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #f9ca24;
        }

        input[type="text"] {
            width: 80%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 16px;
        }

        input[type="submit"] {
            padding: 10px 25px;
            border: none;
            border-radius: 5px;
            background-color: #00cec9;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0984e3;
        }

        .message {
            margin-top: 20px;
            font-size: 18px;
            color: #81ecec;
        }
    </style>
</head>
<body>

<div class="card">
    <h2>What's your name?</h2>
    <form method="post">
        <input type="text" name="username" placeholder="Enter your name..." required>
        <br>
        <input type="submit" value="Say Hello">
    </form>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["username"])) {
            $name = htmlspecialchars($_POST["username"]);
            echo "<div class='message'>Hello, <strong>$name</strong>! Welcome to Chan's area of responsibility!</div>";
        }
    ?>
</div>

</body>
</html>
