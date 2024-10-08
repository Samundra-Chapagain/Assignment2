<?php
include '../database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    switch ($action) {
        // Vendor Actions
        case 'add_vendor':
            $VendorName = $_POST['VendorName'];
            $ContactName = $_POST['ContactName'];
            $Phone = $_POST['Phone'];
            $Email = $_POST['Email'];
            $Address = $_POST['Address'];
            $City = $_POST['City'];
            $PostalCode = $_POST['PostalCode'];
            $Country = $_POST['Country'];
            add_vendor($VendorName, $ContactName, $Phone, $Email, $Address, $City, $PostalCode, $Country);
            break;

        case 'update_vendor':
            $VendorID = $_POST['VendorID'];
            $VendorName = $_POST['VendorName'];
            $ContactName = $_POST['ContactName'];
            $Phone = $_POST['Phone'];
            $Email = $_POST['Email'];
            $Address = $_POST['Address'];
            $City = $_POST['City'];
            $PostalCode = $_POST['PostalCode'];
            $Country = $_POST['Country'];
            update_vendor($VendorID, $VendorName, $ContactName, $Phone, $Email, $Address, $City, $PostalCode, $Country);
            break;

        case 'delete_vendor':
            $VendorID = $_POST['VendorID'];
            delete_vendor($VendorID);
            break;

        // Customer Actions
        case 'add_customer':
            $FirstName = $_POST['FirstName'];
            $LastName = $_POST['LastName'];
            $Email = $_POST['Email'];
            $Phone = $_POST['Phone'];
            $Address = $_POST['Address'];
            $City = $_POST['City'];
            $PostalCode = $_POST['PostalCode'];
            $Country = $_POST['Country'];
            add_customer($FirstName, $LastName, $Phone, $Email, $Address, $City, $PostalCode, $Country);
            break;

        case 'update_customer':
            $CustomerID = $_POST['CustomerID'];
            $FirstName = $_POST['FirstName'];
            $LastName = $_POST['LastName'];
            $Email = $_POST['Email'];
            $Phone = $_POST['Phone'];
            $Address = $_POST['Address'];
            $City = $_POST['City'];
            $PostalCode = $_POST['PostalCode'];
            $Country = $_POST['Country'];
            update_customer($CustomerID, $FirstName, $LastName, $Phone, $Email, $Address, $City, $PostalCode, $Country);
            break;

        case 'delete_customer':
            $CustomerID = $_POST['CustomerID'];
            delete_customer($CustomerID);
            break;

        // Product Actions
        case 'add_product':
            $ProductName = $_POST['ProductName'];
            $VendorID = $_POST['VendorID'];
            $Price = $_POST['Price'];
            $Stock = $_POST['Stock'];
            $Description = $_POST['Description'];
            add_product($ProductName, $VendorID, $Price, $Stock, $Description);
            break;

        case 'update_product':
            $ProductID = $_POST['ProductID'];
            $ProductName = $_POST['ProductName'];
            $VendorID = $_POST['VendorID'];
            $Price = $_POST['Price'];
            $Stock = $_POST['Stock'];
            $Description = $_POST['Description'];
            update_product($ProductID, $ProductName, $VendorID, $Price, $Stock, $Description);
            break;

        case 'delete_product':
            $ProductID = $_POST['ProductID'];
            delete_product($ProductID);
            break;
    }

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}
?>
