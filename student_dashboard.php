<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Redirect to login page if not logged in
    header("Location: login.html");
    exit;
}

// Get the logged-in student's name
$student_name = $_SESSION['user_name']; // Use 'user_name' instead of 'name'
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - ComplaintEase</title>
    <link rel="stylesheet" href="student_dashboard.css">
</head>
<body>
    <!-- Dashboard Container -->
    <div class="dashboard-container">
        <header>
            <!-- Display the student's name dynamically -->
            <h1>Welcome, <?php echo htmlspecialchars($student_name); ?>!</h1>
            <p>Manage your complaints efficiently</p>
        </header>

        <!-- Navigation -->
        <nav class="dashboard-nav">
            <a href="makecomplaint.php" class="btn">Make Complaint</a>
            <a href="trackcomplaint.php" class="btn">Track Complaint</a>
        </nav>

        <!-- Logout Button -->
        <footer>
            <a href="logout.php" class="btn">Logout</a>
            <p>&copy; 2024 ComplaintEase. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
