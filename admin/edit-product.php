<?php
require_once '../config/db.php';

if (isset($_GET['id'])) {
    $productId = $_GET['id'];
    $query = "SELECT * FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $condition = $_POST['condition'];
        $updateQuery = "UPDATE products SET name = ?, price = ?, `product_condition` = ? WHERE product_id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("sdsi", $name, $price, $product_condition, $productId);
        $updateStmt->execute();
        header("Location: manage-products.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 30px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .form-label {
            font-weight: bold;
        }
        .btn-custom {
            background-color: #28a745;
            color: white;
            
        }
        .btn-custom:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Edit Product</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($product['name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price ($)</label>
                <input type="number" class="form-control" name="price" step="0.01" value="<?= htmlspecialchars($product['price']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="condition" class="form-label">Condition</label>
                <select class="form-select" name="condition" required>
                    <option value="new" <?= $product['product_condition'] === 'new' ? 'selected' : ''; ?>>New</option>
                    <option value="used" <?= $product['product_condition'] === 'used' ? 'selected' : ''; ?>>Used</option>
                </select>
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-custom">Update Product</button>
                <a href="manage-products.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
