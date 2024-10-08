<?php
include '../database.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Initialize empty variables for order fields
$orderId = '';
$customerId = '';
$totalAmount = '';
$shippingAddress = '';
$city = '';
$postalCode = '';
$country = '';
$status = '';
$paymentMethod = '';
$paymentStatus = '';

// Handle form submission for add/edit/delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check which action is requested
    $action = $_POST['action'];

    // Add or Edit Order
    if ($action === 'save_order') {
        $orderId = $_POST['orderId'];
        $customerId = $_POST['customerId'];
        $totalAmount = $_POST['totalAmount'];
        $shippingAddress = $_POST['shippingAddress'];
        $city = $_POST['city'];
        $postalCode = $_POST['postalCode'];
        $country = $_POST['country'];
        $status = $_POST['status'];
        $paymentMethod = $_POST['paymentMethod'];
        $paymentStatus = $_POST['paymentStatus'];

        // If orderId is not empty, update the existing order
        if (!empty($orderId)) {
            $sql = "UPDATE CustomerOrders 
                    SET CustomerID='$customerId', TotalAmount='$totalAmount', ShippingAddress='$shippingAddress', 
                        City='$city', PostalCode='$postalCode', Country='$country', 
                        Status='$status', PaymentMethod='$paymentMethod', PaymentStatus='$paymentStatus'
                    WHERE OrderID=$orderId";
            execute_query($sql);
        } else {
            // Add a new order
            $sql = "INSERT INTO CustomerOrders (CustomerID, TotalAmount, ShippingAddress, City, PostalCode, Country, Status, PaymentMethod, PaymentStatus)
                    VALUES ('$customerId', '$totalAmount', '$shippingAddress', '$city', '$postalCode', '$country', '$status', '$paymentMethod', '$paymentStatus')";
            execute_query($sql);
        }
        // Clear form fields and refresh the page
        header("Location: orders.php");
        exit;
    }

    // Delete Order
    if ($action === 'delete_order') {
        $orderId = $_POST['orderId'];
        $sql = "DELETE FROM CustomerOrders WHERE OrderID=$orderId";
        execute_query($sql);
        // Clear form fields and refresh the page
        header("Location: orders.php");
        exit;
    }
}

// Fetch all orders to display in the table
$orders = select_rows("SELECT * FROM CustomerOrders");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Orders</title>
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
    <h1>Orders</h1>

    <!-- Add/Edit/Delete Order Form -->
    <form action="orders.php" method="POST" id="orderForm">
        <input type="hidden" name="action" id="action" value="save_order">
        <input type="hidden" name="orderId" id="orderId" value="<?= htmlspecialchars($orderId) ?>">
        
        <input type="number" name="customerId" id="customerId" placeholder="Customer ID" value="<?= htmlspecialchars($customerId) ?>" required>
        <input type="number" name="totalAmount" id="totalAmount" placeholder="Total Amount" step="0.01" value="<?= htmlspecialchars($totalAmount) ?>" required>
        <input type="text" name="shippingAddress" id="shippingAddress" placeholder="Shipping Address" value="<?= htmlspecialchars($shippingAddress) ?>" required>
        <input type="text" name="city" id="city" placeholder="City" value="<?= htmlspecialchars($city) ?>" required>
        <input type="text" name="postalCode" id="postalCode" placeholder="Postal Code" value="<?= htmlspecialchars($postalCode) ?>" required>
        <input type="text" name="country" id="country" placeholder="Country" value="<?= htmlspecialchars($country) ?>" required>
        <input type="text" name="status" id="status" placeholder="Order Status" value="<?= htmlspecialchars($status) ?>" required>
        <input type="text" name="paymentMethod" id="paymentMethod" placeholder="Payment Method" value="<?= htmlspecialchars($paymentMethod) ?>" required>
        <input type="text" name="paymentStatus" id="paymentStatus" placeholder="Payment Status" value="<?= htmlspecialchars($paymentStatus) ?>" required>
        
        <button type="submit" id="submitButton">Add Order</button>
    </form>

    <!-- Orders Table -->
    <table>
        <tr>
            <th>Order ID</th>
            <th>Customer ID</th>
            <th>Total Amount</th>
            <th>Shipping Address</th>
            <th>City</th>
            <th>Postal Code</th>
            <th>Country</th>
            <th>Status</th>
            <th>Payment Method</th>
            <th>Payment Status</th>
            <th>Actions</th>
        </tr>
        <?php if (!empty($orders)): ?>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= htmlspecialchars($order['OrderID']) ?></td>
                    <td><?= htmlspecialchars($order['CustomerID']) ?></td>
                    <td><?= htmlspecialchars($order['TotalAmount']) ?></td>
                    <td><?= htmlspecialchars($order['ShippingAddress']) ?></td>
                    <td><?= htmlspecialchars($order['City']) ?></td>
                    <td><?= htmlspecialchars($order['PostalCode']) ?></td>
                    <td><?= htmlspecialchars($order['Country']) ?></td>
                    <td><?= htmlspecialchars($order['Status']) ?></td>
                    <td><?= htmlspecialchars($order['PaymentMethod']) ?></td>
                    <td><?= htmlspecialchars($order['PaymentStatus']) ?></td>
                    <td>
                        <button onclick="editOrder('<?= $order['OrderID'] ?>', '<?= htmlspecialchars($order['CustomerID']) ?>', '<?= htmlspecialchars($order['TotalAmount']) ?>', '<?= htmlspecialchars($order['ShippingAddress']) ?>', '<?= htmlspecialchars($order['City']) ?>', '<?= htmlspecialchars($order['PostalCode']) ?>', '<?= htmlspecialchars($order['Country']) ?>', '<?= htmlspecialchars($order['Status']) ?>', '<?= htmlspecialchars($order['PaymentMethod']) ?>', '<?= htmlspecialchars($order['PaymentStatus']) ?>')">Edit</button>
                        <button onclick="deleteOrder('<?= $order['OrderID'] ?>')">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="11">No orders found</td></tr>
        <?php endif; ?>
    </table>
</div>

<script>
// JavaScript function to populate form for editing an order
function editOrder(orderId, customerId, totalAmount, shippingAddress, city, postalCode, country, status, paymentMethod, paymentStatus) {
    document.getElementById('orderId').value = orderId;
    document.getElementById('customerId').value = customerId;
    document.getElementById('totalAmount').value = totalAmount;
    document.getElementById('shippingAddress').value = shippingAddress;
    document.getElementById('city').value = city;
    document.getElementById('postalCode').value = postalCode;
    document.getElementById('country').value = country;
    document.getElementById('status').value = status;
    document.getElementById('paymentMethod').value = paymentMethod;
    document.getElementById('paymentStatus').value = paymentStatus;
    document.getElementById('submitButton').textContent = 'Update Order';
    document.getElementById('action').value = 'save_order';
}

// JavaScript function to handle delete action
function deleteOrder(orderId) {
    if (confirm(`Are you sure
