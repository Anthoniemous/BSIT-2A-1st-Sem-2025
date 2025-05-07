<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Assignment PHP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:hsl(328, 100.00%, 73.10%);
            text-align: center;
            padding-top: 100px;
            color: #333;
        }

        h1 {
            font-size: 48px;
            margin-bottom: 40px;
        }

        p {
            font-size: 20px;
        }

        .button {
            display: inline-block;
            margin: 10px;
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

        .message {
            margin-top: 30px;
            font-size: 22px;
            color: #444;
        }

        .back-button {
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <h1>WELCOME! This is a sample for Echo and Print!</h1>

    <?php
    
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['choice'])) {
        echo '<div class="message">';
        if ($_POST['choice'] === 'echo') {
            echo "You clicked the <strong>Echo</strong> button. Message displayed using echo.";
        } elseif ($_POST['choice'] === 'print') {
            print "You clicked the <strong>Print</strong> button. Message displayed using print.";
        } else {
            echo "Invalid choice.";
        }
        echo '</div>';

        echo '<div class="back-button">';
        echo '<form method="get">';
        echo '<button type="submit" class="button">Go Back</button>';
        echo '</form>';
        echo '</div>';
    } else {
        echo '<form method="post">';
        echo '<button type="submit" name="choice" value="echo" class="button">Echo</button>';
        echo '<button type="submit" name="choice" value="print" class="button">Print</button>';
        echo '</form>';
    }
    ?>

</body>
</html>
