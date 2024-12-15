<?php
session_start();
include('db_connect.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION['logged_in']) || $_SESSION['account_type'] !== 'admin') {
    header("Location: login.html");
    exit;
}

// Fetch all announcements from the database
$announcements = [];
$stmt = $conn->prepare("SELECT * FROM announcements ORDER BY created_at DESC");
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $announcements[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Announcements - ComplaintEase</title>
    <link rel="stylesheet" href="announcement.css">
</head>
<body>
    <!-- Dashboard Container -->
    <div class="dashboard-container">
        <header>
            <h1>Manage Announcements</h1>
            <p>Here you can manage all announcements.</p>
        </header>

        <!-- Table of Announcements -->
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Created By</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($announcements as $announcement): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($announcement['title']); ?></td>
                        <td><?php echo htmlspecialchars($announcement['created_by']); ?></td>
                        <td><?php echo htmlspecialchars($announcement['created_at']); ?></td>
                        <td>
                            <a href="edit_announcement.php?id=<?php echo $announcement['id']; ?>" class="btn">Edit</a>
                            <a href="delete_announcement.php?id=<?php echo $announcement['id']; ?>" class="btn">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Add New Announcement Button -->
        <a href="create_announcement.php" class="btn">Create New Announcement</a>

        <!-- Logout Button -->
        <footer>
            <a href="admin_dashboard.php" class="btn">Home</a>

        </footer>
    </div>
</body>
</html>
