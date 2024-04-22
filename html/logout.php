<?php
// Start session
session_start();

// Unset all of the session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect to login page or any other desired page
header("Location: Login.php");
exit;
?>