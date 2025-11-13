<?php
include "conn.php";

// Check login - SEMUA USER YANG LOGIN BISA AKSES
if (!isset($_SESSION['username'])) {
    header("Location: index.php?page=login");
    exit();
}

// Dapatkan user_id dari session
$user_id = $_SESSION['user_id'];

// Handle Tambah Product (hanya admin yang bisa tambah)
if (isset($_POST['tambah_product']) && $_SESSION['role'] == 'admin') {
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $stock = mysqli_real_escape_string($conn, $_POST['stock']);
    $supplier_id = mysqli_real_escape_string($conn, $_POST['supplier_id']);

    $query = "INSERT INTO product (product_name, price, type, stock, supplier_id) 
              VALUES ('$product_name', '$price', '$type', '$stock', '$supplier_id')";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Produk berhasil ditambahkan!');</script>";
        echo "<script>window.location.href='index.php?page=product';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}

// Handle Hapus Product (hanya admin yang bisa hapus)
if (isset($_GET['delete_id']) && $_SESSION['role'] == 'admin') {
    $delete_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM product WHERE product_id = '$delete_id'";
    if (mysqli_query($conn, $delete_query)) {
        echo "<script>alert('Produk berhasil dihapus!');</script>";
        echo "<script>window.location.href='index.php?page=product';</script>";
    }
}
?>

<!-- ====== STYLE LANGSUNG DALAM FILE ====== -->
<style>
/* === General Reset === */
body {
    font-family: Arial, Helvetica, sans-serif;
    background: #f4f6f9;
    margin: 0;
    padding: 0;
    color: #333;
}

/* === Container === */
.container {
    width: 90%;
    max-width: 1200px;
    margin: 60px auto;
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

/* === Headings === */
h2, h3 {
    text-align: center;
    color: #444;
    margin-bottom: 20px;
}

/* === Table Style === */
.data-table {
    width: 100%;
    border-collapse: collapse;
    margin: 25px 0;
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.data-table th, 
.data-table td {
    padding: 12px 15px;
    text-align: center;
    border-bottom: 1px solid #eee;
}

.data-table th {
    background: #007BFF;
    color: white;
    font-weight: bold;
}

.data-table tr:nth-child(even) {
    background: #f9f9f9;
}

.data-table tr:hover {
    background: #eaf2ff;
    transition: 0.3s;
}

/* Tombol Edit & Delete */
.btn-edit,
.btn-delete {
    padding: 6px 12px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 14px;
    font-weight: bold;
    transition: all 0.3s ease;
}

.btn-edit {
    background: #ffc107;
    color: #000;
}

.btn-edit:hover {
    background: #e0a800;
}

.btn-delete {
    background: #dc3545;
    color: white;
}

.btn-delete:hover {
    background: #c82333;
}

/* === Form Style === */
form {
    display: flex;
    flex-direction: column;
    gap: 12px;
    max-width: 500px;
    margin: 0 auto;
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.05);
}

label {
    font-size: 14px;
    font-weight: bold;
    color: #555;
}

input[type="text"],
input[type="number"] {
    padding: 10px 12px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 14px;
    transition: all 0.3s ease;
}

input:focus {
    border-color: #007BFF;
    outline: none;
    box-shadow: 0 0 4px rgba(0,123,255,0.3);
}

/* Tombol Tambah Produk */
button {
    padding: 12px;
    background: #007BFF;
    border: none;
    border-radius: 8px;
    color: white;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s;
}

button:hover {
    background: #0056b3;
}

/* === Responsive Design === */
@media (max-width: 768px) {
    .data-table th, .data-table td {
        padding: 10px 8px;
        font-size: 13px;
    }

    form {
        width: 90%;
        padding: 20px;
    }
}
</style>

<!-- ====== KONTEN HALAMAN ====== -->

<div class="container">
    <h2>Master Product</h2>
    <h3>Daftar Product</h3>

    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Product</th>
                <th>Harga</th>
                <th>Tipe</th>
                <th>Stok</th>
                <th>Supplier ID</th>
                <?php if ($_SESSION['role'] == 'admin'): ?>
                    <th>Action</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
        <?php
        $query = "SELECT * FROM product ORDER BY product_id ASC";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            echo "<tr><td colspan='7'>Error: " . mysqli_error($conn) . "</td></tr>";
        } elseif (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['product_id']}</td>
                        <td>{$row['product_name']}</td>
                        <td>Rp " . number_format($row['price'], 0, ',', '.') . "</td>
                        <td>{$row['type']}</td>
                        <td>{$row['stock']}</td>
                        <td>{$row['supplier_id']}</td>";
                
                if ($_SESSION['role'] == 'admin') {
                    echo "<td>
                            <a href='edit_product.php?id={$row['product_id']}' class='btn-edit'>Edit</a>
                            <a href='index.php?page=product&delete_id={$row['product_id']}' class='btn-delete' onclick='return confirm(\"Yakin hapus product ini?\")'>Delete</a>
                          </td>";
                }
                
                echo "</tr>";
            }
        } else {
            $colspan = $_SESSION['role'] == 'admin' ? 7 : 6;
            echo "<tr><td colspan='$colspan' style='text-align:center;'>Tidak ada data product.</td></tr>";
        }
        ?>
        </tbody>
    </table>

    <?php if ($_SESSION['role'] == 'admin'): ?>
        <h3>Tambah Product Baru</h3>
        <form method="post" action="">
            <label>Nama Product:</label>
            <input type="text" name="product_name" required>

            <label>Harga:</label>
            <input type="number" name="price" step="0.01" required>

            <label>Tipe:</label>
            <input type="text" name="type" required>

            <label>Stok:</label>
            <input type="number" name="stock" required>

            <label>Supplier ID:</label>
            <input type="number" name="supplier_id" required>

            <button type="submit" name="tambah_product">Tambah Product</button>
        </form>
    <?php endif; ?>
</div>
