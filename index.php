<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP Echo and Print</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:rgb(221, 179, 179);
            color: #333;
            margin: 0;
            padding: 40px;
        }
        .container {
            background: white;
            max-width: 600px;
            margin: auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color:rgb(223, 51, 108);
            text-align: center;
        }
        p {
            font-size: 18px;
        }
    </style>
</head>
<body>

<div class="container">
<?php
echo "<h1>Welcome to My PHP Project</h1>";
?>

<?php
echo "<p>Name: Sheila Mae</p>";
echo "<p>Age: 20</p>";
?>

<?php
print "<p>Sheila Mae is learning PHP!</p>";
?>

</div>

</body>
</html>
