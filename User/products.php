<?php
include_once 'database.php';

// Check if vendor ID is set
if (!isset($_GET['vendor_id'])) {
    die("Vendor ID not provided.");
}

$vendorId = intval($_GET['vendor_id']); // Get vendor ID from the URL

// Fetch products based on the vendor ID
$products = get_products_by_vendor($vendorId);
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
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .product-card {
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 15px;
            margin: 10px 0;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>

<div class="menu">
    <a href="index.php">Home</a>
    <a href="contact.php">Contact Us</a>
    <a href="about.php">About Us</a>
</div>

<div class="container">
    <h1>Products by Vendor</h1>

    <?php if (count($products) > 0): ?>
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <h2><?php echo htmlspecialchars($product['ProductName']); ?></h2>
                <p>Price: $<?php echo htmlspecialchars($product['Price']); ?></p>
                <p>Stock Quantity: <?php echo htmlspecialchars($product['StockQuantity']); ?></p>
                <p>Description: <?php echo htmlspecialchars($product['Description']); ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No products found for this vendor.</p>
    <?php endif; ?>
</div>

</body>
</html>
