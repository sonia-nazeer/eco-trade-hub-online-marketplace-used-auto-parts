<?php
session_start();
include('../config/db.php');



if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'seller') {
    header("Location: ../login.php"); 
    exit();
}


if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $seller_id = $_SESSION['user_id'];


    $sql = "DELETE FROM products WHERE product_id = ? AND seller_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $product_id, $seller_id);
    if ($stmt->execute()) {
        header("Location: manage-products.php"); // Redirect to manage products page
        exit();
    } else {
        echo "<script>alert('Error deleting product.'); window.location='manage-products.php';</script>";
    }
} else {
    echo "<script>alert('Invalid product ID.'); window.location='manage-products.php';</script>";
}
?>
