<?php

session_start();


$error_message = '';
$username = '';


function getUserTheme() {
    return $_COOKIE['theme'] ?? 'light';
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $password = $_POST['password'] ?? '';
    $pin = $_POST['pin'] ?? '';
    
   
    if (empty($username) || empty($password) || empty($pin)) {
        $error_message = "All fields are required";
    } else {
    
        if ($username === "admin" && $password === "password" && $pin === "1234") {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = 1;
            $_SESSION['admin_name'] = "Admin User";
            $_SESSION['admin_role'] = "Administrator";
            
           
            header("Location: ../Dashboard.php");
            exit();
        } else {
            $error_message = "Invalid credentials";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="./loginAdmin.css" rel="stylesheet">
    <script>
        
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggle = document.getElementById('theme-toggle');
            
           
            if (document.cookie.includes('theme=dark')) {
                themeToggle.checked = true;
                document.documentElement.classList.add('dark-theme');
            }
            
            
            themeToggle.addEventListener('change', function() {
                if (this.checked) {
                    document.documentElement.classList.add('dark-theme');
                    document.cookie = "theme=dark; path=/; max-age=31536000"; // Save for 1 year
                } else {
                    document.documentElement.classList.remove('dark-theme');
                    document.cookie = "theme=light; path=/; max-age=31536000";
                }
            });
        });
    </script>
</head>
<body>
    <input type="checkbox" id="theme-toggle" <?php echo (getUserTheme() === 'dark') ? 'checked' : ''; ?>>
    <div class="page-wrapper <?php echo (getUserTheme() === 'dark') ? 'dark-theme' : ''; ?>">
        <div class="container">
            <div class="theme-switch">
                <label for="theme-toggle" class="theme-toggle-label">
                    <span class="sun">☀️</span>
                    <span class="moon">🌙</span>
                </label>
            </div>

            <h2>Admin Login</h2>
            
            <?php if (!empty($error_message)): ?>
                <div class="error-message">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="pin">PIN</label>
                    <input type="password" id="pin" name="pin" required>
                </div>
                
                <button type="submit">Login</button>
            </form>
            
            <div class="signup-link">
                Don't have an account? <a href="/Admin Registration/AdminRegistration.php">Sign Up</a> 
            </div>
            <div class="forgot-pass">
                <a href="forgotPassword.php">Forgot Password?</a>
            </div>
        </div>
    </div>
    

</body>
</html>