<?php
// Start the session
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['account_type'] !== 'admin') {
    // Redirect to login page if not logged in or not an admin
    header("Location: login.html");
    exit;
}

// Get the logged-in admin's name
$admin_name = $_SESSION['user_name']; // Use 'user_name' instead of 'name'
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - ComplaintEase</title>
    <link rel="stylesheet" href="admin_dashboard.css">
</head>
<body>
    <!-- Dashboard Container -->
    <div class="dashboard-container">
        <header>
            <!-- Display the admin's name dynamically -->
            <h1>Welcome, <?php echo htmlspecialchars($admin_name); ?>!</h1>
            <p>Manage the complaints and announcements</p>
        </header>

        <!-- Navigation for Admin -->
        <nav class="dashboard-nav">
            <a href="viewcomplaints.php" class="btn">Manage Complaints</a>
            <a href="announcement.php" class="btn">Manage Announcements</a> <!-- New Button -->
        </nav>

        <!-- Logout Button -->
        <footer>
            <a href="logout.php" class="btn">Logout</a>
            <p>&copy; 2024 ComplaintEase. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
