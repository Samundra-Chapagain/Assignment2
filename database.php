<?php
$hostname = 'localhost';
$username = 'root';
$password = ''; // Make sure this matches your MySQL root password
$dbname = 'OnlineSales';
;

// Open the database connection
function open_connection() {
    global $hostname, $username, $password, $dbname, $conn;
    
    // Create connection
    $conn = new mysqli($hostname, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }
}

// Close the database connection
function close_connection() {
    global $conn;
    if (isset($conn)) {
        $conn->close();
    }
}

// Select rows from the database based on the SQL query
function select_rows($sql) {
    global $conn;
    open_connection();
    $rows = array();

    // Try executing the query
    try {
        $result = $conn->query($sql);
        if ($result === false) {
            throw new Exception("Database Query Failed: " . $conn->error);
        }

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($rows, $row);
            }
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }

    close_connection();
    return $rows;
}

// Execute an SQL query (INSERT, UPDATE, DELETE)
function execute_query($sql) {
    global $conn;
    open_connection();
    
    // Try executing the query
    try {
        if ($conn->query($sql) === false) {
            throw new Exception("Database Query Failed: " . $conn->error);
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }

    close_connection();
}

// Fetch all vendors
function get_vendors() {
    $sql = "SELECT VendorID, VendorName, ContactName, Phone, Email, Address, City, PostalCode, Country, CreatedDate FROM Vendor";
    return select_rows($sql);
}

// Add a new vendor
function add_vendor($VendorName, $ContactName, $Phone, $Email, $Address, $City, $PostalCode, $Country) {
    $sql = "INSERT INTO Vendor (VendorName, ContactName, Phone, Email, Address, City, PostalCode, Country) 
            VALUES ('$VendorName', '$ContactName', '$Phone', '$Email', '$Address', '$City', '$PostalCode', '$Country')";
    execute_query($sql);
}

// Update an existing vendor
function update_vendor($VendorID, $VendorName, $ContactName, $Phone, $Email, $Address, $City, $PostalCode, $Country) {
    $sql = "UPDATE Vendor SET VendorName='$VendorName', ContactName='$ContactName', Phone='$Phone', Email='$Email', 
            Address='$Address', City='$City', PostalCode='$PostalCode', Country='$Country' WHERE VendorID = $VendorID";
    execute_query($sql);
}

// Delete a vendor
function delete_vendor($VendorID) {
    $sql = "DELETE FROM Vendor WHERE VendorID = $VendorID";
    execute_query($sql);
}

// Fetch all customers
function get_customers() {
    $sql = "SELECT CustomerID, FirstName, LastName, Email, Phone, Address, City, PostalCode, Country, CreatedDate FROM Customer";
    return select_rows($sql);
}

// Add a new customer
function add_customer($FirstName, $LastName, $Email, $Phone, $Address, $City, $PostalCode, $Country) {
    $sql = "INSERT INTO Customer (FirstName, LastName, Email, Phone, Address, City, PostalCode, Country) 
            VALUES ('$FirstName', '$LastName', '$Email', '$Phone', '$Address', '$City', '$PostalCode', '$Country')";
    execute_query($sql);
}

// Update an existing customer
function update_customer($CustomerID, $FirstName, $LastName, $Email, $Phone, $Address, $City, $PostalCode, $Country) {
    $sql = "UPDATE Customer SET FirstName='$FirstName', LastName='$LastName', Email='$Email', Phone='$Phone', 
            Address='$Address', City='$City', PostalCode='$PostalCode', Country='$Country' WHERE CustomerID = $CustomerID";
    execute_query($sql);
}

// Delete a customer
function delete_customer($CustomerID) {
    $sql = "DELETE FROM Customer WHERE CustomerID = $CustomerID";
    execute_query($sql);
}

// Fetch all products
function get_all_products() {
    $sql = "SELECT ProductID, ProductName, Price, StockQuantity AS Stock, Description FROM Product";
    return select_rows($sql);
}

// Fetch products by vendor
function get_products_by_vendor($VendorID) {
    $sql = "SELECT * FROM Product WHERE VendorID = " . intval($VendorID);
    return select_rows($sql);
}

// Add a new product
function add_product($ProductName, $VendorID, $Price, $Stock, $Description) {
    $sql = "INSERT INTO Product (ProductName, VendorID, Price, Stock, Description) 
            VALUES ('$ProductName', $VendorID, $Price, $Stock, '$Description')";
    execute_query($sql);
}

// Update an existing product
function update_product($ProductID, $ProductName, $VendorID, $Price, $Stock, $Description) {
    $sql = "UPDATE Product SET ProductName='$ProductName', VendorID=$VendorID, Price=$Price, Stock=$Stock, 
            Description='$Description' WHERE ProductID = $ProductID";
    execute_query($sql);
}

// Delete a product
function delete_product($ProductID) {
    $sql = "DELETE FROM Product WHERE ProductID = $ProductID";
    execute_query($sql);
}

// Fetch inventory based on inventory ID
function get_inventory($InventoryID) {
    $sql = "SELECT * FROM Inventory WHERE InventoryID = " . intval($InventoryID);
    return select_rows($sql);
}

// Fetch product categories by vendor
function get_productCategories($VendorID) {
    $sql = "SELECT * FROM Product WHERE VendorID = " . intval($VendorID);
    return select_rows($sql);
}

// Fetch order details by vendor
function get_orderdetails($VendorID) {
    $sql = "SELECT * FROM OrderDetails WHERE VendorID = " . intval($VendorID);
    return select_rows($sql);
}

// Fetch orders by vendor
function get_order($VendorID) {
    $sql = "SELECT * FROM CustomerOrders WHERE VendorID = " . intval($VendorID);
    return select_rows($sql);
}

// Fetch customers by vendor
function get_customer($VendorID) {
    $sql = "SELECT * FROM Customer WHERE VendorID = " . intval($VendorID);
    return select_rows($sql);
}

?>
