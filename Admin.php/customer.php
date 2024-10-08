<?php
include '../database.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Initialize empty variables for customer fields
$customerId = '';
$firstName = '';
$lastName = '';
$email = '';
$phone = '';
$address = '';
$city = '';
$postalCode = '';
$country = '';

// Handle form submission for add/edit/delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    // Add or Edit Customer
    if ($action === 'save_customer') {
        $customerId = $_POST['customerId'];
        $firstName = $_POST['FirstName'];
        $lastName = $_POST['LastName'];
        $email = $_POST['Email'];
        $phone = $_POST['Phone'];
        $address = $_POST['Address'];
        $city = $_POST['City'];
        $postalCode = $_POST['PostalCode'];
        $country = $_POST['Country'];

        if (!empty($customerId)) {
            $sql = "UPDATE Customer SET FirstName='$firstName', LastName='$lastName', Email='$email', Phone='$phone', Address='$address', City='$city', PostalCode='$postalCode', Country='$country' WHERE CustomerID=$customerId";
            execute_query($sql);
        } else {
            $sql = "INSERT INTO Customer (FirstName, LastName, Email, Phone, Address, City, PostalCode, Country) VALUES ('$firstName', '$lastName', '$email', '$phone', '$address', '$city', '$postalCode', '$country')";
            execute_query($sql);
        }
        header("Location: customers.php");
        exit;
    }

    // Delete Customer
    if ($action === 'delete_customer') {
        $customerId = $_POST['customerId'];
        $sql = "DELETE FROM Customer WHERE CustomerID=$customerId";
        execute_query($sql);
        header("Location: customers.php");
        exit;
    }
}

$customers = get_customers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customers</title>
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
        input[type="text"], input[type="email"], input[type="number"] {
            padding: 5px;
            margin-right: 10px;
            margin-bottom: 10px;
            width: calc(20% - 12px);
        }
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
    <h1>Customers</h1>

    <!-- Add/Edit Customer Form -->
    <form action="customers.php" method="POST" id="customerForm">
        <input type="hidden" name="action" id="action" value="save_customer">
        <input type="hidden" name="customerId" id="customerId" value="<?= htmlspecialchars($customerId) ?>">
        <input type="text" name="FirstName" id="FirstName" placeholder="First Name" value="<?= htmlspecialchars($firstName) ?>" required>
        <input type="text" name="LastName" id="LastName" placeholder="Last Name" value="<?= htmlspecialchars($lastName) ?>" required>
        <input type="email" name="Email" id="Email" placeholder="Email" value="<?= htmlspecialchars($email) ?>" required>
        <input type="text" name="Phone" id="Phone" placeholder="Phone" value="<?= htmlspecialchars($phone) ?>" required>
        <input type="text" name="Address" id="Address" placeholder="Address" value="<?= htmlspecialchars($address) ?>" required>
        <input type="text" name="City" id="City" placeholder="City" value="<?= htmlspecialchars($city) ?>" required>
        <input type="text" name="PostalCode" id="PostalCode" placeholder="Postal Code" value="<?= htmlspecialchars($postalCode) ?>" required>
        <input type="text" name="Country" id="Country" placeholder="Country" value="<?= htmlspecialchars($country) ?>" required>
        <button type="submit" id="submitButton">Add Customer</button>
    </form>

    <!-- Customers Table -->
    <table>
        <tr>
            <th>Customer ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($customers as $customer): ?>
            <tr>
                <td><?= htmlspecialchars($customer['CustomerID']) ?></td>
                <td><?= htmlspecialchars($customer['FirstName']) ?></td>
                <td><?= htmlspecialchars($customer['LastName']) ?></td>
                <td><?= htmlspecialchars($customer['Email']) ?></td>
                <td><?= htmlspecialchars($customer['Phone']) ?></td>
                <td>
                    <button onclick="editCustomer('<?= $customer['CustomerID'] ?>', '<?= htmlspecialchars($customer['FirstName']) ?>', '<?= htmlspecialchars($customer['LastName']) ?>', '<?= htmlspecialchars($customer['Email']) ?>', '<?= htmlspecialchars($customer['Phone']) ?>', '<?= htmlspecialchars($customer['Address']) ?>', '<?= htmlspecialchars($customer['City']) ?>', '<?= htmlspecialchars($customer['PostalCode']) ?>', '<?= htmlspecialchars($customer['Country']) ?>')">Edit</button>
                    <button onclick="deleteCustomer('<?= $customer['CustomerID'] ?>', '<?= htmlspecialchars($customer['FirstName']) ?>')">Delete</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<script>
// JavaScript function to populate form for editing a customer
function editCustomer(customerId, firstName, lastName, email, phone, address, city, postalCode, country) {
    document.getElementById('customerId').value = customerId;
    document.getElementById('FirstName').value = firstName;
    document.getElementById('LastName').value = lastName;
    document.getElementById('Email').value = email;
    document.getElementById('Phone').value = phone;
    document.getElementById('Address').value = address;
    document.getElementById('City').value = city;
    document.getElementById('PostalCode').value = postalCode;
    document.getElementById('Country').value = country;
    document.getElementById('submitButton').textContent = 'Update Customer';
    document.getElementById('action').value = 'save_customer';
}

// JavaScript function to handle delete action
function deleteCustomer(customerId, firstName) {
    if (confirm(`Are you sure you want to delete the customer "${firstName}"?`)) {
        document.getElementById('customerId').value = customerId;
        document.getElementById('FirstName').value = '';
        document.getElementById('LastName').value = '';
        document.getElementById('Email').value = '';
        document.getElementById('Phone').value = '';
        document.getElementById('Address').value = '';
        document.getElementById('City').value = '';
        document.getElementById('PostalCode').value = '';
        document.getElementById('Country').value = '';
        document.getElementById('submitButton').textContent = 'Delete Customer';
        document.getElementById('action').value = 'delete_customer';
        document.getElementById('customerForm').submit();
    }
}
</script>

</body>
</html>
