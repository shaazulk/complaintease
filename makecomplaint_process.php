<?php
session_start();
include('db_connect.php'); // Assuming db_connect.php contains the database connection

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $complaint_type = $_POST['complaint_type'];
    $room_number = $_POST['room_number'];
    $contact_number = $_POST['contact_number'];
    $name = $_SESSION['user_name']; // Name from session (no need for user_id)
    
    // Insert the complaint into the database
    $stmt = $conn->prepare("INSERT INTO complaints (title, description, complaint_type, room_number, contact_number, name, status, created_at) VALUES (?, ?, ?, ?, ?, ?, 'Pending', NOW())");
    $stmt->bind_param("ssssss", $title, $description, $complaint_type, $room_number, $contact_number, $name);

    if ($stmt->execute()) {
        echo "<script>
                alert('Complaint submitted successfully!');
                window.location.href = 'student_dashboard.php'; // Redirect to dashboard after submission
              </script>";
    } else {
        echo "<script>
                alert('Error submitting complaint. Please try again.');
                window.location.href = 'makecomplaint.php'; // Redirect back to the form on error
              </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
