<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $image_url = $_POST['image_url'];

    $stmt = $conn->prepare("INSERT INTO anime_movies (title, description, image_url) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $description, $image_url);
    if ($stmt->execute()) {
        $message = "Anime added successfully!";
    } else {
        $message = "Failed to add anime.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Anime</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body class="dashboard">
<div class="dashboard-container">
    <h1>Add Anime</h1>
    <?php if (isset($message)) echo "<p>$message</p>"; ?>
    <form method="POST">
        <label>Title</label>
        <input type="text" name="title" required>
        
        <label>Description</label>
        <textarea name="description" required></textarea>
        
        <label>Image URL</label>
        <input type="text" name="image_url">

        <button type="submit" name="submit">Add Anime</button>
    </form>
    <a class="logout-btn" href="dashboard.php">Back to Dashboard</a>
</div>
</body>
</html>
