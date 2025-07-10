<?php
include '../includes/buyerheader.php';
require_once '../config/db.php';


if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'buyer') {
    header('Location: ../pages/login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Your Order History</h2>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $order_history = "SELECT orders.order_id, orders.created_at, orders.total_price, orders.order_status, 
                                  products.image, products.name 
                                  FROM orders 
                                  JOIN order_items ON orders.order_id = order_items.order_id 
                                  JOIN products ON order_items.product_id = products.product_id 
                                  WHERE orders.buyer_id = $user_id ";

                $history_result = mysqli_query($conn, $order_history);

                if (mysqli_num_rows($history_result) > 0) {
                    while ($history = mysqli_fetch_assoc($history_result)) {
                        $total = number_format($history['total_price'], 2);
                        echo "<tr>
                                <td>{$history['order_id']}</td>
                                <td>{$history['created_at']}</td>
                                <td>$ $total</td>
                                <td>{$history['order_status']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>No orders found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
