<?php
session_start();
require 'includes/db.php';

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($email && $password) {
        $users = load_users();
        if (isset($users[$email])) {
            $error = "User already exists!";
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            save_user($email, $password_hash);
            $_SESSION['email'] = $email;
            $success = "Registered successfully! Redirecting...";
            header("refresh:2;url=index.php"); // Redirect after 2 seconds
        }
    } else {
        $error = "All fields are required!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | Online Shopping</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Create an Account</h4>
                </div>
                <div class="card-body">

                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>

                    <?php if ($success): ?>
                        <div class="alert alert-success"><?= $success ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label>Email address</label>
                            <input type="email" name="email" class="form-control" required placeholder="Enter your email">
                        </div>

                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required placeholder="Enter your password">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Register</button>
                    </form>
                </div>

                <div class="card-footer text-center">
                    Already have an account? <a href="login.php">Login here</a>
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
