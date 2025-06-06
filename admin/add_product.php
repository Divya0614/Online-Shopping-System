<?php
include '../includes/db.php';
include '../includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_name'] !== 'admin') {
    echo "<p class='error-msg'>Access denied. Only admin can access this page.</p>";
    include '../includes/footer.php';
    exit();
}

if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // Handle image upload
    $imageName = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $targetDir = '../assets/images/';
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        $targetFilePath = $targetDir . $imageName;

        $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageFileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                // Uploaded successfully
            } else {
                echo "<p class='error-msg'>Error uploading image.</p>";
            }
        } else {
            echo "<p class='error-msg'>Invalid image file type.</p>";
        }
    }

    $stmt = $conn->prepare("INSERT INTO products (name, price, image, description) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdss", $name, $price, $imageName, $description);
    $stmt->execute();

    echo "<p class='success-msg'>Product added!</p>";
}
?>

<div class="form-container">
    <h3>Add New Product</h3>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Product Name" required><br><br>
        <input type="number" step="0.01" name="price" placeholder="Price (₹)" required><br><br>
        <input type="file" name="image" accept="image/*" required><br><br>
        <textarea name="description" placeholder="Product Description"></textarea><br><br>
        <button type="submit" name="add">Add Product</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
