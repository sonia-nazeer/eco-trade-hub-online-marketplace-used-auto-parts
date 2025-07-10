<?php
include('../includes/adminheader.php');
require_once '../config/db.php';

$query = "SELECT p.*, u.name AS seller_name FROM products p JOIN users u ON p.seller_id = u.user_id";
$result = $conn->query($query);
?>

    <div class="container mt-5">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Manage Products</h1>
        </div>

        <!-- Products Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Seller</th>
                        <th>Price</th>
                        <th>Condition</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while ($product = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $product['product_id']; ?></td>
                                <td><?= htmlspecialchars($product['name']); ?></td>
                                <td><?= htmlspecialchars($product['seller_name']); ?></td>
                                <td>$<?= number_format($product['price'], 2); ?></td>
                                <td><?= ucfirst($product['product_condition']); ?></td>
                                <td>
                                    <a href="edit-product.php?id=<?= $product['product_id']; ?>" 
                                       class="btn btn-warning btn-sm btn-custom">Edit</a>
                                    <a href="delete-product.php?id=<?= $product['product_id']; ?>" 
                                       class="btn btn-danger btn-sm btn-custom" 
                                       onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No products found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    
        <div class="mt-4 ">
            <a href="dashboard.php" class="btn btn-success  ">Back to Dashboard</a>
        </div>
    </div>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
