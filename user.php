<?php
include "conn.php";

// Check login dan role admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php?page=login");
    exit();
}
?>

<h2>User Management (Admin Only)</h2>

<table class="data-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $query = "SELECT * FROM users ORDER BY id ASC";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['username']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['role']}</td>
                    <td>
                        <a href='edit_user.php?id={$row['id']}' class='btn-edit'>Edit</a>
                        <a href='delete_user.php?id={$row['id']}' class='btn-delete' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                    </td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='5' style='text-align:center;'>No users found.</td></tr>";
    }
    ?>
    </tbody>
</table>