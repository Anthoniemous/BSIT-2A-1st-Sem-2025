<?php
// Determine if the button was clicked
$greetUser = isset($_POST['submit']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WELCOME TO MY PAGE!</title>
    <style>
        body {
            background-color: #f0f8ff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #0077b6;
            color: white;
            padding: 40px 20px;
            text-align: center;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        button {
            background-color: #0096c7;
            border: none;
            color: white;
            padding: 12px 24px;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 20px;
        }

        button:hover {
            background-color: #0077b6;
        }

        .message {
            margin-top: 30px;
            color: #023047;
            font-size: 18px;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            padding: 20px;
            font-size: 14px;
            color: #666;
        }

        @media (max-width: 600px) {
            .container {
                margin: 20px;
                padding: 20px;
            }

            button {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>WELCOME TO MY PAGE!</h1>
    </div>

    <div class="container">
        <?php
            echo "<p>This line is written using <strong>echo</strong> in PHP.</p>";
            print "<p>This line is written using <strong>print</strong> in PHP.</p>";
        ?>

        <form method="post">
            <button type="submit" name="submit">Click for Greeting</button>
        </form>

        <?php
            if ($greetUser) {
                echo '<div class="message">Hello from JM Lumen! Thank you for visiting the page.</div>';
            }
        ?>
    </div>

    <div class="footer">
        Page Owner: <strong>JM Lumen</strong>
    </div>

</body>
</html>
