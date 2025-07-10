<?php
include('../config/db.php');
include('../includes/sellerheader.php');

// Redirect to login page if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Fetch current user data
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Update profile
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $update_query = "UPDATE users SET name = '$name', email = '$email', phone = '$phone', address = '$address' WHERE user_id = '$user_id'";
    if (mysqli_query($conn, $update_query)) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<script>alert('Error updating profile.');</script>";
    }
}
?>

<div class="container mt-5">
    <h2>Edit Your Profile</h2>
    <form action="profile.php" method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $user['name']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $user['phone']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea class="form-control" id="address" name="address" rows="3" required><?php echo $user['address']; ?></textarea>
        </div>
        <button type="submit" class="btn btn-warning">Update Profile</button>
    </form>
</div>
