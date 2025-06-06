<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Online Shopping</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<nav class="navbar">
    <a href="index.php">Home</a>

    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="cart.php">Cart</a>

        <?php if (isset($_SESSION['user_name']) && $_SESSION['user_name'] === 'admin'): ?>
            <a href="admin_panel.php">Admin</a>
        <?php endif; ?>

       <a href="logout.php">Logout (<?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'User'; ?>)</a>

    <?php else: ?>
        <a href="register.php">Register</a>
        <a href="login.php">Login</a>
    <?php endif; ?>
</nav>
<hr>
