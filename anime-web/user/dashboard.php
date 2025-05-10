<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../login.php");
    exit();
}

include '../includes/db.php';

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT username, email, avatar FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #121212;
            color: #fff;
            font-family: 'Poppins', sans-serif;
            padding: 40px;
        }

        .dashboard-container {
            max-width: 700px;
            margin: auto;
            background: #1f1f2e;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.4);
        }

        h1, h2 {
            text-align: center;
        }

        .anime-list {
            list-style: none;
            padding: 0;
        }

        .anime-list li {
            background: #29293d;
            padding: 10px;
            margin: 5px 0;
            border-radius: 8px;
        }

        .dashboard-section {
            margin-top: 30px;
        }

        .toggle-btn {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
        }

        .toggle-btn:hover {
            background: #0056b3;
        }

        .user-info-form {
            display: none;
            flex-direction: column;
            margin-top: 20px;
        }

        .user-info-form label {
            margin: 10px 0 5px;
        }

        .user-info-form input[type="text"],
        .user-info-form input[type="email"],
        .user-info-form input[type="file"] {
            padding: 10px;
            background-color: #2e2e3f;
            border: none;
            border-radius: 6px;
            color: #fff;
        }

        .user-info-form button {
            margin-top: 15px;
            background-color: #28a745;
            border: none;
            color: #fff;
            padding: 10px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }

        .user-info-form button:hover {
            background-color: #218838;
        }

        .avatar {
            display: block;
            margin: 10px auto;
            border-radius: 50%;
            max-width: 120px;
            max-height: 120px;
            object-fit: cover;
            border: 3px solid #fff;
        }

        .logout-btn {
            display: block;
            margin: 30px auto 0;
            text-align: center;
            color: #ff4d4d;
            text-decoration: none;
            font-weight: 600;
        }

        .logout-btn:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="dashboard-container">
    <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h1>

    <?php if (!empty($user['avatar'])): ?>
        <img src="../uploads/avatars/<?php echo htmlspecialchars($user['avatar']); ?>" class="avatar" alt="Avatar">
    <?php endif; ?>

    <button class="toggle-btn" onclick="toggleInfo()">👤 Show/Hide Account Info</button>

    <div class="dashboard-section">
    <h2>🗓️ Your Scheduled Exercises</h2>
    <ul id="scheduleList"></ul>
</div>

<div class="dashboard-section">
    <h2>💪 Browse Biceps Exercises</h2>
    <div class="carousel-wrapper">
        <div id="exerciseCarousel" class="carousel-track"></div>
    </div>
</div>

<style>
.carousel-wrapper {
    overflow-x: auto;
    white-space: nowrap;
    padding: 10px 0;
}

.carousel-track {
    display: flex;
    gap: 15px;
}

.exercise-card {
    background: #29293d;
    color: #fff;
    border-radius: 8px;
    padding: 15px;
    min-width: 250px;
    position: relative;
    display: inline-block;
    vertical-align: top;
    box-shadow: 0 0 8px rgba(0,0,0,0.4);
}

.exercise-card h4 {
    margin: 0 0 5px;
}

.exercise-card small {
    display: block;
    color: #ccc;
    font-size: 0.9rem;
    margin-bottom: 8px;
}

.exercise-details {
    display: none;
    margin-top: 10px;
    font-size: 0.85rem;
    line-height: 1.4;
}

.exercise-card button {
    background: #007bff;
    color: white;
    border: none;
    padding: 6px 10px;
    border-radius: 4px;
    cursor: pointer;
}

.exercise-card button:hover {
    background: #0056b3;
}
</style>

</div>


    <a class="logout-btn" href="../logout.php">Logout</a>
</div>

<script>
function toggleInfo() {
    const form = document.getElementById('infoForm');
    form.style.display = form.style.display === 'flex' ? 'none' : 'flex';
}

document.addEventListener("DOMContentLoaded", () => {
    const scheduleList = document.getElementById('scheduleList');
    const exerciseCarousel = document.getElementById('exerciseCarousel');

    // Load saved schedule from localStorage
    const savedSchedule = JSON.parse(localStorage.getItem("userSchedule")) || [];
    renderSchedule(savedSchedule);

    fetch('https://api.api-ninjas.com/v1/exercises?muscle=biceps', {
        headers: { 'X-Api-Key': 'XJ9rom790MwZzP1DVplIJw==q3IVeWX6llmOW0zF' }
    })
    .then(res => res.json())
    .then(data => {
        data.forEach((ex, idx) => {
            const card = document.createElement('div');
            card.className = 'exercise-card';

            card.innerHTML = `
                <h4>${ex.name}</h4>
                <small>Difficulty: ${ex.difficulty}</small>
                <input type="date" id="date_${idx}" style="margin-bottom: 5px;" />
                <button onclick="saveSchedule('${ex.name}', 'date_${idx}')">Schedule</button>
                <button onclick="toggleDetails(this)">View More</button>
                <div class="exercise-details">
                    <strong>Type:</strong> ${ex.type}<br>
                    <strong>Muscle:</strong> ${ex.muscle}<br>
                    <strong>Instructions:</strong><br> ${ex.instructions}
                </div>
            `;
            exerciseCarousel.appendChild(card);
        });
    })
    .catch(err => {
        exerciseCarousel.innerHTML = "<p style='color:red'>Failed to load exercises.</p>";
        console.error(err);
    });

    window.saveSchedule = (exerciseName, dateId) => {
        const date = document.getElementById(dateId).value;
        if (!date) {
            alert("Please select a date.");
            return;
        }
        const savedSchedule = JSON.parse(localStorage.getItem("userSchedule")) || [];
        savedSchedule.push({ name: exerciseName, date });
        localStorage.setItem("userSchedule", JSON.stringify(savedSchedule));
        renderSchedule(savedSchedule);
    };

    window.toggleDetails = (btn) => {
        const details = btn.nextElementSibling;
        if (details.style.display === "block") {
            details.style.display = "none";
            btn.textContent = "View More";
        } else {
            details.style.display = "block";
            btn.textContent = "Hide";
        }
    };

    function renderSchedule(schedule) {
        scheduleList.innerHTML = "";
        schedule.forEach((entry, index) => {
            const li = document.createElement('li');
            li.textContent = `${entry.name} - ${entry.date}`;

            const removeBtn = document.createElement('button');
            removeBtn.textContent = "❌";
            removeBtn.style.marginLeft = "10px";
            removeBtn.style.background = "red";
            removeBtn.style.color = "white";
            removeBtn.style.border = "none";
            removeBtn.style.padding = "2px 8px";
            removeBtn.style.borderRadius = "4px";
            removeBtn.onclick = () => {
                const updated = [...schedule];
                updated.splice(index, 1);
                localStorage.setItem("userSchedule", JSON.stringify(updated));
                renderSchedule(updated);
            };

            li.appendChild(removeBtn);
            scheduleList.appendChild(li);
        });
    }
});
</script>


</body>
</html>
