<?php
session_start();
include('db_connect.php'); // Assuming db_connect.php contains the database connection

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Fetch user from the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Check if the entered password matches the stored hash
        if (password_verify($password, $user['password'])) {
            // Password is correct, start the session
            $_SESSION['logged_in'] = true; // Set the session variable to indicate logged-in status
            $_SESSION['user_name'] = $user['name']; // Store user name in session
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['account_type'] = $user['account_type'];

            // Redirect to the appropriate dashboard
            if ($user['account_type'] == 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: student_dashboard.php");
            }
            exit(); // Don't forget to exit after the header redirect
        } else {
            echo "Invalid email or password."; // Password incorrect
        }
    } else {
        echo "No user found with that email."; // Email does not exist
    }
}
?>
