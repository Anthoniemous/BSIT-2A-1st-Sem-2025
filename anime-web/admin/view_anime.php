<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Fetch exercises from API
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.api-ninjas.com/v1/exercises?muscle=biceps',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'X-Api-Key: XJ9rom790MwZzP1DVplIJw==q3IVeWX6llmOW0zF'
    ),
));

$response = curl_exec($curl);
curl_close($curl);

$exercises = json_decode($response, true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View All Exercises</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #1e1e2f;
            color: #fff;
            margin: 0;
            padding: 0;
        }

        .dashboard-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 1rem;
        }

        h1 {
            text-align: center;
            margin-bottom: 2rem;
        }

        .anime-list-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }

        .anime-card {
            background: #2d2d44;
            border-radius: 8px;
            padding: 1rem;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            transition: transform 0.2s ease;
        }

        .anime-card:hover {
            transform: scale(1.02);
        }

        .anime-card img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            margin-bottom: 0.5rem;
        }

        .anime-card h3 {
            margin: 0.5rem 0;
            font-size: 1.2rem;
        }

        .anime-card p {
            font-size: 0.95rem;
            margin: 0.3rem 0;
            line-height: 1.4;
        }

        .logout-btn {
            display: inline-block;
            margin-top: 2rem;
            padding: 0.6rem 1.2rem;
            background: #ff4b5c;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }

        .logout-btn:hover {
            background: #ff1e35;
        }
    </style>
</head>
<body>
<div class="dashboard-container">
    <h1>All Biceps Exercises</h1>

    <div class="anime-list-grid">
        <?php if (is_array($exercises)): ?>
            <?php foreach ($exercises as $ex): ?>
                <div class="anime-card">
                    <img src="https://via.placeholder.com/300x150?text=Exercise" alt="Exercise">
                    <h3><?= htmlspecialchars($ex['name']) ?></h3>
                    <p><strong>Type:</strong> <?= htmlspecialchars($ex['type']) ?></p>
                    <p><strong>Muscle:</strong> <?= htmlspecialchars($ex['muscle']) ?></p>
                    <p><strong>Difficulty:</strong> <?= htmlspecialchars($ex['difficulty']) ?></p>
                    <p><strong>Instructions:</strong><br><?= nl2br(htmlspecialchars($ex['instructions'])) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Error loading exercises from API.</p>
        <?php endif; ?>
    </div>

    <a class="logout-btn" href="dashboard.php">← Back to Dashboard</a>
</div>
</body>
</html>
