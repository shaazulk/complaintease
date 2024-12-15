<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_name']) || $_SESSION['account_type'] != 'admin') {
    header("Location: login.html");
    exit();
}

include('db_connect.php');

// Get the selected status from the filter form (if any)
$status_filter = isset($_POST['status_filter']) ? $_POST['status_filter'] : '';

// Get the search keyword from the search form (if any)
$search_keyword = isset($_POST['search_keyword']) ? $_POST['search_keyword'] : '';

// Build the SQL query based on the selected status and search keyword
$sql = "SELECT * FROM complaints WHERE 1=1"; // Ensure WHERE clause is always present

if ($status_filter) {
    $sql .= " AND status = '$status_filter'"; // Filter by status
}

if ($search_keyword) {
    $sql .= " AND name LIKE '%$search_keyword%'"; // Filter by name search keyword
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Complaints - ComplaintEase</title>
    <link rel="stylesheet" href="viewcomplaints.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>View Complaints</h1>
            <p>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</p>
        </header>

        <!-- Search and filter form -->
        <form method="POST" action="">
            <!-- Search by Name -->
            <input type="text" name="search_keyword" placeholder="Search by Name" value="<?php echo htmlspecialchars($search_keyword); ?>">
            
            <!-- Filter by Status -->
            <select name="status_filter">
                <option value="">-- Select Status --</option>
                <option value="Pending" <?php echo ($status_filter == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                <option value="In Progress" <?php echo ($status_filter == 'In Progress') ? 'selected' : ''; ?>>In Progress</option>
                <option value="Resolved" <?php echo ($status_filter == 'Resolved') ? 'selected' : ''; ?>>Resolved</option>
            </select>
            
            <button type="submit">Search & Filter</button>
        </form>

        <!-- Complaints table -->
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Student Name</th>
                    <th>Complaint Type</th>
                    <th>Room Number</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['title']}</td>
                                <td>{$row['name']}</td> <!-- Display student name -->
                                <td>{$row['complaint_type']}</td>
                                <td>{$row['room_number']}</td>
                                <td>{$row['status']}</td>
                                <td><a href='complaint_details.php?id={$row['id']}'>View Details</a></td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No complaints found.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="home-button">
            <a href="admin_dashboard.php">Back to Dashboard</a>
        </div>

        <!-- Footer Section -->
        <footer>
            <p>&copy; 2024 ComplaintEase. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>

<?php
$conn->close();
?>
