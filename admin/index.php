<?php
// Start the session to handle user login information
session_start(); 

// Include the database connection file
include '../database.php'; // Adjust the path to your actual database connection

// Logout functionality
if (isset($_GET['logout'])) {
    session_destroy(); // Destroy the session
    header("Location: ../login.php"); // Redirect to login page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('../images/adminbackground.jpg'); /* Path to the background image */
            background-size: cover;  /* Ensures the image covers the entire page */
            background-position: center; /* Centers the background image */
            background-repeat: no-repeat; /* Prevents the background image from repeating */
            background-attachment: fixed; /* Fixes the background image in place when scrolling */
            margin: 0;
            padding: 0;
            color: black; /* Sets default text color */
        }

        /* Navbar Styling */
        nav {
            background-color: rgba(0, 0, 0, 0.9); /* Darker transparent background */
            padding: 10px;
            text-align: center;
        }

        nav a {
            color: white;
            margin-right: 20px;
            text-decoration: none;
            font-size: 16px;
        }

        nav a:hover {
            background-color: rgba(255, 255, 255, 0.2); /* Adds a hover effect */
            padding: 10px;
            border-radius: 4px;
        }

        /* Main Container */
        .container {
            width: 80%;
            margin: 0 auto;
            margin-top: 20px;
        }

        /* Heading */
        h1 {
            margin-top: 20px;
            text-align: center;
        }

        /* Tiles Grid Layout */
        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* 2 columns */
            grid-gap: 20px;
            margin-top: 30px;
        }

        /* Tile Styling */
        .tile {
            background-color: white; /* White background */
            padding: 40px; /* Increased padding for larger tiles */
            text-align: center;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            color: black; /* Black text */
            font-size: 20px; /* Slightly larger text */
            font-weight: bold;
        }

        .tile:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.2); /* Add more shadow on hover */
        }

        /* Logout Button */
        .logout-btn {
            float: right;
            background-color: red;
            color: white;
            padding: 10px;
            text-decoration: none;
            border-radius: 4px;
            margin-right: 20px;
        }

        .logout-btn:hover {
            background-color: darkred;
        }

        /* General Body Styling */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f8fb;
            color: #333;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Form Styling */
        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #e7f1fb;
            border-radius: 10px;
            padding: 40px;
            max-width: 400px;
            margin: auto;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-top: 100px;
        }

        /* Input fields styling */
        .box {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 25px;
            background-color: #fff;
            color: #333;
            font-size: 14px;
            transition: all 0.3s ease-in-out;
        }

        .box:focus {
            outline: none;
            border-color: #85b8e3;
        }

        /* Button Styling */
        .btn {
            display: inline-block;
            background-color: #5c9bd8;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            text-align: center;
            transition: background-color 0.3s ease-in-out;
        }

        .btn:hover {
            background-color: #468ac1;
        }

        /* Product and Card Styling (Rounded Rectangle Elements) */
        .card {
            background-color: #fff;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin: 20px;
            transition: all 0.3s ease-in-out;
        }

        .card:hover {
            box-shadow: 0 8px 12px rgba(0,0,0,0.15);
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav>
    <a href="admindashboard.php">Home</a>
    <a href="customers.php">Customers</a>
    <a href="orders.php">Orders</a>
    <a href="products.php">Products</a>
    <a href="vendors.php">Vendors</a>
    <?php if (isset($_SESSION['customer_id'])): ?>
        <a href="?logout=true" class="logout-btn">Logout</a> <!-- Logout button -->
    <?php else: ?>
        <a href="../login.php">Logout</a>
    <?php endif; ?>
</nav>

<div class="container">
    <h1>Online Sales Management System</h1>

    <!-- Grid Layout for Tiles -->
    <div class="grid">
        <!-- Customers Tile -->
        <a href="customers.php" class="tile">
            <span>Customers</span>
        </a>

        <!-- Orders Tile -->
        <a href="orders.php" class="tile">
            <span>Orders</span>
        </a>

        <!-- Products Tile -->
        <a href="products.php" class="tile">
            <span>Products</span>
        </a>

        <!-- Vendors Tile -->
        <a href="vendors.php" class="tile">
            <span>Vendors</span>
        </a>
    </div>
</div>

</body>
</html>
