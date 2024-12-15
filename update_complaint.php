<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_name']) || $_SESSION['account_type'] != 'admin') {
    header("Location: login.html");
    exit();
}

include('db_connect.php');

// Check if the complaint ID is provided in the URL
if (isset($_GET['id'])) {
    $complaint_id = $_GET['id'];

    // Fetch the complaint details from the database
    $sql = "SELECT * FROM complaints WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $complaint_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $complaint = $result->fetch_assoc();
} else {
    echo "Complaint ID is missing.";
    exit();
}

// Check if the form is submitted to update the complaint
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $status = $_POST['status']; // Get the new status
    $description = $_POST['description']; // Optional: if you want to update the description

    // Update the complaint status in the database
    $update_sql = "UPDATE complaints SET status = ?, description = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssi", $status, $description, $complaint_id);

    if ($update_stmt->execute()) {
        echo "<script>
                alert('Complaint updated successfully!');
                window.location.href = 'viewcomplaints.php';
              </script>";
    } else {
        echo "Error updating complaint: " . $update_stmt->error;
    }

    $update_stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Complaint - ComplaintEase</title>
    <link rel="stylesheet" href="update_complaint.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Update Complaint</h1>
        </header>

        <form method="POST" action="">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($complaint['title']); ?>" disabled>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description"><?php echo htmlspecialchars($complaint['description']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status">
                    <option value="Pending" <?php echo ($complaint['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                    <option value="Resolved" <?php echo ($complaint['status'] == 'Resolved') ? 'selected' : ''; ?>>Resolved</option>
                    <option value="In Progress" <?php echo ($complaint['status'] == 'In Progress') ? 'selected' : ''; ?>>In Progress</option>
                </select>
            </div>

            <div class="form-group">
                <button type="submit">Update Complaint</button>
            </div>
        </form>

        <div class="home-button">
            <a href="viewcomplaints.php">Back to View Complaints</a>
        </div>
    </div>
</body>
</html>
