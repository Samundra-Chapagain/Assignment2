<?php  
include '../database.php'; // Adjust the path to include the database connection
session_start(); // Start the session to handle user login information

// Open the connection and check if it's successful
open_connection();

// Fetch categories with their respective image URLs
$sql = "SELECT * FROM Category LIMIT 4"; 

// Fetching categories from the database
$categories = select_rows($sql);

// Fetch vendors from the database
$sql_vendors = "SELECT * FROM Vendor"; 
$vendors = select_rows($sql_vendors);

// Check if $categories is set and contains data
if (!$categories) {
    echo "<p style='color: red;'>Error: No categories found. Please check your database query.</p>";
}

// Close connection after fetching data
close_connection();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
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
        }

        .logo {
            width: 80px; /* Adjust logo size */
            vertical-align: middle; /* Align logo with text */
        }
        
        .welcome-message {
            color: white;
            text-align: center;
            font-size: 46px; /* Increased font size for welcome message */
            font-weight: bold; /* Bold text */
            margin-top: 30px; /* Space above the welcome message */
        }

        .tagline {
            color: white;
            text-align: center;
            font-size: 18px; /* Font size for tagline */
            font-weight: lighter; /* Light font weight */
            margin-top: 5px; /* Reduced to bring closer to welcome message */
            margin-bottom: 20px; /* Add bottom margin for spacing */
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

        .container {
            display: flex;
            flex-direction: column; /* Set layout to vertical */
            max-width: 800px; /* Adjust container width */
            margin: 30px auto; /* Centering the container */
            padding: 10px;
            background-color: rgba(255, 255, 255, 0.1); /* Slightly transparent container */
            border-radius: 15px;
        }

        .box {
            display: flex;
            justify-content: flex-start; /* Align items to the left */
            align-items: center;
            height: 100px; /* Consistent height */
            background: rgba(255, 215, 0, 0.8); /* Slightly transparent yellow background */
            border-radius: 10px;
            position: relative;
            overflow: hidden;
            margin-bottom: 15px; /* Reduced margin between rows */
            cursor: pointer;
            transition: transform 0.3s;
        }
        .box:hover {
            transform: scale(1.05);
        }
        .box img {
            width: 80px; /* Set width for vendor logo */
            height: 80px; /* Set height for vendor logo */
            margin-right: 10px; /* Space between image and text */
            border-radius: 4px; /* Optional: rounded corners for images */
        }
        .box span {
            font-size: 18px; /* Font size for vendor name */
            color: white;
            text-align: left; /* Align text to the left */
            margin-left: 10px; /* Space from the image */
        }

        h1 {
            text-align: center;
            color: #f5f5f5;
            margin-top: 20px; /* Adjust spacing */
            font-size: 24px; /* Size for section titles */
        }

        .section-title {
            font-size: 24px; /* Increased font size for section titles */
            text-align: center;
            margin-top: 40px; /* Space above section titles */
            color: #f5f5f5;
            margin-bottom: 20px; /* Add space below section titles */
        }
    </style>
</head>
<body>

<div class="content"> <!-- Main content inside the dark overlay -->
    <div class="menu">
        <a href="userdashboard.php">Home</a> <!-- Adjusted link to home -->
        <a href="all_products.php">Products</a>
        <a href="contact.php">Contact Us</a>
        <a href="about.php">About Us</a>
        <?php if (isset($_SESSION['customer_id'])): ?>
            <span class="welcome-message">Welcome, <?php echo htmlspecialchars($_SESSION['customer_name']); ?>!</span> <!-- Display the customer name -->
            <a href="../logout.php">Logout</a> <!-- Adjusted logout path -->
        <?php else: ?>
            <a href="../login.php">Login</a> <!-- Adjusted login path -->
        <?php endif; ?>
    </div>

    <!-- Added logo before the welcome message -->
    <img src="../images/logo.png" alt="Logo" class="logo"> 
    <h1 class="welcome-message">Welcome to Warriors Sports</h1> <!-- Welcome message -->
    <div class="tagline">We provide everything for sports</div> <!-- Tagline below welcome message -->

    <h1 class="section-title">Select a Product Category</h1>
    <div class="container">
        <?php if ($categories): ?>
            <?php foreach ($categories as $category): ?>
                <div class="box" onclick="window.location.href='products.php?category_id=<?php echo $category['CategoryID']; ?>'"> <!-- Adjusted vendors.php path -->
                    <img src="../images/<?php echo htmlspecialchars($category['ImageURL']); ?>" alt="<?php echo htmlspecialchars($category['CategoryName']); ?>"> 
                    <span><?php echo htmlspecialchars($category['CategoryName']); ?></span>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No categories found.</p>
        <?php endif; ?>
    </div>

    <h1 class="section-title">Select a Vendor</h1>
    <div class="container">
        <?php if ($vendors): ?>
            <?php foreach ($vendors as $vendor): ?>
                <div class="box" onclick="window.location.href='vendor_products.php?vendor_id=<?php echo $vendor['VendorID']; ?>'"> <!-- Redirect to products.php with vendor ID -->
                    <img src="../images/vendor<?php echo $vendor['VendorID']; ?>.png" alt="<?php echo htmlspecialchars($vendor['VendorName']); ?>"> 
                    <span><?php echo htmlspecialchars($vendor['VendorName']); ?></span>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No vendors found.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
