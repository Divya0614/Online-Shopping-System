<?php
session_start();


// Define products array indexed by product ID
$products = [
  1 => ['name'=>'Wireless Headphones', 'price'=>59.99],
  2 => ['name'=>'Smartphone', 'price'=>499.99],
  3 => ['name'=>'Laptop', 'price'=>899.99],
  4 => ['name'=>'Smartwatch', 'price'=>129.99],
  5 => ['name'=>'Tablet', 'price'=>249.99],
  6 => ['name'=>'Bluetooth Speaker', 'price'=>79.99],
  7 => ['name'=>'Gaming Console', 'price'=>399.99],
  8 => ['name'=>'External Hard Drive', 'price'=>99.99],
  9 => ['name'=>'4K Monitor', 'price'=>299.99],
  10 => ['name'=>'Wireless Mouse', 'price'=>29.99],
  11 => ['name'=>'VR Headset', 'price'=>349.99],
  12 => ['name'=>'Portable Charger', 'price'=>49.99],
  13 => ['name'=>"Men's T-Shirt", 'price'=>19.99],
  14 => ['name'=>"Women's Dress", 'price'=>49.99],
  15 => ['name'=>"Jeans", 'price'=>34.99],
  16 => ['name'=>"Jacket", 'price'=>59.99],
  17 => ['name'=>"Formal Shirt", 'price'=>29.99],
  18 => ['name'=>"Kurti", 'price'=>24.99],
  19 => ['name'=>"Saree", 'price'=>79.99],
  20 => ['name'=>"Skirt", 'price'=>39.99],
  21 => ['name'=>"Sweatshirt", 'price'=>44.99],
  22 => ['name'=>"Hoodie", 'price'=>49.99],
  23 => ['name'=>"Blazer", 'price'=>89.99],
  24 => ['name'=>"Lipstick", 'price'=>9.99],
  25 => ['name'=>"Foundation", 'price'=>19.99],
  26 => ['name'=>"Mascara", 'price'=>14.99],
  27 => ['name'=>"Face Cream", 'price'=>24.99],
  28 => ['name'=>"HairSerum", 'price'=>12.99],
  29 => ['name'=>"Eyeliner", 'price'=>7.99],
  30 => ['name'=>"Compact Powder", 'price'=>14.99],
  31 => ['name'=>"Blush", 'price'=>11.99],
  32 => ['name'=>"Nail Polish", 'price'=>5.99],
  34 => ['name'=>"Running Shoes", 'price'=>59.99],
  35 => ['name'=>"Sandals", 'price'=>29.99],
  36 => ['name'=>"Formal Shoes", 'price'=>69.99],
  37 => ['name'=>"Flip Flops", 'price'=>9.99],
  38 => ['name'=>"Boots", 'price'=>89.99],
  39 => ['name'=>"Heels", 'price'=>49.99],
  40 => ['name'=>"Sneakers", 'price'=>54.99],
  41 => ['name'=>"Loafers", 'price'=>39.99],
];
?>


<h2>Products</h2>
<ul>
<?php foreach ($products as $id => $product): ?>
    <li>
        <?php echo $product['name']; ?> - ₹<?php echo $product['price']; ?>
        <a href="add_to_cart.php?id=<?php echo $id; ?>">Add to Cart</a>
    </li>
<?php endforeach; ?>
</ul>

<a href="cart.php">Go to Cart</a>
