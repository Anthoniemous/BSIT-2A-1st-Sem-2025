<?php

session_start();

$user_name = 'Chris Orlean Hipe';
$role = 'Web Developer';
$projects = '254';
$users = '12k';
$rating = '98%';


function getUserTheme() {
    return $_COOKIE['theme'] ?? 'light';
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Profile</title>
  <link href="./adminProfile.css" rel="stylesheet">
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
  <div class="theme-toggle-wrapper">
    <input type="checkbox" id="theme-toggle" class="theme-toggle" <?php echo (getUserTheme() === 'dark') ? 'checked' : ''; ?>>
    <label for="theme-toggle" class="theme-toggle-label"></label>
  </div>

  <div class="profile-card">
    <div class="cover-photo">
      <div class="profile-avatar">
        <img src="./Anonymous-Profile-pic.jpg" alt="Admin Avatar">
      </div>
    </div>
    
    <div class="profile-info">
      <div class="profile-name"><?php echo htmlspecialchars($user_name); ?></div>
      <div class="profile-role"><?php echo htmlspecialchars($role); ?></div>
    </div>

    <div class="profile-stats">
      <div class="stat-item">
        <div class="stat-value"><?php echo htmlspecialchars($projects); ?></div>
        <div class="stat-label">Projects</div>
      </div>
      <div class="stat-item">
        <div class="stat-value"><?php echo htmlspecialchars($users); ?></div>
        <div class="stat-label">Users</div>
      </div>
      <div class="stat-item">
        <div class="stat-value"><?php echo htmlspecialchars($rating); ?></div>
        <div class="stat-label">Rating</div>
      </div>
    </div>

    <div class="profile-actions">
      <button class="action-button primary-button" onclick="location.href='editProfile.php';">Edit Profile</button>
      <button class="action-button secondary-button" onclick="location.href='settings.php';">Settings</button>
    </div>
  </div>
</body>
</html>