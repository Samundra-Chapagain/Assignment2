<?php
include_once 'database.php';

// Check if category ID is set
if (!isset($_GET['category_id'])) {
    die("Category ID not provided.");
}

$categoryId = intval($_GET['category_id']); // Get category ID from the URL

// Fetch vendors based on the category ID
function get_vendors_by_category($categoryId) {
    open_connection();
    $sql = "SELECT v.VendorID, v.VendorName, v.ContactName, v.Phone, v.Email, v.Address, v.City, v.PostalCode, v.Country
            FROM Vendor v
            INNER JOIN Product p ON v.VendorID = p.VendorID
            WHERE p.CategoryID = ?";
    
    // Prepare and execute the statement to prevent SQL injection
    $stmt = $GLOBALS['conn']->prepare($sql);
    $stmt->bind_param("i", $categoryId);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    close_connection();
    return $rows;
}

$vendors = get_vendors_by_category($categoryId);
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
            flex-wrap: wrap;
            justify-content: center;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
        }
        .vendor-box {
            flex: 0 0 200px; /* Set width of each box */
            margin: 10px;
            padding: 15px;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s;
        }
        .vendor-box:hover {
            transform: scale(1.05); /* Slight zoom effect on hover */
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
    <h1>Vendors in Selected Category</h1>

    <?php if (count($vendors) > 0): ?>
       <?php foreach ($vendors as $vendor): ?>
    <div class="vendor-card" onclick="window.location.href='products.php?vendor_id=<?php echo $vendor['VendorID']; ?>'">
        <h2><?php echo htmlspecialchars($vendor['VendorName']); ?></h2>
        <p>Contact Name: <?php echo htmlspecialchars($vendor['ContactName']); ?></p>
        <p>Phone: <?php echo htmlspecialchars($vendor['Phone']); ?></p>
        <p>Email: <?php echo htmlspecialchars($vendor['Email']); ?></p>
        <p>Address: <?php echo htmlspecialchars($vendor['Address']) . ', ' . htmlspecialchars($vendor['City']) . ', ' . htmlspecialchars($vendor['PostalCode']) . ', ' . htmlspecialchars($vendor['Country']); ?></p>
    </div>
<?php endforeach; ?>

    <?php else: ?>
        <p>No vendors found for this category.</p>
    <?php endif; ?>
</div>

</body>
</html>
