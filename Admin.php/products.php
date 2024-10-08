<?php
include '../database.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Initialize empty variables for product fields
$productId = '';
$productName = '';
$price = '';
$stockQuantity = '';
$description = '';

// Handle form submission for add/edit/delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check which action is requested
    $action = $_POST['action'];

    // Add or Edit Product
    if ($action === 'save_product') {
        $productId = $_POST['productId'];
        $productName = $_POST['productName'];
        $price = $_POST['price'];
        $stockQuantity = isset($_POST['stockQuantity']) && is_numeric($_POST['stockQuantity']) ? intval($_POST['stockQuantity']) : 0;
        $description = $_POST['description'];

        // If productId is not empty, update the existing product
        if (!empty($productId)) {
            $sql = "UPDATE Product SET ProductName='$productName', Price='$price', StockQuantity='$stockQuantity', Description='$description' WHERE ProductID=$productId";
            execute_query($sql);
        } else {
            // Add a new product
            $sql = "INSERT INTO Product (ProductName, Price, StockQuantity, Description) VALUES ('$productName', '$price', '$stockQuantity', '$description')";
            execute_query($sql);
        }
        // Clear form fields and refresh the page
        header("Location: products.php");
        exit;
    }

    // Delete Product
    if ($action === 'delete_product') {
        $productId = $_POST['productId'];
        $sql = "DELETE FROM Product WHERE ProductID=$productId";
        execute_query($sql);
        // Clear form fields and refresh the page
        header("Location: products.php");
        exit;
    }
}

// Fetch all products to display in the table
$products = get_all_products();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Products</title>
    <style>
        body { font-family: Arial, sans-serif; }
        nav { background-color: #007BFF; padding: 10px; text-align: center; }
        nav a { color: white; margin-right: 20px; text-decoration: none; font-size: 16px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 10px; text-align: center; }
        form { margin-bottom: 20px; }
        .container { width: 80%; margin: 0 auto; }
        button { padding: 5px 10px; }
        h1 { margin-top: 20px; }
        input[type="text"], input[type="number"], textarea {
            padding: 5px;
            margin-right: 10px;
            margin-bottom: 10px;
            width: calc(20% - 12px);
        }
        textarea { width: calc(60% - 12px); vertical-align: top; }
    </style>
</head>
<body>

<!-- Navbar -->
<nav>
    <a href="index.php">Home</a>
    <a href="customers.php">Customers</a>
    <a href="orders.php">Orders</a>
    <a href="products.php">Products</a>
    <a href="vendors.php">Vendors</a>
    <?php if (isset($_SESSION['customer_id'])): ?>
        <a href="?logout=true" class="logout-btn">Logout</a> <!-- Logout button -->
    <?php else: ?>
        <a href="../login.php">Logout</a>
    <?php endif; ?>
</nav>

<div class="container">
    <h1>Products</h1>

    <!-- Add/Edit/Delete Product Form -->
    <form action="products.php" method="POST" id="productForm">
        <input type="hidden" name="action" id="action" value="save_product">
        <input type="hidden" name="productId" id="productId" value="<?= htmlspecialchars($productId) ?>">
        <input type="text" name="productName" id="productName" placeholder="Product Name" value="<?= htmlspecialchars($productName) ?>" required>
        <input type="number" name="price" id="price" placeholder="Price" step="0.01" value="<?= htmlspecialchars($price) ?>" required>
        <input type="number" name="stockQuantity" id="stockQuantity" placeholder="Stock Quantity" value="<?= htmlspecialchars($stockQuantity) ?>" required>
        <textarea name="description" id="description" placeholder="Description" rows="3" required><?= htmlspecialchars($description) ?></textarea>
        <button type="submit" id="submitButton">Add Product</button>
    </form>

    <!-- Products Table -->
    <table>
        <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Stock Quantity</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= htmlspecialchars($product['ProductID']) ?></td>
                    <td><?= htmlspecialchars($product['ProductName']) ?></td>
                    <td><?= htmlspecialchars($product['Price']) ?></td>
                    <td><?= htmlspecialchars($product['Stock']) ?></td>
                    <td><?= htmlspecialchars($product['Description']) ?></td>
                    <td>
                        <button onclick="editProduct('<?= $product['ProductID'] ?>', '<?= htmlspecialchars($product['ProductName']) ?>', '<?= htmlspecialchars($product['Price']) ?>', '<?= htmlspecialchars($product['Stock']) ?>', '<?= htmlspecialchars($product['Description']) ?>')">Edit</button>
                        <button onclick="deleteProduct('<?= $product['ProductID'] ?>', '<?= htmlspecialchars($product['ProductName']) ?>')">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="6">No products found</td></tr>
        <?php endif; ?>
    </table>
</div>

<script>
// JavaScript function to populate form for editing a product
function editProduct(productId, productName, price, stockQuantity, description) {
    document.getElementById('productId').value = productId;
    document.getElementById('productName').value = productName;
    document.getElementById('price').value = price;
    document.getElementById('stockQuantity').value = stockQuantity;
    document.getElementById('description').value = description;
    document.getElementById('submitButton').textContent = 'Update Product';
    document.getElementById('action').value = 'save_product';
}

// JavaScript function to handle delete action
function deleteProduct(productId, productName) {
    if (confirm(`Are you sure you want to delete the product "${productName}"?`)) {
        document.getElementById('productId').value = productId;
        document.getElementById('productName').value = '';
        document.getElementById('price').value = '';
        document.getElementById('stockQuantity').value = '';
        document.getElementById('description').value = '';
        document.getElementById('submitButton').textContent = 'Delete Product';
        document.getElementById('action').value = 'delete_product';
        document.getElementById('productForm').submit();
    }
}
</script>

</body>
</html>
