<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'buyer') {
    header('Location: ../pages/login.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    
    $product_image = filter_input(INPUT_POST, 'product_image', FILTER_SANITIZE_STRING);
    $product_id = filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_NUMBER_INT);
    $product_name = filter_input(INPUT_POST, 'product_name', FILTER_SANITIZE_STRING);
    $product_price = filter_input(INPUT_POST, 'product_price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    $found = false;

    
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['product_id'] == $product_id) {
            $item['quantity'] += 1; 
            $found = true;
            break;
        }
    }

    
    if (!$found) {
        $_SESSION['cart'][] = [
            'product_id' => $product_id,
            'product_name' => $product_name,
            'product_price' => $product_price,
            'product_image' => $product_image,
            'quantity' => 1,
        ];
    }
}


$grand_total = 0;

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $grand_total += $item['product_price'] * $item['quantity'];
    }
}
?>

<?php include '../includes/header.php'; ?>
<div class="container-fluid mt-5">
    <h2 class="text-center">Your Shopping Cart</h2>
    <?php if (empty($_SESSION['cart'])): ?>
        <p class="text-center">Your cart is empty.</p>
    <?php else: ?>
        <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product image</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['cart'] as $item): ?>
                    <tr>
                        <td><img src="../assets/images/<?= htmlspecialchars($item['product_image']); ?>" alt="<?= htmlspecialchars($item['product_name']); ?>" width="80" height="auto"></td>
                        <td><?= htmlspecialchars($item['product_name']); ?></td>
                        <td>$<?= htmlspecialchars(number_format($item['product_price'], 2)); ?></td>
                        <td>
                            <form action="update-cart.php" method="POST" style="display: inline;">
                                <input type="hidden" name="product_id" value="<?= $item['product_id']; ?>">
                                <button type="submit" name="action" value="decrease" class="btn btn-sm btn-warning" <?= $item['quantity'] <= 1 ? 'disabled' : ''; ?>>-</button>
                            </form>
                            <?= htmlspecialchars($item['quantity']); ?>
                            <form action="update-cart.php" method="POST" style="display: inline;">
                                <input type="hidden" name="product_id" value="<?= $item['product_id']; ?>">
                                <button type="submit" name="action" value="increase" class="btn btn-sm btn-success">+</button>
                            </form>
                        </td>
                        <td>$<?= htmlspecialchars(number_format($item['product_price'] * $item['quantity'], 2)); ?></td>
                        <td>
                            <form action="remove-from-cart.php" method="POST">
                                <input type="hidden" name="product_id" value="<?= $item['product_id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-end"><strong>Grand Total:</strong></td>
                    <td colspan="2"><strong>$<?= number_format($grand_total, 2); ?></strong></td>
                </tr>
            </tfoot>
        </table>
        </div>
        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-success" style="font-size:18px">Continue Shopping</a>
            <a href="checkout.php" class="btn btn-warning btn-lg ms-2">Checkout</a>
        </div>
    <?php endif; ?>
</div>
<?php include '../includes/footer.php'; ?>
            