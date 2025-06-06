<?php include 'session_check.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Your Cart</title>
  <style>
    body { font-family: Arial; padding: 20px; background: #f2f2f2; }
    table { width: 100%; background: white; border-collapse: collapse; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    th, td { padding: 12px; border: 1px solid #ddd; text-align: center; }
    th { background: #0077cc; color: white; }
    .remove-btn { color: red; text-decoration: none; font-weight: bold; }
    .total { text-align: right; margin-top: 20px; font-size: 18px; font-weight: bold; }
    a.back { display: inline-block; margin-top: 20px; text-decoration: none; background: #0077cc; color: white; padding: 10px 16px; border-radius: 4px; }
  </style>
</head>
<body>

<h2>🛒 Your Cart</h2>

<?php if (!empty($_SESSION['cart'])): ?>
<table>
  <tr>
    <th>Product</th>
    <th>Price</th>
    <th>Quantity</th>
    <th>Subtotal</th>
    <th>Action</th>
  </tr>
  <?php
    $total = 0;
    foreach ($_SESSION['cart'] as $index => $item):
    // Skip if not a proper array
    if (!is_array($item) || !isset($item['price'], $item['qty'], $item['name'])) {
        continue;
    }

    $subtotal = $item['price'] * $item['qty'];
    $total += $subtotal;
?>
<tr>
    <td><?php echo htmlspecialchars($item['name']); ?></td>
    <td>$<?php echo number_format($item['price'], 2); ?></td>
    <td><?php echo $item['qty']; ?></td>
    <td>$<?php echo number_format($subtotal, 2); ?></td>
    <td><a href="cart/remove_from_cart.php?index=<?php echo $index; ?>">Remove</a></td>
</tr>
<?php endforeach; ?>

</table>

<p class="total">Total: $<?php echo number_format($total, 2); ?></p>

<?php else: ?>
<p>Your cart is empty.</p>
<?php endif; ?>

<a href="index.php" class="back">← Continue Shopping</a>

</body>
</html>
