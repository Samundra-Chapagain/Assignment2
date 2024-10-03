<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "OnlineSales";
$conn = null;

function open_connection() {
    global $servername, $username, $password, $dbname, $conn;
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
}

function close_connection() {
    global $conn;
    if (isset($conn)) {
        $conn->close();
    }
}

function select_rows($sql) {
    global $conn;
    $rows = array();
    
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($rows, $row);
        }
    }
    return $rows;
}

// Fetch all vendors
function get_vendors() {
    open_connection();
    $sql = "SELECT VendorID, VendorName, ContactName, Phone, Email, Address, City, PostalCode, Country, CreatedDate FROM Vendor";
    $rows = select_rows($sql);
    close_connection();
    return $rows; 
}

// Fetch products by vendor
function get_products_by_vendor($VendorID) {
    open_connection();
    $sql = "SELECT * FROM Product WHERE VendorID = " . intval($VendorID) . ";"; // Ensure VendorID is an integer
    $rows = select_rows($sql);
    close_connection();
    return $rows; 
}

// Sample function for inventory (you may want to adjust the query)
function get_inventory($InventoryID) {
    open_connection();
    $sql = "SELECT * FROM Inventory WHERE InventoryID = " . intval($InventoryID) . ";"; // Adjust based on your table structure
    $rows = select_rows($sql);
    close_connection();
    return $rows; 
}

// Adjust these functions based on the correct table and field names
function get_productCategories($VendorID) {
    open_connection();
    $sql = "SELECT * FROM Product WHERE VendorID = " . intval($VendorID) . ";"; // Adjust as needed
    $rows = select_rows($sql);
    close_connection();
    return $rows; 
}

function get_orderdetails($VendorID) {
    open_connection();
    $sql = "SELECT * FROM OrderDetails WHERE VendorID = " . intval($VendorID) . ";"; // Adjust as needed
    $rows = select_rows($sql);
    close_connection();
    return $rows; 
}

function get_order($VendorID) {
    open_connection();
    $sql = "SELECT * FROM Orders WHERE VendorID = " . intval($VendorID) . ";"; // Adjust as needed
    $rows = select_rows($sql);
    close_connection();
    return $rows; 
}

function get_customer($VendorID) {
    open_connection();
    $sql = "SELECT * FROM Customers WHERE VendorID = " . intval($VendorID) . ";"; // Adjust as needed
    $rows = select_rows($sql);
    close_connection();
    return $rows; 
}
?>
