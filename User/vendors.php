<?php
session_start(); // Start the session to handle user login information
include '../database.php'; // Include your database connection

// Open the connection and check if it's successful
open_connection();

// Get the vendor ID from the URL, ensuring it's valid
$vendorId = filter_input(INPUT_GET, 'vendor_id', FILTER_VALIDATE_INT);

// Fetch products related to the selected vendor
$products = [];
if ($vendorId) {
    $sql = "SELECT * FROM Product WHERE VendorID = ?";
    $stmt = $conn->prepare($sql); // Prepare the statement
    $stmt->bind_param("i", $vendorId); // Bind parameters
    $stmt->execute(); // Execute the statement
    $result = $stmt->get_result(); // Get the result set

    if ($result->num_rows > 0) {
        $products = $result->fetch_all(MYSQLI_ASSOC); // Fetch all products
    } else {
        echo "<p>No products found for this vendor.</p>";
    }
}

// Close connection after fetching data
close_connection();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products by Vendor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .menu {
            text-align: center;
            margin-bottom: 20px;
        }
        .menu a {
            margin: 0 10px;
            text-decoration: none;
            color: #333;
        }
        .product-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .product-card {
            background: white;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            padding: 15px;
            text-align: center;
            width: 200px; /* Adjust width as necessary */
        }
        .product-card img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }
        .price {
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body>

<div class="menu">
    <a href="userdashboard.php">Home</a>
    <a href="all_products.php">Products</a>
    <a href="contact.php">Contact Us</a>
    <a href="about.php">About Us</a>
</div>

<div class="container">
    <h1>Products from Vendor ID: <?php echo htmlspecialchars($vendorId); ?></h1>
    
    <?php if (!empty($products)): ?>
        <div class="product-grid">
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <?php if (!empty($product['ImageURL'])): ?>
                        <img src="../images/<?php echo htmlspecialchars($product['ImageURL']); ?>" alt="<?php echo htmlspecialchars($product['ProductName']); ?>">
                    <?php endif; ?>
                    <div>
                        <h2><?php echo htmlspecialchars($product['ProductName']); ?></h2>
                        <p>Stock Quantity: <?php echo htmlspecialchars($product['StockQuantity']); ?></p>
                        <p>Description: <?php echo htmlspecialchars($product['Description']); ?></p>
                        <div class="price">$<?php echo htmlspecialchars($product['Price']); ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No products found for this vendor.</p>
    <?php endif; ?>
</div>

</body>
</html>
