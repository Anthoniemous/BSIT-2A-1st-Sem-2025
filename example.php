<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP Echo and Print with Design</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f4f8;
            padding: 40px;
            text-align: center;
        }

        h1 {
            color: #2c3e50;
        }

        .output {
            margin: 20px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 50%;
        }

        .button-container {
            margin-top: 20px;
        }

        button {
            padding: 10px 20px;
            margin: 5px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

    <h1>PRIESLYN KAYE ANTIGA</h1>

    <div class="output">
        <?php
            echo "<p>This is output from <strong>echo</strong>.</p>";
            print "<p>This is output from <strong>print</strong>.</p>";
        ?>
    </div>

    <div class="button-container">
        <button onclick="alert('You clicked the Echo Button!')">Echo Button</button>
        <button onclick="alert('You clicked the Print Button!')">Print Button</button>
    </div>

</body>
</html>
