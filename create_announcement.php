<?php
session_start();
include('db_connect.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION['logged_in']) || $_SESSION['account_type'] !== 'admin') {
    header("Location: login.html");
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $created_by = $_SESSION['user_name']; // Logged-in admin's name

    // Prepare and execute the SQL statement to insert the new announcement
    $stmt = $conn->prepare("INSERT INTO announcements (title, content, created_by) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $content, $created_by);

    if ($stmt->execute()) {
        echo "Announcement created successfully.";
        header("Location: announcement.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Announcement - ComplaintEase</title>
    <link rel="stylesheet" href="create_announcement.css">
</head>
<body>
    <div class="dashboard-container">
        <header>
            <h1>Create New Announcement</h1>
        </header>

        <form method="POST">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" placeholder="Enter the announcement title" required>

            <label for="content">Content</label>
            <textarea id="content" name="content" placeholder="Enter the announcement content" required></textarea>

            <button type="submit" class="btn">Create Announcement</button>
        </form>

        <footer>
            <a href="announcement.php" class="btn">Back to Announcements</a>
        </footer>
    </div>
</body>
</html>
