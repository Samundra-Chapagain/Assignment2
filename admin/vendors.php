<?php
include '../database.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Initialize empty variables for vendor fields
$vendorId = '';
$vendorName = '';
$contactName = '';
$phone = '';
$email = '';
$address = '';
$city = '';
$postalCode = '';
$country = '';

// Handle form submission for add/edit/delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    // Add or Edit Vendor
    if ($action === 'save_vendor') {
        $vendorId = $_POST['vendorId'];
        $vendorName = $_POST['VendorName'];
        $contactName = $_POST['ContactName'];
        $phone = $_POST['Phone'];
        $email = $_POST['Email'];
        $address = $_POST['Address'];
        $city = $_POST['City'];
        $postalCode = $_POST['PostalCode'];
        $country = $_POST['Country'];

        if (!empty($vendorId)) {
            $sql = "UPDATE Vendor SET VendorName='$vendorName', ContactName='$contactName', Phone='$phone', Email='$email', Address='$address', City='$city', PostalCode='$postalCode', Country='$country' WHERE VendorID=$vendorId";
            execute_query($sql);
        } else {
            $sql = "INSERT INTO Vendor (VendorName, ContactName, Phone, Email, Address, City, PostalCode, Country) VALUES ('$vendorName', '$contactName', '$phone', '$email', '$address', '$city', '$postalCode', '$country')";
            execute_query($sql);
        }
        header("Location: vendors.php");
        exit;
    }

    // Delete Vendor
    if ($action === 'delete_vendor') {
        $vendorId = $_POST['vendorId'];
        $sql = "DELETE FROM Vendor WHERE VendorID=$vendorId";
        execute_query($sql);
        header("Location: vendors.php");
        exit;
    }
}

$vendors = get_vendors();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vendors</title>
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
    <h1>Vendors</h1>

    <!-- Add/Edit Vendor Form -->
    <form action="vendors.php" method="POST" id="vendorForm">
        <input type="hidden" name="action" id="action" value="save_vendor">
        <input type="hidden" name="vendorId" id="vendorId" value="<?= htmlspecialchars($vendorId) ?>">
        <input type="text" name="VendorName" id="VendorName" placeholder="Vendor Name" value="<?= htmlspecialchars($vendorName) ?>" required>
        <input type="text" name="ContactName" id="ContactName" placeholder="Contact Name" value="<?= htmlspecialchars($contactName) ?>" required>
        <input type="text" name="Phone" id="Phone" placeholder="Phone" value="<?= htmlspecialchars($phone) ?>" required>
        <input type="email" name="Email" id="Email" placeholder="Email" value="<?= htmlspecialchars($email) ?>" required>
        <input type="text" name="Address" id="Address" placeholder="Address" value="<?= htmlspecialchars($address) ?>" required>
        <input type="text" name="City" id="City" placeholder="City" value="<?= htmlspecialchars($city) ?>" required>
        <input type="text" name="PostalCode" id="PostalCode" placeholder="Postal Code" value="<?= htmlspecialchars($postalCode) ?>" required>
        <input type="text" name="Country" id="Country" placeholder="Country" value="<?= htmlspecialchars($country) ?>" required>
        <button type="submit" id="submitButton">Add Vendor</button>
    </form>

    <!-- Vendors Table -->
    <table>
        <tr>
            <th>VendorID</th>
            <th>Vendor Name</th>
            <th>Contact Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($vendors as $vendor): ?>
            <tr>
                <td><?= $vendor['VendorID'] ?></td>
                <td><?= $vendor['VendorName'] ?></td>
                <td><?= $vendor['ContactName'] ?></td>
                <td><?= $vendor['Phone'] ?></td>
                <td><?= $vendor['Email'] ?></td>
                <td>
                    <button onclick="editVendor('<?= $vendor['VendorID'] ?>', '<?= htmlspecialchars($vendor['VendorName']) ?>', '<?= htmlspecialchars($vendor['ContactName']) ?>', '<?= htmlspecialchars($vendor['Phone']) ?>', '<?= htmlspecialchars($vendor['Email']) ?>', '<?= htmlspecialchars($vendor['Address']) ?>', '<?= htmlspecialchars($vendor['City']) ?>', '<?= htmlspecialchars($vendor['PostalCode']) ?>', '<?= htmlspecialchars($vendor['Country']) ?>')">Edit</button>
                    <button onclick="deleteVendor('<?= $vendor['VendorID'] ?>', '<?= htmlspecialchars($vendor['VendorName']) ?>')">Delete</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<script>
// JavaScript function to populate form for editing a vendor
function editVendor(vendorId, vendorName, contactName, phone, email, address, city, postalCode, country) {
    document.getElementById('vendorId').value = vendorId;
    document.getElementById('VendorName').value = vendorName;
    document.getElementById('ContactName').value = contactName;
    document.getElementById('Phone').value = phone;
    document.getElementById('Email').value = email;
    document.getElementById('Address').value = address;
    document.getElementById('City').value = city;
    document.getElementById('PostalCode').value = postalCode;
    document.getElementById('Country').value = country;
    document.getElementById('submitButton').textContent = 'Update Vendor';
    document.getElementById('action').value = 'save_vendor';
}

// JavaScript function to handle delete action
function deleteVendor(vendorId, vendorName) {
    if (confirm(`Are you sure you want to delete the vendor "${vendorName}"?`)) {
        document.getElementById('vendorId').value = vendorId;
        document.getElementById('VendorName').value = '';
        document.getElementById('ContactName').value = '';
        document.getElementById('Phone').value = '';
        document.getElementById('Email').value = '';
        document.getElementById('Address').value = '';
        document.getElementById('City').value = '';
        document.getElementById('PostalCode').value = '';
        document.getElementById('Country').value = '';
        document.getElementById('submitButton').textContent = 'Delete Vendor';
        document.getElementById('action').value = 'delete_vendor';
        document.getElementById('vendorForm').submit();
    }
}
</script>

</body>
</html>
