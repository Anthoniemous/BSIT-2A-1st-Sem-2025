<?php
// Start the session for user preferences
session_start();

// Helper functions
function getSavedTheme() {
    return isset($_COOKIE['theme']) ? $_COOKIE['theme'] : 'light';
}

// Set default theme if not already set
$theme = getSavedTheme();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MusicHub | Your Music, Your Way</title>
    <link rel="stylesheet" href="music-web.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body<?php echo ($theme == 'dark') ? ' class="dark-mode"' : ''; ?>>
    <!-- Navigation Bar -->
    <nav>
        <button class="menu-toggle" id="menu-toggle">
            <i class="fas fa-bars"></i>
        </button>
        
        <div class="logo">
            <i class="fas fa-headphones-alt"></i>
            <span>MusicHub</span>
        </div>
        
        <ul class="nav-links" id="nav-links">
            <li><a href="#" data-section="home" class="active">Discover</a></li>
            <li><a href="#" data-section="trending">Trending</a></li>
            <li><a href="#" data-section="playlists">Your Library</a></li>
            <li><a href="#" data-section="genres">Genres</a></li>
        </ul>
        
        <div class="nav-controls">
            <div class="search-container">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="search" placeholder="Search songs, artists...">
            </div>
            <button id="search-toggle" class="action-btn">
                <i class="fas fa-search"></i>
            </button>
            <button id="theme-toggle" title="Toggle dark mode">
                <i class="fas fa-<?php echo ($theme == 'dark') ? 'sun' : 'moon'; ?>"></i>
            </button>
            
            <!-- User Profile Dropdown -->
            <div class="user-profile-container">
                <button id="user-profile-toggle" class="user-profile-toggle">
                    <div class="user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <span id="user-display-name">User</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div id="user-dropdown" class="user-dropdown">
                    <div class="user-info">
                        <div class="user-avatar-large">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="user-details">
                            <div id="user-full-name" class="user-full-name">User Name</div>
                            <div id="user-email" class="user-email">user@example.com</div>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <ul class="dropdown-menu">
                        <li><a href="#"><i class="fas fa-user-circle"></i> View Profile</a></li>
                        <li><a href="#"><i class="fas fa-cog"></i> Settings</a></li>
                        <li><a href="#" id="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Home Section -->
    <div id="home" class="section">
        <div class="section-header">
            <h2 class="section-title">
                <i class="fas fa-compass"></i> Discover New Music
            </h2>
            <div class="controls">
                <button class="control-btn" id="refresh-discover">
                    <i class="fas fa-sync-alt"></i> Refresh
                </button>
                <select id="discover-filter" class="control-btn">
                    <option value="all">All Genres</option>
                    <option value="pop">Pop</option>
                    <option value="rock">Rock</option>
                    <option value="hip-hop">Hip Hop</option>
                    <option value="electronic">Electronic</option>
                </select>
            </div>
        </div>
        <div class="music-container" id="music-container">
            <?php include('includes/loading-placeholder.php'); ?>
        </div>
    </div>

    <!-- Trending Section -->
    <div id="trending" class="hidden section">
        <div class="section-header">
            <h2 class="section-title">
                <i class="fas fa-fire"></i> Trending Now
            </h2>
            <div class="controls">
                <button class="control-btn" id="refresh-trending">
                    <i class="fas fa-sync-alt"></i> Refresh
                </button>
                <select id="trending-period" class="control-btn">
                    <option value="day">Today</option>
                    <option value="week" selected>This Week</option>
                    <option value="month">This Month</option>
                </select>
            </div>
        </div>
        <div class="music-container" id="trending-container">
            <?php include('includes/loading-placeholder.php'); ?>
        </div>
    </div>

    <!-- Playlists Section -->
    <div id="playlists" class="hidden section">
        <div class="section-header">
            <h2 class="section-title">
                <i class="fas fa-list"></i> Your Library
            </h2>
            <div class="controls">
                <button class="control-btn" id="clear-playlist">
                    <i class="fas fa-trash"></i> Clear
                </button>
                <button class="control-btn" id="sort-playlist">
                    <i class="fas fa-sort"></i> Sort
                </button>
            </div>
        </div>
        <div class="music-container" id="playlist-container">
            <?php
            // Get playlist from cookies and render them
            if (isset($_COOKIE['playlist']) && !empty($_COOKIE['playlist'])) {
                $playlist = json_decode($_COOKIE['playlist'], true);
                if (empty($playlist)) {
                    include('includes/empty-playlist.php');
                }
            } else {
                include('includes/empty-playlist.php');
            }
            ?>
        </div>
    </div>
    
    <!-- Genres Section -->
    <div id="genres" class="hidden section">
        <div class="section-header">
            <h2 class="section-title">
                <i class="fas fa-guitar"></i> Browse Genres
            </h2>
        </div>
        <div class="music-container" id="genres-container">
            <?php include('includes/genres.php'); ?>
        </div>
    </div>

    <!-- Player Bar -->
    <div class="player-bar" id="player-bar">
        <div class="now-playing">
            <img id="current-song-img" src="/api/placeholder/48/48" alt="Now playing">
            <div class="now-playing-info">
                <div class="now-playing-title" id="current-song-title">Not Playing</div>
                <div class="now-playing-artist" id="current-song-artist">Select a song</div>
            </div>
        </div>
        
        <div class="player-controls">
            <div class="player-buttons">
                <button class="player-btn" id="shuffle-btn" title="Shuffle">
                    <i class="fas fa-random"></i>
                </button>
                <button class="player-btn" id="prev-btn" title="Previous">
                    <i class="fas fa-step-backward"></i>
                </button>
                <button class="player-btn primary" id="play-pause-btn" title="Play/Pause">
                    <i class="fas fa-play" id="play-icon"></i>
                </button>
                <button class="player-btn" id="next-btn" title="Next">
                    <i class="fas fa-step-forward"></i>
                </button>
                <button class="player-btn" id="repeat-btn" title="Repeat">
                    <i class="fas fa-repeat"></i>
                </button>
            </div>
            
            <div class="player-progress">
                <div class="progress-container">
                    <span class="time" id="current-time">0:00</span>
                    <div class="audio-progress" id="player-progress-bar">
                        <div class="progress-bar" id="player-progress"></div>
                    </div>
                    <span class="time" id="duration">0:00</span>
                </div>
            </div>
        </div>
        
        <div class="player-volume">
            <button class="player-btn" id="mute-btn">
                <i class="fas fa-volume-up" id="volume-icon"></i>
            </button>
            <div class="volume-slider" id="volume-slider">
                <div class="volume-progress" id="volume-progress"></div>
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container" id="toast-container"></div>
    
    <!-- Hidden audio element for playing music -->
    <audio id="audio-player"></audio>

    <script src="music-web.js"></script>
    
    <!-- User Profile JavaScript -->
    <script>
    // User Profile Management Functions
    document.addEventListener('DOMContentLoaded', function() {
        // User profile dropdown toggle
        const userProfileToggle = document.getElementById('user-profile-toggle');
        const userDropdown = document.getElementById('user-dropdown');
        const logoutBtn = document.getElementById('logout-btn');
        
        // Function to load user data from localStorage
        function loadUserData() {
            // Check if we have user data in localStorage
            let userData = null;
            
            try {
                // Based on the browser console screenshot, accessing the 'users' data
                const usersStr = localStorage.getItem('users');
                if (usersStr) {
                    try {
                        const users = JSON.parse(usersStr);
                        // The users data from your screenshot appears to be an array
                        if (Array.isArray(users) && users.length > 0) {
                            // Use the first user as the logged-in user
                            userData = users[0];
                        }
                    } catch (e) {
                        console.error('Error parsing users data:', e);
                    }
                }
                
                return userData;
            } catch (error) {
                console.error('Error loading user data:', error);
                return null;
            }
        }
        
        // Function to display user data
        function displayUserData() {
            const userData = loadUserData();
            const userDisplayName = document.getElementById('user-display-name');
            const userFullName = document.getElementById('user-full-name');
            const userEmail = document.getElementById('user-email');
            
            if (userData) {
                // Display first name in navigation
                if (userData.firstName) {
                    userDisplayName.textContent = userData.firstName;
                } else {
                    userDisplayName.textContent = userData.username || 'User';
                }
                
                // Set full name in dropdown
                if (userData.firstName && userData.lastName) {
                    userFullName.textContent = `${userData.firstName} ${userData.lastName}`;
                } else {
                    userFullName.textContent = userData.username || 'User';
                }
                
                // Set email
                if (userData.primaryEmail) {
                    userEmail.textContent = userData.primaryEmail;
                } else if (userData.secondaryEmail) {
                    userEmail.textContent = userData.secondaryEmail;
                } else {
                    userEmail.textContent = 'No email available';
                }
            } else {
                // Default values if no user data found
                userDisplayName.textContent = 'Guest';
                userFullName.textContent = 'Guest User';
                userEmail.textContent = 'Not signed in';
            }
        }
        
        // Toggle dropdown visibility
        if (userProfileToggle) {
            userProfileToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                userDropdown.classList.toggle('show');
            });
        }
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (userDropdown && userDropdown.classList.contains('show') && !userDropdown.contains(e.target)) {
                userDropdown.classList.remove('show');
            }
        });
        
        // Logout functionality
        if (logoutBtn) {
            logoutBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Create a toast notification
                const toastContainer = document.getElementById('toast-container');
                if (toastContainer) {
                    const toast = document.createElement('div');
                    toast.className = 'toast success';
                    toast.innerHTML = `
                        <div class="toast-content">
                            <i class="fas fa-check-circle"></i>
                            <span>Logged out successfully</span>
                        </div>
                        <button class="toast-close"><i class="fas fa-times"></i></button>
                    `;
                    toastContainer.appendChild(toast);
                    
                    // Add event listener to close button
                    const closeBtn = toast.querySelector('.toast-close');
                    if (closeBtn) {
                        closeBtn.addEventListener('click', () => {
                            toast.remove();
                        });
                    }
                    
                    // Auto remove after 3 seconds
                    setTimeout(() => {
                        toast.remove();
                    }, 3000);
                }
                
                // Redirect to login page after a short delay
                setTimeout(() => {
                    window.location.href = 'login.php'; // Change to your login page URL
                }, 1500);
            });
        }
        
        // Load user data when page loads
        displayUserData();
    });
    </script>
</body>
</html>