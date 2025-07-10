<?php
// Include necessary files for database connection and session handling
include('../includes/sellerheader.php');
include('../config/db.php');  // Update the path if necessary

// Check if the user is logged in and is a seller
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'seller') {
    header("Location: ../login.php"); // Redirect to login page if not logged in
    exit();
}

// Fetch products added by the logged-in seller
$seller_id = $_SESSION['user_id']; // Get the seller's ID from the session
$sql = "SELECT * FROM products WHERE seller_id = ?";  // Prepare the query to fetch products by seller ID
$stmt = $conn->prepare($sql);  // Prepare statement to prevent SQL injection
$stmt->bind_param('i', $seller_id);  // Bind the seller's ID to the query
$stmt->execute();  // Execute the query
$result = $stmt->get_result();  // Get the result of the query

?>

<div class="container mt-5">
    <h2 class="mb-4">Your Products</h2>

    <!-- Check if the seller has products listed -->
    <?php if ($result->num_rows > 0): ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo '$' . htmlspecialchars($row['price']); ?></td>
                        <td><?php echo htmlspecialchars($row['category']); ?></td>
                        <td><?php echo htmlspecialchars($row['description']); ?></td>
                        <td>
                            <!-- Edit and Delete buttons -->
                            <a href="edit-product.php?id=<?php echo $row['product_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete-product.php?id=<?php echo $row['product_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No products found. <a href="add-product.php" class="btn btn-success">Add Product</a></p>
    <?php endif; ?>

</div>




