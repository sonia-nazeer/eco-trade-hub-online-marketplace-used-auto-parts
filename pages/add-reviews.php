<?php
session_start();
require_once '../config/db.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $product_id = isset($_POST['product_id']) ? (int) $_POST['product_id'] : 0;
    $rating = isset($_POST['rating']) ? (int) $_POST['rating'] : 0;
    $review_text = isset($_POST['review_text']) ? trim($_POST['review_text']) : '';
    $user_id = $_SESSION['user_id'];

    if ($product_id > 0 && $rating >= 1 && $rating <= 5 && !empty($review_text)) {
        // Check if the user has already submitted a review for this product
        $checkStmt = $conn->prepare("SELECT * FROM reviews WHERE product_id = ? AND user_id = ?");
        $checkStmt->bind_param("ii", $product_id, $user_id);
        $checkStmt->execute();
        $existingReview = $checkStmt->get_result()->fetch_assoc();

        if ($existingReview) {
            // Optional: prevent duplicate reviews
            $_SESSION['message'] = "You have already submitted a review for this product.";
        } else {
            // Insert the review
            $stmt = $conn->prepare("INSERT INTO reviews (product_id, user_id, rating, review_text) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiis", $product_id, $user_id, $rating, $review_text);
            
            if ($stmt->execute()) {
                $_SESSION['message'] = "Review submitted successfully.";
            } else {
                $_SESSION['message'] = "Something went wrong. Please try again.";
            }
        }
    } else {
        $_SESSION['message'] = "Please fill in all fields correctly.";
    }

    // Redirect back to the product details page
    header("Location: product-detail.php?product_id=" . $product_id);
    exit;
} else {
    // Invalid access
    header("Location: ../pages/index.php");
    exit;
}
?>
