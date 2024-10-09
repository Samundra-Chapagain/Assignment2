BEGIN;
CREATE DATABASE IF NOT EXISTS OnlineSales;
USE OnlineSales;

-- Create Customer Table
CREATE TABLE Customer (
    CustomerID INT PRIMARY KEY,
    FirstName VARCHAR(100),
    LastName VARCHAR(100),
    Email VARCHAR(191) UNIQUE,
    Password VARCHAR(255),
    Phone VARCHAR(20),
    Address VARCHAR(255),
    City VARCHAR(100),
    PostalCode VARCHAR(20),
    Country VARCHAR(100),
    Role ENUM('admin', 'user') DEFAULT 'user', -- Added role to differentiate between admin and users
    CreatedDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create Vendor Table
CREATE TABLE Vendor (
    VendorID INT PRIMARY KEY,
    VendorName VARCHAR(100),
    ContactName VARCHAR(100),
    Phone VARCHAR(20),
    Email VARCHAR(255),
    Address VARCHAR(255),
    City VARCHAR(100),
    PostalCode VARCHAR(20),
    Country VARCHAR(100),
    CreatedDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create Category Table
CREATE TABLE Category (
    CategoryID INT PRIMARY KEY,
    CategoryName VARCHAR(100),
    Description TEXT,
    ImageURL VARCHAR(255) -- Fixed: Added missing comma
);

-- Create Product Table
CREATE TABLE Product (
    ProductID INT PRIMARY KEY,
    ProductName VARCHAR(255),
    Description TEXT,
    Price DECIMAL(10, 2),
    CategoryID INT,
    VendorID INT,
    StockQuantity INT,
    CreatedDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ImageURL VARCHAR(255),
    FOREIGN KEY (CategoryID) REFERENCES Category(CategoryID),
    FOREIGN KEY (VendorID) REFERENCES Vendor(VendorID)
);

-- Create Order Table
CREATE TABLE CustomerOrders (
    OrderID INT PRIMARY KEY,
    CustomerID INT,
    OrderDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    TotalAmount DECIMAL(10, 2),
    ShippingAddress VARCHAR(255),
    City VARCHAR(100),
    PostalCode VARCHAR(20),
    Country VARCHAR(100),
    Status VARCHAR(50),
    PaymentMethod VARCHAR(50),
    PaymentStatus VARCHAR(50),
    FOREIGN KEY (CustomerID) REFERENCES Customer(CustomerID)
);

-- Create OrderDetails Table
CREATE TABLE OrderDetails (
    OrderDetailsID INT PRIMARY KEY,
    OrderID INT,
    ProductID INT,
    Quantity INT,
    UnitPrice DECIMAL(10, 2),
    TotalPrice DECIMAL(10, 2),
    FOREIGN KEY (OrderID) REFERENCES CustomerOrders(OrderID),
    FOREIGN KEY (ProductID) REFERENCES Product(ProductID)
);

-- Create Inventory Table
CREATE TABLE Inventory (
    InventoryID INT PRIMARY KEY,
    ProductID INT,
    StockQuantity INT,
    ReorderLevel INT,
    LastUpdated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (ProductID) REFERENCES Product(ProductID)
);

-- Loading Data Rows

-- Insert records into the Customer table
-- Note: Passwords should be hashed using password_hash() in PHP before inserting
INSERT INTO Customer (CustomerID, FirstName, LastName, Email, Password, Phone, Address, City, PostalCode, Country, Role) VALUES
(1, 'Admin', 'User', 'admin@gmail.com', '123', '0000000000', 'Admin Address', 'Admin City', '00000', 'Admin Country', 'admin'), 
(21, 'Sujan', 'Doe', 'sujan@gmail.com', '123', '1234567890', '123 My Street', 'Strathfield', '10001', 'Australia', 'user'),
(31, 'Raman', 'Smith', 'raman@gmail.com', '123', '9876543210', '456 Om Avenue', 'Auburn', '90001', 'Australia', 'user'),
(41, 'Samundra', 'Baral', 'samundra@gmail.com', '123', '9876544210', '54 George Street', 'Auburn', '90001', 'Australia', 'user');


-- Insert records into the Vendor table
INSERT INTO Vendor (VendorID, VendorName, ContactName, Phone, Email, Address, City, PostalCode, Country) VALUES 
(1, 'Speedy Footwear', 'John Runner', '123-456-7890', 'john.runner@speedyfootwear.com', '456 Sprint Avenue', 'San Francisco', '94103', 'USA'),
(2, 'Marathon Gear', 'Jane Sprint', '987-654-3210', 'jane.sprint@marathongear.com', '789 Endurance Street', 'Los Angeles', '90001', 'USA'),
(3, 'Power Fitness Supplies', 'Michael Johnson', '555-234-5678', 'm.johnson@powerfitness.com', '1234 Strength Lane', 'Chicago', '60601', 'USA'),
(4, 'FitPro Equipment', 'Eaast Davis', '111-222-3333', 'Eaasr.david@fitpro.com', '789 Muscle Blvd', 'New York', '10001', 'USA'),
(5, 'Adventure Gear Co.', 'Sarah Tailor', '444-555-6666', 'sarah.hiker@adventuregear.com', '654 Mountain Path', 'Miami', '33101', 'USA'),
(6, 'Trail Blazers', 'David Wiese', '777-888-9999', 'david.wiese@trailblazers.com', '321 Forest Avenue', 'Houston', '77001', 'USA');

-- Insert records into the Category table
INSERT INTO Category (CategoryID, CategoryName, Description, ImageURL) VALUES
(11, 'Running Shoes', 'Footwear designed for running and other athletic activities', '11.jpg'),
(22, 'Fitness Equipment', 'Tools and machines for physical training and exercise', '22.jpg'),
(33, 'Outdoor Gear', 'Equipment for outdoor sports and activities', '33.jpg');

-- Insert records into the Product table for Running Shoes
INSERT INTO Product (ProductID, ProductName, Description, Price, CategoryID, VendorID, StockQuantity, ImageURL) VALUES
(31, 'Nike Air Zoom Pegasus 38', 'Running shoes with responsive cushioning', 120.00, 11, 1, 50, '2222.jpg'),
(32, 'Adidas Ultraboost', 'Comfortable running shoes with excellent cushioning', 180.00, 11, 1, 30, '2221.jpg'),
(33, 'Under Armour HOVR Phantom', 'Lightweight running shoes with energy return', 150.00, 11, 2, 40, '2223.jpg'),
(34, 'Nike Air Max', 'High-performance running shoes', 130.00, 11, 2, 50, '2224');

-- Insert records into the Product table for Fitness Equipment
INSERT INTO Product (ProductID, ProductName, Description, Price, CategoryID, VendorID, StockQuantity, ImageURL) VALUES
(35, 'Treadmill Pro-500', 'Multiple features for treadmilling', 800.00, 22, 4, 20, '3332.jpg'),
(36, 'ProForm 505 CST Treadmill', 'Best for home workouts', 600.00, 22, 5, 25, '3333.jpg'),
(37, 'Fitness Gloves', 'Top notch gloves for weight lifters', 25.00, 22, 5, 75, '4444.jpg'),
(38, 'Resistance Bands Set', 'Provides versatility for strength training', 35.00, 22, 6, 50, '6666.jpg');

-- Insert records into the Product table for Outdoor Gear
INSERT INTO Product (ProductID, ProductName, Description, Price, CategoryID, VendorID, StockQuantity, ImageURL) VALUES
(39, 'Tent Explorer 3000', 'Best suited for extreme outdoor conditions', 150.00, 33, 3, 35, '7777.jpg'),
(40, 'Hydration Backpack', 'Stay hydrated on your outdoor adventures', 40.00, 33, 6, 60, '5551.jpg'),
(41, 'Hiking Backpack', 'You don’t want to miss this for hiking', 90.00, 33, 6, 30, '5555.jpg');

-- Insert records into the CustomerOrders table
INSERT INTO CustomerOrders (OrderID, CustomerID, TotalAmount, ShippingAddress, City, PostalCode, Country, Status, PaymentMethod, PaymentStatus) VALUES
(1111, 21, 150.00, '123 Elm Street', 'New York', '10001', 'USA', 'Shipped', 'Credit Card', 'Paid'),
(2222, 31, 85.00, '456 Oak Avenue', 'Los Angeles', '90001', 'USA', 'Pending', 'PayPal', 'Paid');

-- Insert records into the OrderDetails table
INSERT INTO OrderDetails (OrderDetailsID, OrderID, ProductID, Quantity, UnitPrice, TotalPrice) VALUES
(1, 1111, 31, 1, 120.00, 120.00),
(2, 2222, 35, 2, 25.00, 50.00);

-- Insert records into the Inventory table
INSERT INTO Inventory (InventoryID, ProductID, StockQuantity, ReorderLevel) VALUES
(1, 31, 50, 10),
(2, 32, 30, 8),
(3, 35, 20, 5);

COMMIT;
