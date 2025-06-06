<?php
include 'includes/db.php';
include 'includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_name'] !== 'admin') {
    echo "<p class='error-msg'>Access denied. Only admin can access this page.</p>";
    include 'includes/footer.php';
    exit();
}

// Add product
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("INSERT INTO products (name, price, image, description) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdss", $name, $price, $image, $description);
    $stmt->execute();
    echo "<p class='success-msg'>Product added!</p>";
}

// Delete product
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $conn->query("DELETE FROM products WHERE id = $delete_id");
    echo "<p class='error-msg'>Product deleted.</p>";
}

// Fetch products
$products = $conn->query("SELECT * FROM products");
?>

<div class="admin-container">
    <h2>Admin Panel</h2>

    <!-- Add Product Form -->
    <div class="form-container">
        <h3>Add New Product</h3>
        <form method="POST">
            <input type="text" name="name" placeholder="Product Name" required><br><br>
            <input type="number" step="0.01" name="price" placeholder="Price (₹)" required><br><br>
            <input type="text" name="image" placeholder="Image URL"><br><br>
            <textarea name="description" placeholder="Product Description"></textarea><br><br>
            <button type="submit" name="add">Add Product</button>
        </form>
    </div>

    <hr>

    <!-- Product List -->
    <div class="table-container">
        <h3>Manage Products</h3>
        <table>
            <tr>
                <th>ID</th><th>Name</th><th>Price</th><th>Action</th>
            </tr>
            <?php while ($row = $products->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td>₹<?= $row['price'] ?></td>
                    <td>
                        <a href="admin_panel.php?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
