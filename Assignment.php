<?php
// Define some variables to demonstrate with
$pageTitle = "PHP Display Methods Demo";
$heading = "Welcome to PHP Text Display Demo";
$currentDate = date("F j, Y");
$randomNumber = rand(1, 100);
$fruits = ["Apple", "Banana", "Orange", "Mango", "Strawberry"];
$colors = ["#6a5acd", "#7b68ee", "#9370db", "#8a2be2", "#9932cc"];  // Purple palette for demo
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Using echo to output the page title -->
    <title><?php echo $pageTitle; ?></title>
    
    <!-- Google Fonts Import -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- Embedded CSS -->
    <style>
        :root {
            --primary-color: #6a5acd;
            --secondary-color: #7b68ee;
            --accent-color: #9370db;
            --background-color: #f8f9fa;
            --text-color: #2c2c2c;
            --light-accent: #e6e6fa;
            --highlight-color: #ffd700;
            --box-shadow: 0 10px 20px rgba(106, 90, 205, 0.1);
            --border-radius: 12px;
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.8;
            margin: 0;
            padding: 0;
            background-color: var(--background-color);
            color: var(--text-color);
            transition: all 0.3s ease;
        }
        
        .container {
            width: 92%;
            max-width: 1200px;
            margin: 2rem auto;
            background: linear-gradient(145deg, #ffffff, #f9f7ff);
            padding: 2rem;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
        }
        
        h1, h2, h3 {
            font-family: 'Playfair Display', serif;
            letter-spacing: 0.5px;
        }
        
        h1 {
            color: var(--primary-color);
            border-bottom: 3px solid var(--accent-color);
            padding-bottom: 1rem;
            margin-bottom: 2rem;
            font-size: 2.5rem;
            text-align: center;
        }
        
        h2 {
            color: var(--secondary-color);
            margin: 1.5rem 0 1rem;
            font-size: 1.8rem;
            position: relative;
            padding-left: 1rem;
        }
        
        h2::before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: var(--accent-color);
            border-radius: 4px;
        }

        .name{
            color: #ffd700;
            margin: 1.5rem 0 1rem;
            position: relative;
            padding-left: 1rem;
        }
        
        p {
            margin-bottom: 1rem;
            font-weight: 300;
        }
        
        strong {
            font-weight: 600;
            color: var(--primary-color);
        }
        
        .info-box {
            background-color: var(--light-accent);
            border-left: 4px solid var(--primary-color);
            padding: 1.2rem 1.5rem;
            margin: 1.5rem 0;
            border-radius: 0 var(--border-radius) var(--border-radius) 0;
            box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.05);
        }
        
        .section {
            margin-bottom: 2.5rem;
            padding: 1.5rem;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }
        
        .section:hover {
            transform: translateY(-5px);
        }
        
        .highlight {
            background-color: var(--highlight-color);
            color: var(--text-color);
            padding: 3px 6px;
            border-radius: 4px;
            font-weight: 500;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 1.5rem 0;
            overflow-x: auto;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        table, th, td {
            border: none;
        }
        
        th, td {
            padding: 1rem;
            text-align: left;
        }
        
        th {
            background-color: var(--primary-color);
            color: white;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 1px;
        }
        
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        
        tr:nth-child(odd) {
            background-color: white;
        }
        
        tr:hover {
            background-color: var(--light-accent);
        }
        
        footer {
            text-align: center;
            color: var(--secondary-color);
            font-size: 0.9rem;
            padding: 1rem;
            margin-top: 2rem;
        }
        
        /* Responsive design */
        @media screen and (max-width: 768px) {
            .container {
                width: 95%;
                padding: 1.5rem;
            }
            
            h1 {
                font-size: 2rem;
            }
            
            h2 {
                font-size: 1.5rem;
            }
            
            .section {
                padding: 1rem;
            }
            
            /* Make table responsive */
            .table-container {
                overflow-x: auto;
                margin: 1rem 0;
            }
            
            table {
                min-width: 600px;
            }
        }
        
        @media screen and (max-width: 480px) {
            .container {
                width: 98%;
                padding: 1rem;
                margin: 1rem auto;
            }
            
            h1 {
                font-size: 1.8rem;
                padding-bottom: 0.8rem;
            }
            
            h2 {
                font-size: 1.3rem;
            }
            
            p {
                font-size: 0.95rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Using echo for the main heading -->
        <h1><?php echo $heading; ?></h1>
        <h3 class="name">BY: CHRIS ORLEAN HIPE<h3>
        
        <div class="info-box">
            <!-- Using print to display the current date -->
            <p>Today's date: <?php print $currentDate; ?></p>
        </div>

        <div class="section">
            <h2>Echo vs Print in PHP</h2>
            <p>
                <!-- Using echo for a paragraph with HTML formatting -->
                <?php echo "The <span class='highlight'>echo</span> statement can output multiple strings separated by commas, and it doesn't return a value."; ?>
            </p>
            <p>
                <!-- Using print for another paragraph -->
                <?php print "The <span class='highlight'>print</span> statement can only output one string at a time, but it always returns 1, making it usable in expressions."; ?>
            </p>
        </div>

        <div class="section">
            <h2>Echo with Multiple Arguments</h2>
            <!-- Echo can take multiple parameters without parentheses -->
            <?php echo "<p>Echo can display ", "<strong>multiple</strong> ", "strings ", "without concatenation.</p>"; ?>
        </div>

        <div class="section">
            <h2>Using Print</h2>
            <!-- Print only takes one argument -->
            <p><?php print "Print always returns a value of 1: " . print("Hello!"); ?></p>
        </div>

        <div class="section">
            <h2>Displaying Variables</h2>
            <!-- Using echo with variable -->
            <p><?php echo "Random number generated: <strong>$randomNumber</strong>"; ?></p>
            
            <!-- Alternative syntax for echo -->
            <p><?= "This is a shorthand for echo (<?= ... ?>)" ?></p>
        </div>

        <div class="section">
            <h2>Combining HTML and PHP in a Loop</h2>
            <div class="table-container">
                <table>
                    <tr>
                        <th>Index</th>
                        <th>Fruit</th>
                        <th>Length</th>
                    </tr>
                    <?php 
                    // Using PHP to generate HTML table rows
                    foreach ($fruits as $index => $fruit) {
                        echo "<tr>";
                        echo "<td>" . $index . "</td>";
                        echo "<td>" . $fruit . "</td>";
                        // Using print inside the loop
                        print "<td>" . strlen($fruit) . " characters</td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
            </div>
        </div>

        <div class="section">
            <h2>PHP within HTML Attributes</h2>
            <!-- Using PHP inside HTML attributes -->
            <div class="info-box" style="background-color: <?php echo ($randomNumber > 50) ? '#e8f4fe' : '#f0fff0'; ?>">
                <?php 
                    if ($randomNumber > 50) {
                        echo "<p>The random number $randomNumber is greater than 50.</p>";
                    } else {
                        print "<p>The random number $randomNumber is less than or equal to 50.</p>";
                    }
                ?>
            </div>
        </div>

        <div class="section">
            <h2>Calculations with PHP</h2>
            <p>
                <?php echo "The sum of all digits in the random number $randomNumber is: "; ?>
                <span style="font-size: 1.2rem; font-weight: 600; color: var(--accent-color);">
                <?php
                    $sum = 0;
                    foreach (str_split($randomNumber) as $digit) {
                        $sum += (int)$digit;
                    }
                    print $sum;
                ?>
                </span>
            </p>
            
            <div style="margin-top: 1rem; background: white; padding: 1rem; border-radius: 8px;">
                <p style="margin-bottom: 0.5rem;">Visualization of the digits:</p>
                <div style="display: flex; flex-wrap: wrap; gap: 10px; justify-content: center;">
                    <?php
                        $digits = str_split($randomNumber);
                        foreach ($digits as $index => $digit) {
                            $colorIndex = $digit % count($colors);
                            echo "<div style='display: flex; justify-content: center; align-items: center; width: 40px; height: 40px; background-color: {$colors[$colorIndex]}; color: white; border-radius: 50%; font-weight: bold;'>";
                            print $digit;
                            echo "</div>";
                        }
                    ?>
                </div>
            </div>
        </div>

        <div class="section">
            <h2>Embedding PHP in JavaScript</h2>
            <script>
                // PHP can generate JavaScript code
                console.log("<?php echo "PHP can generate JavaScript - Random number: $randomNumber"; ?>");
            </script>
            <p>Check the browser console to see the JavaScript output.</p>
        </div>
    </div>

    <footer class="container" style="margin-top: 20px; text-align: center;">
        <div class="section" style="margin-bottom: 0;">
            <?php print "<p>&copy; " . date("Y") . " PHP Display Methods Demo</p>"; ?>
            <p>Made with <span style="color: #e25555;">♥</span> using PHP, HTML & CSS</p>
        </div>
    </footer>
</body>
</html>