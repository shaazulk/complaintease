<?php
// Include the database connection
include('db_connect.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $accountType = $_POST['accountType'];
    $staffID = $_POST['staffID'];
    $studentID = $_POST['studentID'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate the password match
    if ($password !== $confirm_password) {
        die("Passwords do not match. Please try again.");
    }

    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Validate the input based on account type
    if ($accountType == 'admin' && empty($staffID)) {
        die("Staff ID is required for Admin account.");
    }

    if ($accountType == 'student' && empty($studentID)) {
        die("Student ID is required for Student account.");
    }

    if ($accountType == 'admin' && !empty($studentID)) {
        die("Please leave the Student ID blank for Admin account.");
    }

    if ($accountType == 'student' && !empty($staffID)) {
        die("Please leave the Staff ID blank for Student account.");
    }

    // Check if the email already exists in the database
    $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email already exists
        die("The email address is already registered. Please use a different one.");
    }

    // Prepare SQL statement to insert user data into the database
    $stmt = $conn->prepare("INSERT INTO users (name, email, account_type, staff_id, student_id, password) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $email, $accountType, $staffID, $studentID, $hashed_password);

    // Execute the query
    if ($stmt->execute()) {
        // Registration successful, show success message and buttons
        echo "<h2>Registration successful!</h2>";
        echo "<div style='text-align:center; margin-top: 20px;'>
                <a href='index.html' style='text-decoration: none; color: #000000; background-color: #89CFF0; padding: 15px 30px; font-size: 18px; font-weight: bold; border-radius: 5px; transition: all 0.3s ease;'>Home</a>
                <a href='login.html' style='text-decoration: none; color: #000000; background-color: #89CFF0; padding: 15px 30px; font-size: 18px; font-weight: bold; border-radius: 5px; transition: all 0.3s ease; margin-left: 20px;'>Login</a>
              </div>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
