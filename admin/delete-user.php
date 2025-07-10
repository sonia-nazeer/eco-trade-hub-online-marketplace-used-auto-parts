<?php
require_once '../config/db.php';

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

   
    $deleteQuery = "DELETE FROM users WHERE user_id = ?";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bind_param("i", $userId);
    $deleteStmt->execute();

    
    header("Location: manage-users.php");
    exit;
} else {
    echo "User ID not provided.";
    exit;
}
?>
