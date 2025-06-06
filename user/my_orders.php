<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "
    SELECT o.id AS order_id, o.created_at, p.name, oi.quantity
    FROM orders o
    JOIN order_items oi ON o.id = oi.order_id
    JOIN products p ON oi.product_id = p.id
    WHERE o.user_id = ?
    ORDER BY o.created_at DESC
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$current_order = null;

echo "<div class='admin-container'>";
echo "<h2>My Orders</h2>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($current_order != $row['order_id']) {
            if ($current_order !== null) {
                echo "</table><br>";
            }
            $current_order = $row['order_id'];
            echo "<h3>Order ID: {$row['order_id']} | Date: {$row['created_at']}</h3>";
            echo "<table>";
            echo "<tr><th>Product</th><th>Quantity</th></tr>";
        }
        echo "<tr><td>{$row['name']}</td><td>{$row['quantity']}</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p>No orders found.</p>";
}

echo "</div>";
?>
