<?php
session_start();
include('db_connect.php'); // Assuming this contains the database connection setup

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.html"); // Redirect to login if not logged in
    exit;
}

// Get the user's name from the session
$user_name = $_SESSION['user_name']; // Use the name stored in the session

// Fetch complaints submitted by the logged-in student
$complaints = [];
if ($stmt = $conn->prepare("SELECT title, description, complaint_type, room_number, status, created_at, updated_at FROM complaints WHERE name = ? ORDER BY created_at DESC")) {
    $stmt->bind_param("s", $user_name);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $complaints[] = $row;
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Complaints</title>
    <link rel="stylesheet" href="trackcomplaint.css">
</head>
<body>
    <div class="container">
        <h1>Track Complaints</h1>
        <h3>Welcome, <?php echo htmlspecialchars($user_name); ?>!</h3>

        <!-- Complaints List -->
        <div id="complaint-list">
            <?php if (empty($complaints)): ?>
                <p>No complaints found.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Type</th>
                            <th>Room</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($complaints as $complaint): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($complaint['title']); ?></td>
                                <td><?php echo htmlspecialchars($complaint['description']); ?></td>
                                <td><?php echo htmlspecialchars($complaint['complaint_type']); ?></td>
                                <td><?php echo htmlspecialchars($complaint['room_number']); ?></td>
                                <td><?php echo htmlspecialchars($complaint['status']); ?></td>
                                <td><?php echo htmlspecialchars($complaint['created_at']); ?></td>
                                <td><?php echo $complaint['updated_at'] ? htmlspecialchars($complaint['updated_at']) : 'Not updated'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <!-- Home Button -->
        <div class="button-container">
            <a href="student_dashboard.php" class="home-button">Home</a>
        </div>
    </div>
</body>
</html>
