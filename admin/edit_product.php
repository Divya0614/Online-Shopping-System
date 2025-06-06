<?php
include '../includes/db.php';
include '../includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_name'] !== 'admin') {
    echo "<p class='error-msg'>Access denied.</p>";
    include '../includes/footer.php';
    exit();
}

if (!isset($_GET['id'])) {
    echo "<p class='error-msg'>Product ID missing.</p>";
    exit();
}

$id = intval($_GET['id']);

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // Get current image
    $result = $conn->query("SELECT image FROM products WHERE id = $id");
    $currentImage = '';
    if ($result && $row = $result->fetch_assoc()) {
        $currentImage = $row['image'];
    }

    // Handle image upload if new image provided
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $targetDir = '../assets/images/';
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        $targetFilePath = $targetDir . $imageName;

        $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageFileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                // Delete old image file
                if ($currentImage && file_exists($targetDir . $currentImage)) {
                    unlink($targetDir . $currentImage);
                }
                $currentImage = $imageName;
            } else {
                echo "<p class='error-msg'>Error uploading image.</p>";
            }
        } else {
            echo "<p class='error-msg'>Invalid image file type.</p>";
        }
    }

    $stmt = $conn->prepare("UPDATE products SET name = ?, price = ?, image = ?, description = ? WHERE id = ?");
    $stmt->bind_param("sdssi", $name, $price, $currentImage, $description, $id);
    $stmt->execute();

    echo "<p class='success-msg'>Product updated!</p>";
}

// Fetch product to edit
$result = $conn->query("SELECT * FROM products WHERE id = $id");
$product = $result->fetch_assoc();

?>

<div class="form-container">
    <h3>Edit Product</h3>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required><br><br>
        <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" required><br><br>
        <img src="../assets/images/<?= htmlspecialchars($product['image']) ?>" alt="Product Image" width="150"><br><br>
        <input type="file" name="image" accept="image/*"><br><small>Upload new image to replace old one</small><br><br>
        <textarea name="description"><?= htmlspecialchars($product['description']) ?></textarea><br><br>
        <button type="submit" name="update">Update Product</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
