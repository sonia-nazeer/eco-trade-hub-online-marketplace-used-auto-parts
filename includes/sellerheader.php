<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>
<?php include('../config/db.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>seller dashboard</title>
     <!-- fontawesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header class="bg-dark">
        <nav class="navbar navbar-expand-lg navbar-dark container sticky-top">
            <a class="navbar-brand" href="../pages/index.php">
                <img src="../assets/images/logo2.png" alt="ECO Trade Hub" class="logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link " href="../seller/dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../seller/add-product.php">Add Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../seller/manage-products.php">edit-products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../seller/profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../seller/orders.php">Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/message.php">messages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/logout.php">logout</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

