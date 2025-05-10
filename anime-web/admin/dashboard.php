<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
$avatar = isset($_SESSION['avatar']) && $_SESSION['avatar'] != ''
    ? '../uploads/avatars/' . $_SESSION['avatar']
    : '../assets/default-avatar.png'; // fallback image
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            background-color: #1e1e2f;
            color: #fff;
        }

        .user-info {
            position: relative;
            display: flex;
            align-items: center;
        }

        .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            margin-left: 10px;
        }

        .dropdown {
            position: absolute;
            top: 60px;
            right: 0;
            background: #fff;
            border: 1px solid #ccc;
            flex-direction: column;
            min-width: 160px;
            z-index: 1000;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 6px;
            display: none;
        }

        .dropdown.show {
            display: flex;
        }

        .dropdown a {
            padding: 10px;
            text-decoration: none;
            color: #333;
            border-bottom: 1px solid #eee;
        }

        a#toUpdate, a#toLogout {
            background: white;
            border-radius: 5px;
        }

        a#toUpdate:hover {
            background: #007bff;
            border-radius: 5px;
        }

        a#toLogout:hover {
            background:rgb(254, 77, 7);
            border-radius: 5px;
        }

        /* .user-info:hover .dropdown,
            .dropdown:hover {
                display: flex;
            } */


        .dashboard-container {
            text-align: center;
            margin-top: 50px;
        }

        .dashboard-actions {
            margin-top: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }

        .dashboard-actions a {
            font-size: 18px;
            text-decoration: none;
            color: #007bff;
        }

        .logout-btn {
            display: none;
        }
    </style>
</head>
<body class="dashboard">

    <!-- Header -->
    <div class="header">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h2>
        <div class="user-info">
            <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
            <img id="avatar" src="<?php echo $avatar; ?>" alt="Avatar" width="50">
            <!-- <img id="avatar" src="uploads/avatars/<?php echo htmlspecialchars($_SESSION['avatar']); ?>" alt="Avatar" width="50"> -->

            <div id="dropdown" class="dropdown">
                <a id="toUpdate" href="update_account.php">Update Account</a>
                <a id="toLogout" href="../logout.php">Logout</a>
            </div>
        </div>

    </div>

    <!-- Dashboard Content -->
    <div class="dashboard-container">
        <p>This is your admin dashboard where you can manage anime movies and users.</p>
        
        <div class="dashboard-actions">
            <a href="add_anime.php">➕ Add Anime Movie</a>
            <a href="manage_users.php">👤 Manage Users</a>
            <a href="view_anime.php">🎬 View All Anime</a>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const avatar = document.getElementById('avatar');
            const dropdown = document.getElementById('dropdown');

            avatar.addEventListener('click', function (e) {
                dropdown.classList.toggle('show');
                e.stopPropagation(); // prevent click from bubbling up
            });

            // Hide dropdown if user clicks outside
            document.addEventListener('click', function () {
                dropdown.classList.remove('show');
            });

            // Prevent dropdown clicks from closing it
            dropdown.addEventListener('click', function (e) {
                e.stopPropagation();
            });
        });
    </script>

</body>
</html>
