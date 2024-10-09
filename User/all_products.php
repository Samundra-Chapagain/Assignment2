<?php  
session_start(); // Start the session to handle the shopping cart

include_once '../database.php'; // Include your database connection functions

// Fetch all products from the database
function get_all_products() {
    open_connection(); // Open the database connection
    global $conn; // Access the global connection variable
    $sql = "SELECT * FROM Product"; // Query to fetch all products
    $rows = select_rows($sql); // Use the select_rows function to fetch results
    close_connection(); // Close the connection
    return $rows; // Return the products
}

$products = get_all_products(); // Fetch products from the database

// Handle adding to cart
if (isset($_POST['add_to_cart'])) {
    $productId = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);

    // Initialize cart if not already set
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add product to cart
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] += $quantity; // Update quantity if already in cart
    } else {
        $_SESSION['cart'][$productId] = $quantity; // Add new product to cart
    }

    // Redirect to avoid form resubmission
    header("Location: all_products.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('../images/background.jpg'); /* Background image path */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            height: 100vh;
            margin: 0;
            padding: 0;
            color: white; /* Change text color for visibility */
        }
        .menu {
            text-align: center;
            background-color: rgba(51, 51, 51, 0.8);
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
            color: #fff;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .product-grid {
            display: flex; /* Use flexbox for layout */
            flex-wrap: wrap; /* Allow wrapping of products */
            justify-content: center; /* Center the products */
            gap: 20px; /* Gap between product cards */
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
            transform: scale(1.05); /* Slightly enlarge on hover */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
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
            transition: background-color 0.3s;
        }
        .add-to-cart:hover {
            background-color: #0056b3; /* Darker on hover */
        }
    </style>
</head>
<body>

<div class="menu">
    <a href="userdashboard.php">Home</a>
    <a href="all_products.php">All Products</a>
    <a href="contact.php">Contact Us</a>
    <a href="about.php">About Us</a>
</div>

<div class="container">
    <h1>All Products</h1>

    <?php if (count($products) > 0): ?>
        <div class="product-grid">
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <img src="../images/<?php echo htmlspecialchars($product['ImageURL']); ?>" alt="<?php echo htmlspecialchars($product['ProductName']); ?>">
                    <div>
                        <h2><?php echo htmlspecialchars($product['ProductName']); ?></h2>
                        <p>Description: <?php echo htmlspecialchars($product['Description']); ?></p>
                        <div class="price">$<?php echo htmlspecialchars($product['Price']); ?></div>
                        <form method="post" action="">
                            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['ProductID']); ?>">
                            <input type="number" name="quantity" value="1" min="1" style="width: 50px;">
                            <button type="submit" name="add_to_cart" class="add-to-cart">Add to Cart</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No products available.</p>
    <?php endif; ?>
</div>

</body>
</html>
