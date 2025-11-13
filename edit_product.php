<?php
session_start();
include "conn.php";

// Check login dan role admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php?page=login");
    exit();
}

$product_id = $_GET['id'];

// Ambil data product yang akan diedit
$query = "SELECT * FROM product WHERE product_id = '$product_id'";
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    echo "<script>alert('Product tidak ditemukan!'); window.location='index.php?page=product';</script>";
    exit();
}

// Handle Update Product
if (isset($_POST['update_product'])) {
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $stock = mysqli_real_escape_string($conn, $_POST['stock']);
    $supplier_id = mysqli_real_escape_string($conn, $_POST['supplier_id']);

    $update_query = "UPDATE product SET 
                    product_name = '$product_name',
                    price = '$price',
                    type = '$type',
                    stock = '$stock',
                    supplier_id = '$supplier_id'
                    WHERE product_id = '$product_id'";
    
    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Product berhasil diupdate!'); window.location='index.php?page=product';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <a href="index.php">Home</a> |
        <a href="index.php?page=product">Kembali ke Product</a> |
        <a href="logout.php">Logout</a>
    </nav>

    <div class="container">
        <h2>Edit Product</h2>
        
        <form method="post" action="">
            <label>Nama Product:</label>
            <input type="text" name="product_name" value="<?php echo $product['product_name']; ?>" required>
            
            <label>Harga:</label>
            <input type="number" name="price" step="0.01" value="<?php echo $product['price']; ?>" required>
            
            <label>Tipe:</label>
            <input type="text" name="type" value="<?php echo $product['type']; ?>" required>
            
            <label>Stok:</label>
            <input type="number" name="stock" value="<?php echo $product['stock']; ?>" required>
            
            <label>Supplier ID:</label>
            <input type="number" name="supplier_id" value="<?php echo $product['supplier_id']; ?>" required>
            
            <div style="display: flex; gap: 10px; margin-top: 20px;">
                <button type="submit" name="update_product" style="background: #28a745;">Update Product</button>
                <a href="index.php?page=product" style="padding: 10px; background: #6c757d; color: white; text-decoration: none; border-radius: 6px; text-align: center;">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>