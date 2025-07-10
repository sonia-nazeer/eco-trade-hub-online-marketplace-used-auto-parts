<?php
include '../includes/buyerheader.php';
require_once '../config/db.php';


if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'buyer') {
    header('Location: ../pages/login.php');
    exit;
}
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE user_id = $user_id";
$user_result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($user_result);
?>

<div class="container my-5">
    <h2 class="mb-4 text-center">Welcome, <?= htmlspecialchars($user['name']); ?>!</h2>

    <!-- Dashboard Summary -->
    <div class="row g-4">
        <!-- Recent Orders Card -->
        <div class="col-md-4">
            <div class="card border-success shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-success">Total Orders</h5>
                    <?php
                    $total_orders_query = "SELECT COUNT(*) as total FROM orders WHERE buyer_id = $user_id";
                    $total_orders_result = mysqli_query($conn, $total_orders_query);
                    $total_orders = mysqli_fetch_assoc($total_orders_result)['total'];
                    ?>
                    <h2 class="card-text"><?= $total_orders; ?></h2>
                </div>
            </div>
        </div>

        <!-- Order History Card -->
        <div class="col-md-4">
            <div class="card border-info shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-info">Total Amount Spent</h5>
                    <?php
                    $total_spent_query = "SELECT SUM(total_price) as total FROM orders WHERE buyer_id = $user_id";
                    $total_spent_result = mysqli_query($conn, $total_spent_query);
                    $total_spent = mysqli_fetch_assoc($total_spent_result)['total'] ?? 0;
                    ?>
                    <h2 class="card-text">$ <?= number_format($total_spent, 2); ?></h2>
                </div>
            </div>
        </div>

        <!-- Pending Orders Card -->
        <div class="col-md-4">
            <div class="card border-warning shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-warning">Pending Orders</h5>
                    <?php
                    $pending_orders_query = "SELECT COUNT(*) as pending FROM orders WHERE buyer_id = $user_id AND order_status = 'Pending'";
                    $pending_orders_result = mysqli_query($conn, $pending_orders_query);
                    $pending_orders = mysqli_fetch_assoc($pending_orders_result)['pending'];
                    ?>
                    <h2 class="card-text"><?= $pending_orders; ?></h2>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5">
        <h4 class="mb-3">Recent Orders</h4>
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $recent_orders_query = "SELECT * FROM orders WHERE buyer_id = $user_id ORDER BY created_at DESC LIMIT 5";
                    $recent_orders_result = mysqli_query($conn, $recent_orders_query);

                    if (mysqli_num_rows($recent_orders_result) > 0) {
                        while ($order = mysqli_fetch_assoc($recent_orders_result)) {
                            echo "<tr>
                                    <td>{$order['order_id']}</td>
                                    <td>" . date("d M Y", strtotime($order['created_at'])) . "</td>
                                    <td>{$order['order_status']}</td>
                                    <td>$" . number_format($order['total_price'], 2) . "</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' class='text-center'>No recent orders</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
