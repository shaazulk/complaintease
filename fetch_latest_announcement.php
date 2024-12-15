<?php
header('Content-Type: application/json');
include('db_connect.php');

$query = "SELECT title, content, created_by, created_at FROM announcements ORDER BY created_at DESC LIMIT 1";
$result = $conn->query($query);

if ($result && $row = $result->fetch_assoc()) {
    echo json_encode([
        "success" => true,
        "title" => $row['title'],
        "content" => $row['content'],
        "created_by" => $row['created_by'],
        "created_at" => date("F j, Y, g:i a", strtotime($row['created_at']))
    ]);
} else {
    echo json_encode(["success" => false]);
}

$conn->close();
?>
