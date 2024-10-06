<?php
include 'database.php';
open_connection();

$sql = "SELECT * FROM Vendor"; // Fetch all vendors
$vendors = select_rows($sql);
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
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
        }
        .vendor-box {
            flex: 0 0 300px;
            background-color: #333;
            color: white;
            padding: 20px;
            margin: 10px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s;
        }
        .vendor-box:hover {
            transform: scale(1.05);
        }
        .action-links {
            margin-top: 10px;
        }
        .action-links a {
            margin: 0 5px;
            color: yellow;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="menu">
    <a href="index.php">Home</a>
    <a href="users.php">Users</a>
    <a href="products.php">Products</a>
</div>

<h1>Manage Vendors</h1>
<div class="actions">
    <a href="add_vendor.php">Add New Vendor</a>
</div>

<div class="container">
    <?php foreach ($vendors as $vendor): ?>
        <div class="vendor-box">
            <h3><?php echo $vendor['VendorName']; ?></h3>
            <p>Contact: <?php echo $vendor['ContactName']; ?></p>
            <p>Email: <?php echo $vendor['Email']; ?></p>
            <p>City: <?php echo $vendor['City']; ?></p>
            <div class="action-links">
                <a href="edit_vendor.php?id=<?php echo $vendor['VendorID']; ?>">Edit</a>
                <a href="delete_vendor.php?id=<?php echo $vendor['VendorID']; ?>">Delete</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
