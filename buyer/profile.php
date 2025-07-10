<?php
include '../includes/buyerheader.php';
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'buyer') {
    header('Location: ../pages/login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE user_id = $user_id";
$user_result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($user_result);
?>

<div class="container my-5">
    <h2 class="text-center mb-4">Manage Your Profile</h2>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form action="update-profile.php" method="POST">
                        <input type="hidden" name="user_id" value="<?= $user['user_id']; ?>">

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                class="form-control" 
                                value="<?= htmlspecialchars($user['name']); ?>" 
                                required
                            >
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                class="form-control" 
                                value="<?= htmlspecialchars($user['email']); ?>" 
                                required
                            >
                        </div>

                        <!-- Address -->
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea 
                                name="address" 
                                id="address" 
                                class="form-control" 
                                rows="4"
                                required
                            ><?= htmlspecialchars($user['address']); ?></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-success w-100">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
