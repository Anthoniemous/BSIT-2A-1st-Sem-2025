<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Webpage_Restor Emanuel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: #f4f4f9;
        }
        header {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            text-align: center;
        }
        main {
            margin: 20px 0;
        }
        footer {
            text-align: center;
            margin-top: 20px;
            color: #555;
        }
    </style>
</head>
<body>
    <header>
        <?php 
            echo "<h1>Welcome to My Simple Webpage</h1>";
        ?>
    </header>
    <main>
        <p>
            <?php 
                print "This is a simple webpage created using HTML and PHP.";
            ?>
        </p>
        <p>
            <?php 
                echo "PHP is a powerful scripting language for web development.";
            ?>
        </p>
    </main>
    <footer>
        <?php 
            print "&copy; " . date("Y") . " My Simple Webpage. All rights reserved.";
        ?>
    </footer>
</body>
</html>