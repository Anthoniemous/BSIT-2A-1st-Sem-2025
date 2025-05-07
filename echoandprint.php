><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome Page with PHP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:rgb(255, 22, 197); /* light yellow */
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
    </style>
</head>
<body>

    <h1>WELCOME TO MY PAGE</h1>

    <form method="post">
        <button type="submit" name="echo" class="button">Echo</button>
        <button type="submit" name="print" class="button">Print</button>
    </form>

    <div class="message">
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST['echo'])) {
                    echo "This message is displayed using <strong>echo</strong>.";
                } elseif (isset($_POST['print'])) {
                    print "This message is displayed using <strong>print</strong>.";
                }
            }
        ?>
    </div>

</body>
</html>
