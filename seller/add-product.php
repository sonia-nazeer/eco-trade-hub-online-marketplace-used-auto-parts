<?php
include('../includes/sellerheader.php');
include('../config/db.php');

// Check if the user is logged in as seller
if ($_SESSION['role'] != 'seller') {
    header('Location: ../index.php');
    exit();
}

// Handle product submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $condition = $_POST['condition'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name'];
    $target = "../assets/images/" . basename($image);
    
    // Move uploaded image to assets/images
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {

        $seller_id = $_SESSION['user_id'];

        // Prepared statement to insert product into the database
        $sql = "INSERT INTO products (name, price, category,product_condition, description, image, seller_id) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        if ($stmt = $conn->prepare($sql)) {
            // Bind parameters to the query
            $stmt->bind_param("sdsssss", $name, $price, $category, $condition, $description, $image, $seller_id);

            // Execute the query
            if ($stmt->execute()) {
                echo "<script>alert('Product added successfully!'); window.location='manage-products.php';</script>";
            } else {
                echo "<script>alert('Error adding product.');</script>";
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "<script>alert('Database error.');</script>";
        }
    } else {
        echo "<script>alert('Error uploading image.');</script>";
    }
}
?>

<section class="add-product py-5">
    <div class="container">
        <h2 class="text-center mb-4">Add New Product:</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group mb-3">
                <label for="name">Product Name:</label>
                <input type="text" class="form-control" name="name" id="name" required>
            </div>
            <div class="form-group mb-3">
                <label for="price">Price:</label>
                <input type="number" class="form-control" name="price" id="price" required>
            </div>
            <div class="form-group mb-3">
                <label for="category">Category:</label>
                <select class="form-control" name="category" id="category" required>
                    <option value="engines">Engines</option>
                    <option value="brakes">Brakes</option>
                    <option value="suspension">Suspension</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="condition">Condition:</label>
                <select class="form-control" name="condition" id="condition" required>
                    <option value="new">New</option>
                    <option value="used">Used</option>
                    <option value="refurbished">Refurbished</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="description">Description:</label>
                <textarea class="form-control" name="description" id="description" rows="4" required></textarea>
            </div>
            <div class="form-group mb-4">
                <label for="image">Product Image:</label>
                <input type="file" class="form-control-file" name="image" id="image" required>
            </div>
            <button type="submit" class="btn btn-warning w-100">Add Product</button>
        </form>
    </div>
</section>


