<?php
include('../includes/adminheader.php');
require_once '../config/db.php';



if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}


$query = "SELECT * FROM users";
$result = $conn->query($query);
?>


    <div class="container mt-5">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Manage Users</h1>
        </div>

        <!-- Users Table -->
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $user['user_id']; ?></td>
                        <td><?= htmlspecialchars($user['name']); ?></td>
                        <td><?= htmlspecialchars($user['email']); ?></td>
                        <td><?= ucfirst($user['role']); ?></td>
                        <td>
                            <a href="edit-user.php?id=<?= $user['user_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete-user.php?id=<?= $user['user_id']; ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Are you sure you want to delete this user?');">
                               Delete
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="mt-4 ">
            <a href="dashboard.php" class="btn btn-success ">Back to Dashboard</a>
        </div>
    </div>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>




    
