<?php
session_start();
require_once '../config/db.php';

if (!isset($_GET['product_id']) || empty($_GET['product_id'])) {
    echo "<div class='container my-5 text-center'>";
    echo "<div class='alert alert-warning'>Invalid Product!</div>";
    echo "<a href='../index.php' class='btn btn-primary'>Go Back</a>";
    echo "</div>";
    exit;
}

$product_id = intval($_GET['product_id']);

$query = "SELECT p.*, u.name AS seller_name, u.user_id AS seller_id FROM products p 
          JOIN users u ON p.seller_id = u.user_id 
          WHERE p.product_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $product_id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if (!$product) {
    echo "<div class='container my-5 text-center'>";
    echo "<div class='alert alert-warning'>Product not found!</div>";
    echo "<a href='../index.php' class='btn btn-primary'>Go Back</a>";
    echo "</div>";
    exit;
}

// Fetch product reviews
$reviews_query = "SELECT r.*, u.name FROM reviews r 
                  JOIN users u ON r.user_id = u.user_id 
                  WHERE r.product_id = ? ORDER BY r.created_at DESC";
$reviews_stmt = $conn->prepare($reviews_query);
$reviews_stmt->bind_param('i', $product_id);
$reviews_stmt->execute();
$reviews = $reviews_stmt->get_result();
?>

<?php include('../includes/header.php'); ?>

<div class="container my-5">
    <div class="row">
        <!-- Product Details -->
        <div class="col-md-6">
            <img src="../assets/images/<?= !empty($product['image']) ? htmlspecialchars($product['image']) : 'default.jpg'; ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($product['name']); ?>">
        </div>
        <div class="col-md-6 mt-5">
            <h2><?= htmlspecialchars($product['name']); ?></h2>
            <p><strong>Price:</strong> $<?= number_format($product['price'], 2); ?></p>
            <p><strong>Condition:</strong> <?= ucfirst($product['product_condition']); ?></p>
            <p><strong>Seller:</strong> <?= htmlspecialchars($product['seller_name']); ?></p>
            <p><?= nl2br(htmlspecialchars($product['description'])); ?></p>
            <form action="add-to-cart.php" method="POST" class="mt-2">
             <input type="hidden" name="product_image" value="<?= $product['image']; ?>">
            <input type="hidden" name="product_id" value="<?= $product['product_id']; ?>">
            <input type="hidden" name="product_name" value="<?= htmlspecialchars($product['name']); ?>">
           <input type="hidden" name="product_price" value="<?= $product['price']; ?>">
          <button type="submit" class="btn btn-warning btn-lg">Add to Cart</button>                       
          </form>
            <a href="chat.php?product_id=<?= $product['product_id']; ?>" class="btn btn-success mt-3" >Chat with Seller</a>
        </div>
    </div>

    <hr>

    <!-- Reviews Section -->
    <div class="reviews-section mt-5">
        <h3>Customer Reviews</h3>
        <?php if ($reviews->num_rows > 0): ?>
            <ul class="list-group">
                <?php while ($review = $reviews->fetch_assoc()): ?>
                    <li class="list-group-item">
                        <strong><?= htmlspecialchars($review['name']); ?></strong> 
                        <span class="badge bg-warning text-dark">Rating: <?= $review['rating']; ?>/5</span>
                        <p><?= nl2br(htmlspecialchars($review['review_text'])); ?></p>
                        <small class="text-muted">Reviewed on <?= date('F j, Y', strtotime($review['created_at'])); ?></small>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p class="text-muted">No reviews yet. Be the first to review this product!</p>
        <?php endif; ?>

        <!-- Add Review Form -->
        <h4 class="mt-4">Add a Review</h4>
        <?php if (isset($_SESSION['user_id'])): ?>
            <form action="add-reviews.php" method="POST">
                <input type="hidden" name="product_id" value="<?= $product_id; ?>">
                <div class="mb-3">
                    <label for="rating" class="form-label">Rating (1-5)</label>
                    <select class="form-select" id="rating" name="rating" required>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="review_text" class="form-label">Your Review</label>
                    <textarea class="form-control" id="review_text" name="review_text" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-warning btn-lg">Submit Review</button>
            </form>
        <?php else: ?>
            <p class="text-muted">Please <a href="login.php">log in</a> to add a review.</p>
        <?php endif; ?>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
