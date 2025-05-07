<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome Page with PHP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff176; /* light yellow */
            text-align: center;
            padding-top: 100px;
            color: #333;
        }

        h1 {
            font-size: 48px;
            margin-bottom: 40px; /* Increased space below h1 */
        }

        p {
            font-size: 20px;
        }

        .button {
            display: inline-block;
            margin-top: 30px;
            padding: 12px 24px;
            font-size: 18px;
            background-color: white;
            color: black;
            border: 2px solid #333;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .button:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>

    <h1>WELCOME TO MY PAGE</h1>

    <?php
        echo "<p>This is to displayed using <strong>echo</strong>.</p>";
        print "<p>This is to displayed using <strong>print</strong>.</p>";
    ?>

    <form method="post">
        <button class="button" type="submit" name="refresh">Click for a reward!</button>
    </form>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['refresh'])) {
            echo "<p>HELLO, LOVE, GOODBYE!</p>";
        }
    ?>

</body>
</html>
