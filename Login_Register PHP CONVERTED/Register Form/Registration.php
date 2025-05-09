<?php

$username = $password = $firstName = $lastName = $dob = $address = $primaryEmail = $secondaryEmail = "";
$errors = [];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $username = trim(htmlspecialchars($_POST["username"] ?? ""));
    $password = $_POST["password"] ?? "";
    $firstName = trim(htmlspecialchars($_POST["firstName"] ?? ""));
    $lastName = trim(htmlspecialchars($_POST["lastName"] ?? ""));
    $dob = $_POST["dob"] ?? "";
    $address = trim(htmlspecialchars($_POST["address"] ?? ""));
    $primaryEmail = trim(filter_var($_POST["primaryEmail"] ?? "", FILTER_SANITIZE_EMAIL));
    $secondaryEmail = trim(filter_var($_POST["secondaryEmail"] ?? "", FILTER_SANITIZE_EMAIL));
    
  
    if (empty($username)) {
        $errors[] = "Username is required";
    }
    
    if (empty($password)) {
        $errors[] = "Password is required";
    }
    
    if (empty($firstName)) {
        $errors[] = "First Name is required";
    }
    
    if (empty($lastName)) {
        $errors[] = "Last Name is required";
    }
    
    if (empty($dob)) {
        $errors[] = "Date of Birth is required";
    }
    
    if (empty($address)) {
        $errors[] = "Address is required";
    }
    
    if (empty($primaryEmail)) {
        $errors[] = "Primary Email is required";
    } elseif (!filter_var($primaryEmail, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid primary email format";
    }
    
    if (!empty($secondaryEmail) && !filter_var($secondaryEmail, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid secondary email format";
    }
    
   
    if (empty($errors)) {
       
        $successMessage = "Registration successful! Account created for $username.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration Form</title>
    <link rel="stylesheet" href="./Registration.css">
    <style>
        .error-message {
            color: red;
            margin-bottom: 15px;
        }
        .success-message {
            color: green;
            margin-bottom: 15px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="theme-switch">
        <input type="checkbox" id="theme-toggle" class="theme-toggle-input">
        <label for="theme-toggle" class="theme-toggle-label">
            <span class="sun">☀️</span>
            <span class="moon">🌙</span>
        </label>
    </div>
    <div class="container">
        <h2>User Registration</h2>
        
        <?php if (!empty($errors)): ?>
            <div class="error-message">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($successMessage)): ?>
            <div class="success-message">
                <p><?php echo $successMessage; ?></p>
            </div>
        <?php endif; ?>
        
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-grid">
                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="<?php echo $username; ?>" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="input-group">
                    <label for="firstName">First Name</label>
                    <input type="text" id="firstName" name="firstName" value="<?php echo $firstName; ?>" required>
                </div>
                <div class="input-group">
                    <label for="lastName">Last Name</label>
                    <input type="text" id="lastName" name="lastName" value="<?php echo $lastName; ?>" required>
                </div>
                <div class="input-group">
                    <label for="dob">Date of Birth</label>
                    <input type="date" id="dob" name="dob" value="<?php echo $dob; ?>" required>
                </div>
                <div class="input-group">
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" value="<?php echo $address; ?>" required>
                </div>
                <div class="input-group">
                    <label for="primaryEmail">Primary Email</label>
                    <input type="email" id="primaryEmail" name="primaryEmail" value="<?php echo $primaryEmail; ?>" required>
                </div>
                <div class="input-group">
                    <label for="secondaryEmail">Secondary Email</label>
                    <input type="email" id="secondaryEmail" name="secondaryEmail" value="<?php echo $secondaryEmail; ?>">
                </div>
            </div>
            <button type="submit">Create Account</button>
            <div class="login-link">
                Already have an account? | <a href="/Login User/Log.html">Login</a>
            </div>
        </form>
    </div>
    
    <script>
       
        const themeToggle = document.getElementById('theme-toggle');
        
        const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');
        const currentTheme = localStorage.getItem('theme');
        
        if (currentTheme === 'dark' || (!currentTheme && prefersDarkScheme.matches)) {
            document.body.classList.add('dark-theme');
            themeToggle.checked = true;
        }
        
        themeToggle.addEventListener('change', function() {
            if (this.checked) {
                document.body.classList.add('dark-theme');
                localStorage.setItem('theme', 'dark');
            } else {
                document.body.classList.remove('dark-theme');
                localStorage.setItem('theme', 'light');
            }
        });
    </script>
</body>
</html>