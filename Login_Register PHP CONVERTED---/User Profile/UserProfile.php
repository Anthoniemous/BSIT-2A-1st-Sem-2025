<?php

session_start();


$userData = [
    'username' => $_SESSION['username'] ?? 'Chris Orlean Hipe',
    'job_title' => $_SESSION['job_title'] ?? 'Web Designer',
    'profile_image' => $_SESSION['profile_image'] ?? './Anonymous-Profile-pic.jpg',
    'projects' => $_SESSION['projects'] ?? 152,
    'followers' => $_SESSION['followers'] ?? '3.2k',
    'collections' => $_SESSION['collections'] ?? 28
];

if (isset($_POST['logout'])) {
   
    session_unset();
    session_destroy();
    
    header("Location: /Login User/Log.php");
    exit();
}


if (isset($_POST['settings'])) {
    header("Location: settings.php");
    exit();
}

if (isset($_POST['change_password'])) {
    header("Location: change_password.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="./UserProfile.css" rel="stylesheet">
</head>
<body>
    <input type="checkbox" id="theme-toggle" onchange="document.body.classList.toggle('dark-mode')">
    <label class="theme-switch" for="theme-toggle">
        <div class="switch">
            <span class="slider">
                <div class="icons">
                    <span class="sun">☀️</span>
                    <span class="moon">🌙</span>
                </div>
            </span>
        </div>
    </label>

    <div class="profile-card">
        <img src="<?php echo htmlspecialchars($userData['profile_image']); ?>" alt="Profile Picture" class="profile-image">
        <h1 class="profile-name"><?php echo htmlspecialchars($userData['username']); ?></h1>
        <p class="profile-title"><?php echo htmlspecialchars($userData['job_title']); ?></p>
        
        <div class="profile-stats">
            <div class="stat">
                <div class="stat-value"><?php echo htmlspecialchars($userData['projects']); ?></div>
                <div class="stat-label">Projects</div>
            </div>
            <div class="stat">
                <div class="stat-value"><?php echo htmlspecialchars($userData['followers']); ?></div>
                <div class="stat-label">Followers</div>
            </div>
            <div class="stat">
                <div class="stat-value"><?php echo htmlspecialchars($userData['collections']); ?></div>
                <div class="stat-label">Collections</div>
            </div>
        </div>

        <div class="profile-actions">
            <form method="post" style="display: inline;">
                <button type="submit" name="settings" class="profile-button">Settings</button>
            </form>
            <form method="post" style="display: inline;">
                <button type="submit" name="change_password" class="profile-button">Change Password</button>
            </form>
            <form method="post" style="display: inline;">
                <button type="submit" name="logout" class="profile-button logout-button">Logout</button>
            </form>
        </div>
    </div>
    
    <script>
        
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggle = document.getElementById('theme-toggle');
            
           
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark') {
                document.body.classList.add('dark-mode');
                themeToggle.checked = true;
            }
            
           
            themeToggle.addEventListener('change', function() {
                if (this.checked) {
                    localStorage.setItem('theme', 'dark');
                } else {
                    localStorage.setItem('theme', 'light');
                }
            });
        });
    </script>
</body>
</html>