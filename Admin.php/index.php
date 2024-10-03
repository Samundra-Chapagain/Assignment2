<?php
include 'database.php';
open_connection();

$sql = "SELECT * FROM Product LIMIT 4"; // Adjust as needed
$categories = select_rows($sql);
close_connection();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendors</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .menu {
            text-align: center;
            background-color: #333;
            padding: 10px;
        }
        .menu a {
            color: white;
            padding: 14px 20px;
            text-decoration: none;
            margin: 0 10px;
            border-radius: 4px;
        }
        .menu a:hover {
            background-color: #575757;
        }
        h1 {
            text-align: center;
        }
        .container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
        }
        .category-box {
            flex: 0 0 200px; /* Set width of each box */
            height: 200px; /* Set height of each box */
            margin: 10px;
            position: relative;
            cursor: pointer;
            border-radius: 8px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white; /* Text color */
            font-size: 18px;
            text-align: center;
            transition: transform 0.3s;
            background-color: #333; /* Fallback color */
        }
        .category-box:hover {
            transform: scale(1.05); /* Slight zoom effect on hover */
        }
        .category-box img {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
            object-fit: cover; /* Ensures the image covers the box */
            opacity: 0.5; /* Adjust opacity for the background */
            z-index: 1; /* Set z-index to place it below the text */
        }
        .category-box span {
            position: relative; /* Positioning the text above the image */
            z-index: 2; /* Ensure text is above the image */
        }
    </style>
</head>
<body>

<div class="menu">
    <a href="index.php">Home</a>
    <a href="contact.php">Contact Us</a>
    <a href="about.php">About Us</a>
</div>

<h1>Select a Product Category</h1>
<div class="container">
</div>

</body>
</html>
