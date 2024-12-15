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

    // Delete the announcement from the database
    $stmt = $conn->prepare("DELETE FROM announcements WHERE id = ?");
    $stmt->bind_param("i", $announcement_id);

    if ($stmt->execute()) {
        echo "Announcement deleted successfully.";
        header("Location: announcement.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: announcement.php");
    exit;
}
?>
