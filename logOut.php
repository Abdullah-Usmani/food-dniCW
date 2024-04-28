<?php
session_start(); // Start the session
unset($_SESSION["user_id"]); // Unset all session variables
// session_destroy(); // Destroy the session data

// Redirect the user to a login page or any other page after logout
header("Location: signup.php");
exit(); // Ensure that script execution stops after redirection
?>
