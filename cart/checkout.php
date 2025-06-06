<?php
session_start();
require 'db.php'; // include your database connection

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch cart items
$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    echo "<p class='error-msg'>Your cart is empty.</p>";
    echo "<a href='index.php' class='button-link'>Go Shopping</a>";
    exit();
}

// Insert order into orders table
$order_query = $conn->prepare("INSERT INTO orders (user_id, created_at) VALUES (?, NOW())");
$order_query->bind_param("i", $user_id);
$order_query->execute();
$order_id = $order_query->insert_id;

// Insert each item into order_items table
$item_query = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)");
foreach ($cart as $product_id => $quantity) {
    $item_query->bind_param("iii", $order_id, $product_id, $quantity);
    $item_query->execute();
}

// Clear cart
unset($_SESSION['cart']);

echo "<div class='form-container'>";
echo "<h2>Thank you for your order!</h2>";
echo "<p class='success-msg'>Your order has been placed successfully.</p>";
echo "<a href='my-orders.php' class='button-link'>View My Orders</a>";
echo "</div>";
?>
