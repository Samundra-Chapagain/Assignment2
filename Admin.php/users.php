<?php
include 'database.php';
open_connection();

$sql = "SELECT * FROM Customer"; // Fetch all customers
$customers = select_rows($sql);
close_connection();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
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
        .user-box {
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
        .user-box:hover {
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
    <a href="vendors.php">Vendors</a>
    <a href="products.php">Products</a>
</div>

<h1>Manage Users</h1>
<div class="actions">
    <a href="add_user.php">Add New User</a>
</div>

<div class="container">
    <?php foreach ($customers as $customer): ?>
        <div class="user-box">
            <h3><?php echo $customer['FirstName'] . " " . $customer['LastName']; ?></h3>
            <p>Email: <?php echo $customer['Email']; ?></p>
            <p>Phone: <?php echo $customer['Phone']; ?></p>
            <p>City: <?php echo $customer['City']; ?></p>
            <div class="action-links">
                <a href="edit_user.php?id=<?php echo $customer['CustomerID']; ?>">Edit</a>
                <a href="delete_user.php?id=<?php echo $customer['CustomerID']; ?>">Delete</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
