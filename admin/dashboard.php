<?php
include('../includes/adminheader.php');
require_once '../config/db.php';


// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: adminlogin.php");
    exit;
}

// Fetch metrics
$totalUsers = $conn->query("SELECT COUNT(*) AS count FROM users")->fetch_assoc()['count'];
$totalProducts = $conn->query("SELECT COUNT(*) AS count FROM products")->fetch_assoc()['count'];
?>


    
    <div class="container mt-5">
        <!-- Dashboard Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Admin Dashboard</h1>
        </div>

        <!-- Metrics Section -->
        <div class="row">
            <div class="col-md-4">
                <div class="card text-center card-custom bg-primary text-white" style="height: 100%" >
                    <div class="card-body ">
                        <h4>Total Users</h4>
                        <h2><?= $totalUsers; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center card-custom bg-success text-white"  style="height: 100%" >
                    <div class="card-body ">
                        <h4>Total Products</h4>
                        <h2><?= $totalProducts; ?></h2>
                    </div>
                </div>
            </div>
           <!-- Larger Reports Card -->
<div class="col-md-4">
    <div class="card text-center bg-warning text-dark" style="height: 100%;">
        <div class="card-body">
            <h4>Generate Reports</h4>
            <h2><i class="bi bi-graph-up"></i></h2>
        </div>
    </div>
</div>

        <!-- Management Links Section -->
        <div class="row mt-5">
            <div class="col-md-6">
                <a href="manage-users.php" class="btn btn-outline-primary w-100 py-3">Manage Users</a>
            </div>
            <div class="col-md-6">
                <a href="manage-products.php" class="btn btn-outline-success w-100 py-3">Manage Products</a>
            </div>
            <div class="col-md-6 mt-3">
                <a href="reports.php" class="btn btn-outline-warning w-100 py-3">View Reports</a>
            </div>
            <div class="col-md-6 mt-3">
                <a href="settings.php" class="btn btn-outline-secondary w-100 py-3">Settings</a>
            </div>
        </div>
    </div>
    </div>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


    

    
