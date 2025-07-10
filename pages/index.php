<?php include('../includes/header.php'); ?>

<!-- Hero Section
<section class="hero bg-dark text-white text-center py-5">
    <div class="container">
        <h1>Welcome to ECO Trade Hub</h1>
        <p>Buy and Sell Quality Auto Parts at Affordable Prices</p>
        <a href="search.php" class="btn btn-warning btn-lg mt-3">Start Shopping</a>
    </div>  
</section>-->
<!-- Hero Banner -->
 <section>
<div id="hero-banner" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active" style="background-image: url('../assets/images/slider1.jpg'); height: 50vh;">
            <div class="carousel-caption">
                <h5>Buy & Sell Auto Parts</h5>
                <p>Find the best deals on quality used auto parts.</p>
                <a href="search.php" class="btn btn-primary">shop now</a>
            </div>
        </div>
        <div class="carousel-item" style="background-image: url('../assets/images/slider3.jpg'); height: 50vh;">
            <div class="carousel-caption">
                <h5>Reliable Sellers</h5>
                <p>Quality checked and reliable parts for all your needs.</p>
                <a href="login.php" class="btn btn-primary">Become a Seller</a>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#hero-banner" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#hero-banner" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
    </button>
</div>
</section>

<!-- Featured Categories Section -->
<section class="featured-categories py-5">
    <div class="container text-center">
        <h2 class="mb-4">Featured Categories</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="category-card">
                    <img src="../assets/images/3 metal gears.jpg" alt="Engines">
                    <h5>Engines</h5>
                    <a href="search.php?category=engines" class="btn btn-outline-warning">Shop Now</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="category-card">
                    <img src="../assets/images/pedals.jpg" alt="Brakes">
                    <h5>Brakes</h5>
                    <a href="search.php?category=brakes" class="btn btn-outline-warning">Shop Now</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="category-card">
                    <img src="../assets/images/headlight2.jpg" alt="Suspension">
                    <h5>Suspension</h5>
                    <a href="search.php?category=suspension" class="btn btn-outline-warning">Shop Now</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php

require_once '../config/db.php';


$query = "SELECT * FROM products"; 
$result = $conn->query($query);
?>

<!-- Featured Products Section -->
<section class="featured-products py-5 bg-light">
    <div class="container text-center">
        <h2 class="mb-4">Featured Products</h2>
        <?php if ($result->num_rows > 0): ?>
            <div class="row">
                <?php 
                $counter = 0; // Initialize counter
                while ($product = $result->fetch_assoc()): ?>
                    <div class="col-md-3 mb-4">
                        <div class="card product-card">
                            <img src="../assets/images/<?= !empty($product['image']) ? htmlspecialchars($product['image']) : 'default.jpg'; ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($product['name']); ?></h5>
                                <p class="card-text">$<?= number_format($product['price'], 2); ?></p>
                                <a href="product-detail.php?product_id=<?= $product['product_id']; ?>" class="btn btn-warning">View Details</a>
                                
                                <!-- Add to Cart Form -->
                                <form action="add-to-cart.php" method="POST" class="mt-2">
                                    <input type="hidden" name="product_image" value="<?= $product['image']; ?>">
                                    <input type="hidden" name="product_id" value="<?= $product['product_id']; ?>">
                                    <input type="hidden" name="product_name" value="<?= htmlspecialchars($product['name']); ?>">
                                    <input type="hidden" name="product_price" value="<?= $product['price']; ?>">
                                    <button type="submit" class="btn btn-success">Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <?php 
                    $counter++; // Increment the counter
                    if ($counter % 4 == 0): ?>
                        </div><div class="row"> 
                    <?php endif; ?>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="text-muted">No featured products available at the moment.</p>
        <?php endif; ?>
    </div>
</section>


<?php include('../includes/footer.php'); ?>
