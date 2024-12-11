<?php
session_start();

// Destroy the session to log the user out
session_unset(); // Unsets all session variables
session_destroy(); // Destroys the session

// Redirect to login page or homepage after logging out
header("Location: login.php"); // Or use "home.php" if you want to redirect to the home page
exit();
