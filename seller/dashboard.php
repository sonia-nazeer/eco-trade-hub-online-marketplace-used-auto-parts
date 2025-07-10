<?php
//  include database connection
include('../includes/sellerheader.php');
include('../config/db.php'); 

// Check if seller is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
    header('Location: ../pages/login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch total products for the seller
$total_products_query = "SELECT COUNT(*) as total_products FROM products WHERE seller_id = $user_id";
$total_products_result = mysqli_query($conn, $total_products_query);
$total_products = mysqli_fetch_assoc($total_products_result)['total_products'];

// Fetch recent orders for the seller's products
$recent_orders_query = "
SELECT COUNT(DISTINCT o.order_id) as recent_orders 
FROM orders o
INNER JOIN order_items oi ON o.order_id = oi.order_id
INNER JOIN products p ON oi.product_id = p.product_id
WHERE p.seller_id = $user_id AND o.order_status = 'completed'";
$recent_orders_result = mysqli_query($conn, $recent_orders_query);
$recent_orders = mysqli_fetch_assoc($recent_orders_result)['recent_orders'];

// Fetch pending shipments for the seller's products
$pending_shipments_query = "
SELECT COUNT(DISTINCT o.order_id) as pending_shipments 
FROM orders o
INNER JOIN order_items oi ON o.order_id = oi.order_id
INNER JOIN products p ON oi.product_id = p.product_id
WHERE p.seller_id = $user_id AND o.order_status = 'pending'";
$pending_shipments_result = mysqli_query($conn, $pending_shipments_query);
$pending_shipments = mysqli_fetch_assoc($pending_shipments_result)['pending_shipments'];

?>

    <div class="container my-5">
        <h1 class="text-center mb-4">Seller Dashboard</h1>
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Total Products</h5>
                        <p class="card-text fs-4 fw-bold text-primary"><?= $total_products; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Recent Orders</h5>
                        <p class="card-text fs-4 fw-bold text-success"><?= $recent_orders; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Pending Shipments</h5>
                        <p class="card-text fs-4 fw-bold text-warning"><?= $pending_shipments; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Orders Table Section -->
<div class="container mb-5">
    <h2 class="text-center mb-4">Your Orders</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Order ID</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Order Date</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch detailed orders related to seller's products
                $orders_query = "
                    SELECT o.order_id, p.product_name, oi.quantity, o.order_date, o.order_status
                    FROM orders o
                    INNER JOIN order_items oi ON o.order_id = oi.order_id
                    INNER JOIN products p ON oi.product_id = p.product_id
                    WHERE p.seller_id = $user_id
                    ORDER BY o.order_date DESC
                ";
                $orders_result = mysqli_query($conn, $orders_query);

                if (mysqli_num_rows($orders_result) > 0) {
                    while ($row = mysqli_fetch_assoc($orders_result)) {
                        echo "<tr>";
                        echo "<td>" . $row['order_id'] . "</td>";
                        echo "<td>" . htmlspecialchars($row['product_name']) . "</td>";
                        echo "<td>" . $row['quantity'] . "</td>";
                        echo "<td>" . date("d M Y", strtotime($row['order_date'])) . "</td>";
                        echo "<td><span class='badge bg-" . 
                                ($row['order_status'] == 'completed' ? 'success' : 
                                ($row['order_status'] == 'pending' ? 'warning text-dark' : 'secondary')) . 
                             "'>" . ucfirst($row['order_status']) . "</span></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>No orders found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
