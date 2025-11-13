<?php
session_start();
include "conn.php";

// Check login dan role admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php?page=login");
    exit();
}

$supplier_id = $_GET['id'];

// Ambil data supplier yang akan diedit
$query = "SELECT * FROM supplier WHERE supplier_id = '$supplier_id'";
$result = mysqli_query($conn, $query);
$supplier = mysqli_fetch_assoc($result);

if (!$supplier) {
    echo "<script>alert('Supplier tidak ditemukan!'); window.location='index.php?page=supplier';</script>";
    exit();
}

// Handle Update Supplier
if (isset($_POST['update_supplier'])) {
    $supplier_name = mysqli_real_escape_string($conn, $_POST['supplier_name']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    $update_query = "UPDATE supplier SET 
                    supplier_name = '$supplier_name',
                    contact = '$contact',
                    address = '$address'
                    WHERE supplier_id = '$supplier_id'";
    
    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Supplier berhasil diupdate!'); window.location='index.php?page=supplier';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Supplier</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .edit-container {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .form-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 3px solid #007BFF;
        }
        
        .form-header h2 {
            color: #2c3e50;
            margin: 0;
        }
        
        .id-display {
            background: #e9ecef;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            border-left: 4px solid #007BFF;
            font-weight: bold;
        }
        
        .edit-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
        }
        
        .form-group label {
            font-weight: bold;
            margin-bottom: 8px;
            color: #2c3e50;
            font-size: 14px;
        }
        
        .form-group input,
        .form-group textarea {
            padding: 12px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 14px;
            font-family: Arial, Helvetica, sans-serif;
            transition: border-color 0.3s ease;
        }
        
        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #007BFF;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
        }
        
        .form-group textarea {
            min-height: 100px;
            resize: vertical;
            line-height: 1.5;
        }
        
        .form-buttons {
            display: flex;
            gap: 15px;
            justify-content: flex-start;
            margin-top: 10px;
        }
        
        .btn-update {
            padding: 12px 30px;
            background: linear-gradient(135deg, #28a745, #218838);
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 16px;
        }
        
        .btn-cancel {
            padding: 12px 25px;
            background: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: background 0.3s ease;
            text-align: center;
            display: inline-block;
        }
        
        .btn-update:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
        }
        
        .btn-cancel:hover {
            background: #5a6268;
            transform: translateY(-2px);
            text-decoration: none;
            color: white;
        }
        
        @media (max-width: 768px) {
            .edit-container {
                margin: 10px;
                padding: 20px;
            }
            
            .form-buttons {
                flex-direction: column;
            }
            
            .btn-update,
            .btn-cancel {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <nav>
        <a href="index.php">Home</a> |
        <a href="index.php?page=supplier">Kembali ke Supplier</a> |
        <a href="logout.php">Logout</a>
    </nav>

    <div class="edit-container">
        <div class="form-header">
            <h2>Edit Supplier</h2>
        </div>
        
        <div class="id-display">
            📋 <strong>ID Supplier:</strong> <?php echo $supplier['supplier_id']; ?> 
            <span style="color: #666; font-size: 12px; margin-left: 10px;">(ID tidak dapat diubah)</span>
        </div>
        
        <form method="post" action="" class="edit-form">
            <div class="form-group">
                <label>Nama Supplier:</label>
                <input type="text" name="supplier_name" value="<?php echo htmlspecialchars($supplier['supplier_name']); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Kontak:</label>
                <input type="text" name="contact" value="<?php echo htmlspecialchars($supplier['contact']); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Alamat:</label>
                <textarea name="address" required><?php echo htmlspecialchars($supplier['address']); ?></textarea>
            </div>
            
            <div class="form-buttons">
                <button type="submit" name="update_supplier" class="btn-update">📝 Update Supplier</button>
                <a href="index.php?page=supplier" class="btn-cancel">❌ Batal</a>
            </div>
        </form>
    </div>
</body>
</html>