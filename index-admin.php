<?php  
include '../database.php'; // Adjust the path to include the database connection
session_start(); // Start the session to handle user login information

// Logout functionality
if (isset($_GET['logout'])) {
    session_destroy(); // Destroy the session
    header("Location: ../login.php"); // Redirect to login page
    exit();
}

// Include the HTML layout file
include 'dashboard_template.html';
?>
