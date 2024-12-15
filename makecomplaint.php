<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Redirect to login page if not logged in
    header("Location: login.html");
    exit;
}

// Get the user's name from session
$user_name = $_SESSION['user_name']; // Name is stored in session after login
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make a Complaint</title>
    <link rel="stylesheet" href="makecomplaint.css"> <!-- Assuming a separate stylesheet -->
</head>
<body>
    <div class="container">
        <h1>Make a Complaint</h1>
        <form action="makecomplaint_process.php" method="POST">
            <label for="title">Title of Complaint</label>
            <input type="text" id="title" name="title" required>

            <label for="description">Description</label>
            <textarea id="description" name="description" required></textarea>

            <label for="complaint_type">Complaint Type</label>
            <select id="complaint_type" name="complaint_type" required>
                <option value="Maintenance">Maintenance</option>
                <option value="Noise">Noise</option>
                <option value="Facility">Facility</option>
            </select>

            <label for="room_number">Room Number</label>
            <input type="text" id="room_number" name="room_number" required>

            <label for="contact_number">Contact Number</label>
            <input type="text" id="contact_number" name="contact_number" required>

            <button type="submit">Submit Complaint</button>
        </form>

        <!-- Home Button placed at the bottom -->
        <div class="home-button">
            <a href="student_dashboard.php" class="btn">Home</a>
        </div>
    </div>
</body>
</html>
