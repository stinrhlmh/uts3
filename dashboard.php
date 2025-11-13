<?php

// Check login status
if (!isset($_SESSION['username'])) {
    header("Location: index.php?page=login");
    exit();
}

echo "Selamat datang, " . $_SESSION['username'];

?>