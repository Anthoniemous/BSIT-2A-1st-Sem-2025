<?php

session_start();


$errors = [];
$formData = [
    'username' => '',
    'firstName' => '',
    'lastName' => '',
    'dob' => '',
    'address' => '',
    'primaryEmail' => '',
    'secondaryEmail' => '',
    'pin' => ''
];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $formData['username'] = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';
    $formData['firstName'] = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_SPECIAL_CHARS);
    $formData['lastName'] = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_SPECIAL_CHARS);
    $formData['dob'] = filter_input(INPUT_POST, 'dob', FILTER_SANITIZE_SPECIAL_CHARS);
    $formData['address'] = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS);
    $formData['primaryEmail'] = filter_input(INPUT_POST, 'primaryEmail', FILTER_SANITIZE_EMAIL);
    $formData['secondaryEmail'] = filter_input(INPUT_POST, 'secondaryEmail', FILTER_SANITIZE_EMAIL);
    $formData['pin'] = filter_input(INPUT_POST, 'pin', FILTER_SANITIZE_SPECIAL_CHARS);
    $confirmPin = $_POST['confirmPin'] ?? '';
    
    
    if (empty($formData['username'])) {
        $errors[] = "Username is required";
    }
    if (empty($password)) {
        $errors[] = "Password is required";
    }
    if (empty($formData['firstName'])) {
        $errors[] = "First name is required";
    }
    if (empty($formData['lastName'])) {
        $errors[] = "Last name is required";
    }
    if (empty($formData['dob'])) {
        $errors[] = "Date of birth is required";
    }
    if (empty($formData['address'])) {
        $errors[] = "Address is required";
    }
    if (empty($formData['primaryEmail']) || !filter_var($formData['primaryEmail'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid primary email is required";
    }
    if (!empty($formData['secondaryEmail']) && !filter_var($formData['secondaryEmail'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Secondary email must be valid if provided";
    }
    if (empty($formData['pin'])) {
        $errors[] = "Admin PIN is required";
    }
    
   
    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match";
    }
    
    
    if ($formData['pin'] !== $confirmPin) {
        $errors[] = "PINs do not match";
    }
    
    
    if (empty($errors)) {
        
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $_SESSION['success_message'] = "Registration successful! You can now log in.";
        
       
        header("Location: Login Admin/loginAdmin.php");
        exit();
    }
}


function getUserTheme() {
    return $_COOKIE['theme'] ?? 'light';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration Form</title>
    <link rel="stylesheet" href="./AdminRegistration.css">
    <script>
       
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggle = document.getElementById('theme-toggle');
            
            
            if (document.cookie.includes('theme=dark')) {
                themeToggle.checked = true;
                document.body.classList.add('dark-theme');
            }
            
          
            themeToggle.addEventListener('change', function() {
                if (this.checked) {
                    document.body.classList.add('dark-theme');
                    document.cookie = "theme=dark; path=/; max-age=31536000"; // Save for 1 year
                } else {
                    document.body.classList.remove('dark-theme');
                    document.cookie = "theme=light; path=/; max-age=31536000";
                }
            });
        });
    </script>
</head>
<body<?php echo (getUserTheme() === 'dark') ? ' class="dark-theme"' : ''; ?>>
    <div class="theme-switch">
        <input type="checkbox" id="theme-toggle" class="theme-toggle-input" <?php echo (getUserTheme() === 'dark') ? 'checked' : ''; ?>>
        <label for="theme-toggle" class="theme-toggle-label">
            <span class="sun">☀️</span>
            <span class="moon">🌙</span>
        </label>
    </div>
    <div class="container">
        <h2>Admin Registration</h2>
        
        <?php if (!empty($errors)): ?>
            <div class="error-container">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="form-grid">
                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($formData['username']); ?>" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="input-group">
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" required>
                </div>
                <div class="input-group">
                    <label for="firstName">First Name</label>
                    <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($formData['firstName']); ?>" required>
                </div>
                <div class="input-group">
                    <label for="lastName">Last Name</label>
                    <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($formData['lastName']); ?>" required>
                </div>
                <div class="input-group">
                    <label for="dob">Date of Birth</label>
                    <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($formData['dob']); ?>" required>
                </div>
                <div class="input-group">
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($formData['address']); ?>" required>
                </div>
                <div class="input-group">
                    <label for="primaryEmail">Primary Email</label>
                    <input type="email" id="primaryEmail" name="primaryEmail" value="<?php echo htmlspecialchars($formData['primaryEmail']); ?>" required>
                </div>
                <div class="input-group">
                    <label for="secondaryEmail">Secondary Email</label>
                    <input type="email" id="secondaryEmail" name="secondaryEmail" value="<?php echo htmlspecialchars($formData['secondaryEmail']); ?>">
                </div>
                <div class="input-group">
                    <label for="pin">Admin PIN</label>
                    <input type="password" id="pin" name="pin" required>
                </div>
                <div class="input-group">
                    <label for="confirmPin">Confirm Admin PIN</label>
                    <input type="password" id="confirmPin" name="confirmPin" required>
                </div>
            </div>
            <button type="submit">Create Account</button>
            <div class="login-link">
                Already have an account? | <a href="Login Admin/loginAdmin.php">Login</a>
            </div>
        </form>
    </div>
</body>
</html>