<?php
session_start();
include('db_connect.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION['logged_in']) || $_SESSION['account_type'] !== 'admin') {
    header("Location: login.html");
    exit;
}

// Get the announcement ID from the URL
if (isset($_GET['id'])) {
    $announcement_id = $_GET['id'];

    // Fetch the announcement data
    $stmt = $conn->prepare("SELECT * FROM announcements WHERE id = ?");
    $stmt->bind_param("i", $announcement_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $announcement = $result->fetch_assoc();
    $stmt->close();
} else {
    header("Location: announcements.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Update the announcement in the database
    $stmt = $conn->prepare("UPDATE announcements SET title = ?, content = ? WHERE id = ?");
    $stmt->bind_param("ssi", $title, $content, $announcement_id);

    if ($stmt->execute()) {
        echo "Announcement updated successfully.";
        header("Location: announcements.php");
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
    <title>Edit Announcement - ComplaintEase</title>
    <link rel="stylesheet" href="admin_dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <header>
            <h1>Edit Announcement</h1>
        </header>

        <form method="POST">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($announcement['title']); ?>" required>

            <label for="content">Content</label>
            <textarea id="content" name="content" required><?php echo htmlspecialchars($announcement['content']); ?></textarea>

            <button type="submit" class="btn">Update Announcement</button>
        </form>

        <footer>
            <a href="announcement.php" class="btn">Back to Announcements</a>
        </footer>
    </div>
</body>
</html>
