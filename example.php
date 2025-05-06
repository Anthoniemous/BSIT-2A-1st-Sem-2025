<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PRINCESS LAGMAY PAGE</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f8ff;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 700px;
            background: #ffffff;
            padding: 30px;
            margin: 50px auto;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
        }

        .message {
            background-color: #e8f5e9;
            border-left: 6px solid #4caf50;
            padding: 18px;
            margin: 20px 0;
            border-radius: 8px;
            color: #2e7d32;
            font-size: 18px;
        }

        footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #999;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>PRINCESS LAGMAY PAGE!</h1>

    <?php
        // Using echo with your name
        echo '<div class="message">Hello <strong>PRINCESS LAGMAY</strong>, this message is displayed using <strong>echo</strong>.</div>';

        // Using print with your name
        print '<div class="message">Hi again <strong>PRINCESS LAGMAY</strong>, this message is displayed using <strong>print</strong>.</div>';
    ?>

    <footer>
        &copy; <?php echo date("Y"); ?> | Made with 💙 for PRINCESS LAGMAY
    </footer>
</div>

</body>
</html>
