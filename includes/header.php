<?php
// 1. Start the session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Connect to the database safely
require_once __DIR__ . '/db.php';

// 3. Define the Base URL
$base_url = '/Online-Library-Management-System--OLMS-/';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OLMS - Online Library</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        
        <a class="navbar-brand fw-bold d-flex align-items-center" href="<?php echo $base_url; ?>index.php">
            <img src="<?php echo $base_url; ?>assets/images/logo.png" alt="OLMS Logo" width="35" height="35" class="me-2">
            OLMS
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            
            <ul class="navbar-nav me-auto">
                <?php if (isset($_SESSION['user_id'])): ?>
                    
                    <?php if ($_SESSION['role'] === 'admin'): ?>
                        <li class="nav-item"><a class="nav-link" href="<?php echo $base_url; ?>admin/admin_index.php">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo $base_url; ?>admin/manage_books.php">Manage Books</a></li>
                        
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="<?php echo $base_url; ?>core/dashboard.php">My Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo $base_url; ?>catalog/books.php">Browse Books</a></li>
                    <?php endif; ?>
                    
                <?php endif; ?>
            </ul>

            <div class="d-flex align-items-center">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <span class="text-light me-3">
                        Hello, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>!
                    </span>
                    <a href="<?php echo $base_url; ?>auth/logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
                    
                <?php else: ?>
                    <a href="<?php echo $base_url; ?>auth/login.php" class="btn btn-outline-light me-2">Login</a>
                    <a href="<?php echo $base_url; ?>auth/register.php" class="btn btn-primary">Sign Up</a>
                <?php endif; ?>
            </div>

        </div>
    </div>
</nav>

<div class="container mt-4">