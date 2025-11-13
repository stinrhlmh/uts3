<?php
$host     = "localhost";   // database server
$user     = "root";        // database username (default: root in XAMPP)
$password = "";            // database password (empty by default in XAMPP)
$database = "db_users";    // database name

// Create connection
$conn = mysqli_connect($host, $user, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
else{
    // echo "good connection";
}
?>