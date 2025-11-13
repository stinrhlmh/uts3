<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP Login System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <a href="index.php">Home</a> |
        <?php if (!isset($_SESSION['username'])): ?>
            <a href="index.php?page=login">Login</a> |
            <a href="index.php?page=register">Register</a>
        <?php else: ?>
            <a href="index.php?page=dashboard">Dashboard</a> |
            <!-- PRODUCT BISA DIAKSES SEMUA USER -->
            <a href="index.php?page=product">Master Product</a> |
            <?php if ($_SESSION['role'] == 'admin'): ?>
                <!-- HANYA ADMIN YANG BISA AKSES USER & SUPPLIER -->
                <a href="index.php?page=user">Master User</a> | 
                <a href="index.php?page=supplier">Master Supplier</a> |
            <?php endif; ?>
            <a href="logout.php">Logout</a>
        <?php endif; ?>
    </nav>

    <div class="container">
    <?php
    if (isset($_GET['page'])) {
        $page = $_GET['page'];

        // CEK AKSES: Hanya user dan supplier yang butuh admin
        $admin_pages = ['user', 'supplier']; // ✅ HAPUS 'product' DARI SINI
        if (in_array($page, $admin_pages) && (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin')) {
            echo "<h2>Access Denied</h2>";
            echo "<p>You don't have permission to access this page.</p>";
        } else {
            if ($page == "login") {
                include "login.php";
            } elseif ($page == "register") {
                include "register.php";
            } elseif ($page == "dashboard") {
                include "dashboard.php";
            } elseif ($page == "user") {
                include "user.php";
            } elseif ($page == "product") {
                include "product.php";
            } elseif ($page == "supplier") {
                include "supplier.php";
            } else {
                echo "<h2>404 - Page not found!</h2>";
            }
        }
    } else {
        echo "<h2>Welcome</h2><p>Please select Login or Register from the menu above.</p>";
    }
    ?>
    </div>
</body>
</html>