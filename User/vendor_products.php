<?php
include '../database.php'; // Include the database connection

// Start session
session_start();

// Open database connection
open_connection();

// Check if 'vendor_id' is passed in the URL
if (isset($_GET['vendor_id'])) {
    $vendor_id = intval($_GET['vendor_id']); // Sanitize the input

    // Fetch products related to the vendor
    $sql_products = "SELECT * FROM Product WHERE VendorID = $vendor_id";
    $products = select_rows($sql_products);
} else {
    // If no vendor_id is set, show an error message
    $products = [];
    echo "<p style='color: red;'>Error: No vendor selected. Please go back and select a vendor.</p>";
}

// Close the database connection
close_connection();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('../images/background.jpg'); /* Adjust background path */
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
            color: white;
            position: relative;
        }

        /* Adding a dark overlay over the background */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.6); /* Dark overlay */
            z-index: 1;
            filter: blur(5px); /* Blurring the background */
        }

        /* Ensuring the main content stays above the dark overlay */
        .content {
            position: relative;
            z-index: 2; /* Set above the background overlay */
            max-width: 1200px; /* Maximum width for content */
            margin: 50px auto; /* Centering the container */
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.1); /* Slightly transparent container */
            border-radius: 15px;
        }

        .menu {
            text-align: center;
            background-color: rgba(0, 0, 0, 0.8);
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
            color: #f5f5f5;
            margin-top: 20px;
        }

        .product-grid {
            display: flex; /* Use flexbox for alignment */
            flex-wrap: wrap; /* Allow items to wrap to the next line */
            justify-content: center; /* Center the product boxes */
            margin: 20px 0;
            gap: 20px; /* Space between boxes */
        }

        .product-card {
            background: rgba(255, 215, 0, 0.8); /* Slightly transparent yellow background */
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            color: black;
            width: 200px; /* Fixed width for uniformity */
            transition: transform 0.3s;
        }

        .product-card:hover {
            transform: scale(1.05);
        }

        .product-card img {
            max-width: 100%;
            height: auto;
            border-radius: 5px; /* Rounded corners for images */
        }

        .price {
            font-size: 20px;
            font-weight: bold;
            margin: 10px 0;
        }

        .add-to-cart {
            background-color: #007bff; /* Button color */
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .add-to-cart:hover {
            background-color: #0056b3; /* Darker on hover */
        }
    </style>
</head>
<body>

<div class="content">
    <div class="menu">
        <a href="userdashboard.php">Home</a>
        <a href="all_products.php">All Products</a>
        <a href="contact.php">Contact Us</a>
        <a href="about.php">About Us</a>
    </div>

    <h1>Vendor Products</h1>

    <?php if (count($products) > 0): ?>
        <div class="product-grid">
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <img src="../images/<?php echo htmlspecialchars($product['ImageURL']); ?>" alt="<?php echo htmlspecialchars($product['ProductName']); ?>">
                    <div>
                        <h2><?php echo htmlspecialchars($product['ProductName']); ?></h2>
                        <p>Description: <?php echo htmlspecialchars($product['Description']); ?></p>
                        <div class="price">$<?php echo htmlspecialchars($product['Price']); ?></div>
                        <form method="post" action="cart.php">
                            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['ProductID']); ?>">
                            <input type="number" name="quantity" value="1" min="1">
                            <button type="submit" name="add_to_cart" class="add-to-cart">Add to Cart</button>
                        </form>
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
