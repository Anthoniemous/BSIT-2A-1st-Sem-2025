<!DOCTYPE html>
<html>
<head>
    <title>PHP Echo and Print Example</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 50px;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        .author {
            color: #555;
            margin-bottom: 30px;
            font-size: 18px;
        }
        .message {
            background-color: #fff;
            padding: 20px;
            margin: 15px auto;
            width: 60%;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            font-size: 18px;
        }
        .echo {
            color: #3498db;
        }
        .print {
            color: #e74c3c;
        }
        .btn {
            background-color: #2ecc71;
            border: none;
            color: white;
            padding: 15px 30px;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 30px;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #27ae60;
        }
        #output-message {
            margin-top: 20px;
            font-size: 20px;
            color: #333;
        }
    </style>
</head>
<body>

    <h1>Welcome to My PHP Page!</h1>
    <div class="author">by Genotiva J</div>

    <?php
        // using echo with a styled div
        echo "<div class='message echo'>This line is printed using <strong>echo</strong>.</div>";

        // using print with a styled div
        print "<div class='message print'>This line is printed using <strong>print</strong>.</div>";
    ?>

    <button class="btn" onclick="showMessage()">Click Me</button>

    <div id="output-message"></div>

    <script>
        function showMessage() {
            document.getElementById("output-message").innerHTML = "Hello Genotiva J! You clicked the button!";
        }
    </script>

</body>
</html>
