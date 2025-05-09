<?php

session_start();


$revenue = '₱24,850';
$active_users = '1,253';
$conversion_rate = '12.3%';
$avg_session_time = '4m 32s';


function getUserTheme() {
    return $_COOKIE['theme'] ?? 'light';
}


if (isset($_POST['toggle_theme'])) {
    $new_theme = (getUserTheme() === 'dark') ? 'light' : 'dark';
    setcookie('theme', $new_theme, time() + 31536000, '/'); // 1 year expiration
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}


$active_page = $_GET['page'] ?? 'overview';
?>
<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>
  <link href="./Dashboard.css" rel="stylesheet">
  <script>
    
    document.addEventListener('DOMContentLoaded', function() {
      const themeToggle = document.getElementById('theme-toggle');
      
      
      if (document.cookie.includes('theme=dark')) {
        themeToggle.checked = true;
        document.body.classList.add('dark-theme');
      }
      
      
      themeToggle.addEventListener('change', function() {
        document.getElementById('theme-form').submit();
      });
    });
  </script>
</head>
<body<?php echo (getUserTheme() === 'dark') ? ' class="dark-theme"' : ''; ?>>
  <div class="dashboard">
    <div class="sidebar">
      <div class="admin-profile">
        <div class="admin-avatar">
          <img src="Anonymous-Profile-pic.jpg" alt="Admin Avatar">
        </div>
        <div class="admin-info">
          <div class="admin-name"><?php echo htmlspecialchars($admin_name); ?></div>
          <div class="admin-role"><?php echo htmlspecialchars($admin_role); ?></div>
        </div>
      </div>
      <div class="logo">Dashboard</div>
      <a href="?page=overview" class="nav-item <?php echo ($active_page === 'overview') ? 'active' : ''; ?>">Overview</a>
      <a href="?page=analytics" class="nav-item <?php echo ($active_page === 'analytics') ? 'active' : ''; ?>">Analytics</a>
      <a href="?page=reports" class="nav-item <?php echo ($active_page === 'reports') ? 'active' : ''; ?>">Reports</a>
      <a href="?page=settings" class="nav-item <?php echo ($active_page === 'settings') ? 'active' : ''; ?>">Settings</a>
      <a href="logout.php" class="nav-item logout">Logout</a>
    </div>
    
    <div class="main-content">
      <div class="header">
        <h1><?php echo ucfirst($active_page); ?></h1>
        <form id="theme-form" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
          <div class="theme-toggle-wrapper">
            <input type="checkbox" id="theme-toggle" name="toggle_theme" <?php echo (getUserTheme() === 'dark') ? 'checked' : ''; ?>>
            <label for="theme-toggle" class="theme-toggle-label"></label>
          </div>
          <input type="hidden" name="current_page" value="<?php echo htmlspecialchars($active_page); ?>">
        </form>
      </div>
      
      <?php if ($active_page === 'overview'): ?>
      <div class="cards-container">
        <div class="card">
          <div class="card-title">Total Revenue</div>
          <div class="card-value"><?php echo htmlspecialchars($revenue); ?></div>
        </div>
        <div class="card">
          <div class="card-title">Active Users</div>
          <div class="card-value"><?php echo htmlspecialchars($active_users); ?></div>
        </div>
        <div class="card">
          <div class="card-title">Conversion Rate</div>
          <div class="card-value"><?php echo htmlspecialchars($conversion_rate); ?></div>
        </div>
        <div class="card">
          <div class="card-title">Avg. Session Time</div>
          <div class="card-value"><?php echo htmlspecialchars($avg_session_time); ?></div>
        </div>
      </div>
      
      <div class="chart-container">
        <h2>Performance Overview</h2>
        <img src="diagram-bar-chart-bar-cbc0518cf97ab69ef5884f3f9f8a9520.png" alt="Chart placeholder" />
      </div>
      <?php elseif ($active_page === 'analytics'): ?>
        <div class="section">
          <h2>Detailed Analytics</h2>
          <p>This is the analytics page content. You can add charts, tables, and other analytics data here.</p>
       
        </div>
      <?php elseif ($active_page === 'reports'): ?>
        <div class="section">
          <h2>Reports</h2>
          <p>Generate and view reports here.</p>
         
        </div>
      <?php elseif ($active_page === 'settings'): ?>
        <div class="section">
          <h2>Settings</h2>
          <p>Manage your dashboard settings here.</p>
         
        </div>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>