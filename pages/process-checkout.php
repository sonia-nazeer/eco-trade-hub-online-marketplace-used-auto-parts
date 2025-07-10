<?php
session_start();
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);
    
    
    $grand_total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $grand_total += $item['product_price'] * $item['quantity'];
    }

    $buyer_id = $_SESSION['user_id'];
    $order_query = "INSERT INTO orders (buyer_id, total_price, order_status) VALUES ('$buyer_id', '$grand_total', 'pending')";
    $order_result = mysqli_query($conn, $order_query);

    if ($order_result) {
       
        $order_id = mysqli_insert_id($conn);

        
        foreach ($_SESSION['cart'] as $item) {
            $product_id = $item['product_id'];
            $quantity = $item['quantity'];
            $product_price = $item['product_price'];

            $order_item_query = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES ('$order_id', '$product_id', '$quantity', '$product_price')";
            mysqli_query($conn, $order_item_query);
        }

        
        unset($_SESSION['cart']);
        header('Location: thankyou.php');
        exit;
    } else {
        echo "Error: Unable to place your order.";
    }
} else {
    echo "Invalid request.";
}
?>
