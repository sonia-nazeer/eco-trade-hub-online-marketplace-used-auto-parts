<?php
require_once '../config/db.php';


if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $productId = intval($_GET['id']); 

    
    $query = "DELETE FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $productId);

    if ($stmt->execute()) {
       
        header("Location: manage-products.php?status=success");
        exit;
    } else {
      
        header("Location: manage-products.php?status=error");
        exit;
    }
} else {

    header("Location: manage-products.php");
    exit;
}
?>
