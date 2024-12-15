<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_name']) || $_SESSION['account_type'] != 'admin') {
    header("Location: login.html");
    exit();
}

include('db_connect.php');

// Get the complaint ID from the URL
$complaint_id = $_GET['id'];

// Fetch the complaint details from the database
$sql = "SELECT * FROM complaints WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $complaint_id);
$stmt->execute();
$result = $stmt->get_result();

$complaint = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Details - ComplaintEase</title>
    <link rel="stylesheet" href="complaintdetails.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Complaint Details</h1>
            <p>Complaint ID: <?php echo htmlspecialchars($complaint['id']); ?></p>
            <p>Student Name: <?php echo htmlspecialchars($complaint['name']); ?></p>
        </header>

        <div class="complaint-info">
            <p><strong>Title:</strong> <?php echo htmlspecialchars($complaint['title']); ?></p>
            <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($complaint['description'])); ?></p>
            <p><strong>Type:</strong> <?php echo htmlspecialchars($complaint['complaint_type']); ?></p>
            <p><strong>Room Number:</strong> <?php echo htmlspecialchars($complaint['room_number']); ?></p>
            <p><strong>Contact Number:</strong> <?php echo htmlspecialchars($complaint['contact_number']); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($complaint['status']); ?></p>
        </div>

        <!-- Add the Update Complaint button -->
        <div class="update-button">
            <a href="update_complaint.php?id=<?php echo $complaint['id']; ?>" class="button">Update Complaint</a>
        </div>

        <div class="home-button">
            <a href="viewcomplaints.php">Back to Complaints List</a>
        </div>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
