<!DOCTYPE html>
<html>
<head>
    <title>PHP Echo vs Print</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            color: #333;
            padding: 40px;
            text-align: center;
        }
        .container {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            padding: 30px;
            max-width: 500px;
            margin: auto;
        }
        h1 {
            color:rgb(10, 87, 170);
        }
        p {
            font-size: 18px;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome!!</h1>
        <?php
            echo "<p>Hello Echo!<br>";
            echo "I am ", "Lore", "Jena mae</p>";
        ?>
        
        <?php
            print "<p>Hello Print!<br>";
            print "I am Jena mae Lore</p>";
        ?>
    </div>
</body>
</html>
