<?php
session_start();
require_once '../config/db.php';


if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo '<div class="container my-5 text-center">';
    echo '<div class="alert alert-warning">Your cart is empty!</div>';
    echo '<a href="cart.php" class="btn btn-primary">Go Back to Cart</a>';
    echo '</div>';
    exit;
}

$grand_total = 0;
foreach ($_SESSION['cart'] as $item) {
    if (!isset($item['price'])) {
        $item['price'] = 0.00; 
    }
    
    if (isset($item['product_price']) && isset($item['quantity'])) {
        $grand_total += $item['product_price'] * $item['quantity'];
    }
}

?>
    <?php include('../includes/header.php'); ?>

    <div class="container my-5">
        <h1 class="text-center mb-4">Checkout</h1>
        <form action="process-checkout.php" method="POST">
            
            <div class="row">
                <div class="col-md-6">
                    <h4>Billing Information</h4>
                    <div class="mb-3">
                        <label for="full_name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="phone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Shipping Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                    </div>
                </div>

                <!-- Cart Review Section -->
                <div class="col-md-6">
                    <h4>Cart Review</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($_SESSION['cart'] as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['product_name']); ?></td>
                                    <td><?= $item['quantity']; ?></td>
                                    <td>$<?= number_format($item['product_price'] * $item['quantity'], 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="text-end"><strong>Grand Total:</strong></td>
                                <td><strong>$<?= number_format($grand_total, 2); ?></strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Payment Details Section -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <h4>Payment Details</h4>
                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Payment Method</label>
                        <select class="form-select" id="payment_method" name="payment_method" required>
                            <option value="cash_on_delivery">Cash on Delivery</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="text-end mt-4">
                <a href="cart.php" class="btn btn-secondary">Back to Cart</a>
                <button type="submit" class="btn btn-success">Place Order</button>
            </div>
        </form>
    </div>

    <?php include('../includes/footer.php'); ?>

    