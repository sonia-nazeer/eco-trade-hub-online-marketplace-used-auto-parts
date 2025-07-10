<?php

include('../includes/sellerheader.php'); 
require_once '../config/db.php'; 


if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'seller') {
    header('Location: ../pages/login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$seller_orders_query = "
    SELECT o.order_id, o.order_status, o.created_at, SUM(oi.quantity * oi.price) AS total_price
    FROM orders o
    JOIN order_items oi ON o.order_id = oi.order_id
    JOIN products p ON oi.product_id = p.product_id
    WHERE p.seller_id = $user_id
    GROUP BY o.order_id, o.order_status, o.created_at";
$seller_orders_result = mysqli_query($conn, $seller_orders_query);
?>

<div class="container my-5">
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['message']; ?>
            <?php unset($_SESSION['message']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['error']; ?>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>
    
    <!-- Orders Table -->
    <h1 class="text-center mb-4">Your Orders</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Status</th>
                <th>Date</th>
                <th>Total Amount</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($order = mysqli_fetch_assoc($seller_orders_result)): ?>
                <tr>
                    <td><?= $order['order_id']; ?></td>
                    <td><?= ucfirst($order['order_status']); ?></td>
                    <td><?= date('d-M-Y', strtotime($order['created_at'])); ?></td>
                    <td>$<?= number_format($order['total_price'], 2); ?></td>
                    <td>
                        <!-- Form for order status update -->
                        <form method="POST" action="update-order.php">
                            <input type="hidden" name="order_id" value="<?= $order['order_id']; ?>">
                            <select name="order_status" class="form-select form-select-sm">
                                <option value="approved" <?= $order['order_status'] == 'approved' ? 'selected' : ''; ?>>Approve</option>
                                <option value="rejected" <?= $order['order_status'] == 'rejected' ? 'selected' : ''; ?>>Reject</option>
                                <option value="shipped" <?= $order['order_status'] == 'shipped' ? 'selected' : ''; ?>>Ship</option>
                            </select>
                            <button type="submit" class="btn btn-warning btn-sm mt-1">Update</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php include('../includes/footer.php'); ?>