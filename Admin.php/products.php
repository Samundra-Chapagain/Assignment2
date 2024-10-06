<?php
include 'database.php';
open_connection();

$sql = "SELECT * FROM Product"; // Fetch all products
$products = select_rows($sql);
close_connection();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
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
        .actions {
            text-align: center;
            margin-bottom: 20px;
        }
        .actions a {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
        }
        .container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
        }
        .product-box {
            flex: 0 0 300px;
            background-color: #333;
            color: white;
            padding: 20px;
            margin: 10px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3
