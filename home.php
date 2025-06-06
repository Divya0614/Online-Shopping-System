<?php include 'session_check.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Online Shopping - Home</title>
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h2>
    <a href="logout.php">Logout</a>
    <hr>
    <!-- Include your product list here -->
    <p>Here are your products...</p>
</body>
</html>
