<?php
session_start();  // start session first
session_unset();  // remove all session variables
session_destroy(); // destroy the session

// redirect back to login page
header("Location: index.php?page=login");
exit();
?>