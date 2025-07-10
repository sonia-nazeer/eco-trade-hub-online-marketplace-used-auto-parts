<?php 
include('../includes/header.php'); 
require_once '../config/db.php'; 
function renderProductCard($product) {
    ?>
    <div class="col-md-3 mb-4">
        <div class="card featured-products text-center" style="heigt: 300px; width:100%">
            <img src="../assets/images/<?= !empty($product['image']) ? htmlspecialchars($product['image']) : 'default.jpg'; ?>" 
                 class="card-img-top" alt="<?= htmlspecialchars($product['name']); ?>">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($product['name']); ?></h5>
                <p class="card-text">$<?= number_format($product['price'], 2); ?></p>
                <a href="product-detail.php?product_id=<?= $product['product_id']; ?>" class="btn btn-warning">View Details</a>
                
                <!-- Add to Cart Form -->
                <form action="add-to-cart.php" method="POST" class="mt-2">
                    <input type="hidden" name="product_id" value="<?= $product['product_id']; ?>">
                    <input type="hidden" name="product_name" value="<?= htmlspecialchars($product['name']); ?>">
                    <input type="hidden" name="product_price" value="<?= $product['price']; ?>">
                    <button type="submit" class="btn btn-success">Add to Cart</button>
                </form>
            </div>
        </div>
    </div>
    <?php
}

// Search query handling
$searchResults = null;
$searchQuery = "";
if (isset($_GET['query'])) {
    $searchQuery = $conn->real_escape_string($_GET['query']); // Sanitize input
    $searchSQL = "SELECT * FROM products WHERE name LIKE '%$searchQuery%' OR description LIKE '%$searchQuery%'";
    $searchResults = $conn->query($searchSQL);

    if (!$searchResults) {
        die("Error fetching search results: " . $conn->error); // Debugging for SQL errors
    }
}
?>

<!-- Search Section -->
<section class="search-section py-5 bg-light">
    <div class="container my-3">
        <h1 class="text-center mb-4">Find Your Spare Auto Parts</h1>

        <!-- Search Form -->
        <form class="form-inline justify-content-center mb-4 mx-auto my-5" method="GET" action="search.php">
            <div class="input-group w-50 mx-auto">
                <input type="text" class="form-control" name="query" placeholder="Search for products..." 
                       value="<?= htmlspecialchars($searchQuery); ?>" required>
                <div class="input-group-append">
                    <button type="submit" class="btn btn-warning btn-lg ms-2">Search</button>
                </div>
            </div>
        </form>
    </div>
</section>


        <!-- Search Results -->
        <?php if (isset($_GET['query'])): ?>
            <?php if ($searchResults && $searchResults->num_rows > 0): ?>
                <div class="row justify-content-center">
                    <?php while ($product = $searchResults->fetch_assoc()): ?>
                        <?php renderProductCard($product); ?>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p class="text-center col-12">No products found for your search.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<!-- Featured Products Section -->
<?php
$query = "SELECT * FROM products"; 
$result = $conn->query($query);
?>

<section class="featured-products py-5 bg-light">
    <div class="container text-center">
        <h1 class="mb-4">All Products</h1>
        <?php if ($result->num_rows > 0): ?>
            <div class="row">
                <?php while ($product = $result->fetch_assoc()): ?>
                    <?php renderProductCard($product); ?>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="text-muted">No featured products available at the moment.</p>
        <?php endif; ?>
    </div>
</section>

<?php include('../includes/footer.php'); ?>
