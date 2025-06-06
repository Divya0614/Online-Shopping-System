<?php
include '../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_name'] !== 'admin') {
    echo "Access denied.";
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Get image filename
    $result = $conn->query("SELECT image FROM products WHERE id = $id");
    if ($result && $row = $result->fetch_assoc()) {
        $image = $row['image'];
        if ($image) {
            $imagePath = "../assets/images/" . $image;
            if (file_exists($imagePath)) {
                unlink($imagePath); // delete image file
            }
        }
    }
    
    $conn->query("DELETE FROM products WHERE id = $id");
    header("Location: admin_panel.php?msg=deleted");
    exit();
}
?>
