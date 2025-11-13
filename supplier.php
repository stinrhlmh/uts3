<?php
include "conn.php";

// Check login dan role admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php?page=login");
    exit();
}

// Handle Tambah Supplier
if (isset($_POST['tambah_supplier'])) {
    $supplier_name = mysqli_real_escape_string($conn, $_POST['supplier_name']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    $query = "INSERT INTO supplier (supplier_name, contact, address) 
              VALUES ('$supplier_name', '$contact', '$address')";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Supplier berhasil ditambahkan!');</script>";
        echo "<script>window.location.href='index.php?page=supplier';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}

// Handle Hapus Supplier
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM supplier WHERE supplier_id = '$delete_id'";
    if (mysqli_query($conn, $delete_query)) {
        echo "<script>alert('Supplier berhasil dihapus!');</script>";
        echo "<script>window.location.href='index.php?page=supplier';</script>";
    }
}
?>

<style>
/* === General Reset & Layout === */
body {
    font-family: Arial, Helvetica, sans-serif;
    background: #f4f6f9;
    margin: 0;
    padding: 0;
    color: #333;
}

.container {
    width: 90%;
    max-width: 1200px;
    margin: 60px auto;
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

/* Headings */
h2, h3 {
    text-align: center;
    color: #444;
    margin-bottom: 20px;
}

/* Form Style */
form {
    display: flex;
    flex-direction: column;
    gap: 12px;
    max-width: 500px;
    margin: 30px auto 0 auto;
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
textarea {
    padding: 10px 12px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 14px;
    transition: all 0.3s ease;
    resize: vertical;
    min-height: 60px;
}

input[type="text"]:focus,
textarea:focus {
    border-color: #007BFF;
    outline: none;
    box-shadow: 0 0 4px rgba(0,123,255,0.3);
}

/* Button */
button {
    padding: 12px;
    background: #007BFF;
    border: none;
    border-radius: 8px;
    color: white;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s;
    margin-top: 10px;
}

button:hover {
    background: #0056b3;
}

/* Table Style */
.data-table {
    width: 100%;
    border-collapse: collapse;
    margin: 0 auto 30px auto;
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

/* Responsive */
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

<div class="container">
    <h2>Master Supplier (Admin Only)</h2>

    <h3>Daftar Supplier</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Supplier</th>
                <th>Kontak</th>
                <th>Alamat</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $query = "SELECT * FROM supplier ORDER BY supplier_id ASC";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            echo "<tr><td colspan='5'>Error: " . mysqli_error($conn) . "</td></tr>";
        } elseif (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['supplier_id']}</td>
                        <td>{$row['supplier_name']}</td>
                        <td>{$row['contact']}</td>
                        <td>{$row['address']}</td>
                        <td>
                            <a href='edit_supplier.php?id={$row['supplier_id']}' class='btn-edit'>Edit</a>
                            <a href='index.php?page=supplier&delete_id={$row['supplier_id']}' class='btn-delete' onclick='return confirm(\"Yakin hapus supplier ini?\")'>Delete</a>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='5' style='text-align:center;'>Tidak ada data supplier.</td></tr>";
        }
        ?>
        </tbody>
    </table>

    <h3>Tambah Supplier Baru</h3>
    <form method="post" action="">
        <label>Nama Supplier:</label>
        <input type="text" name="supplier_name" required>

        <label>Kontak:</label>
        <input type="text" name="contact" required>

        <label>Alamat:</label>
        <textarea name="address" required></textarea>

        <button type="submit" name="tambah_supplier">Tambah Supplier</button>
    </form>
</div>
