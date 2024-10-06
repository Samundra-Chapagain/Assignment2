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
    Description TEXT
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
INSERT INTO Customer (CustomerID, FirstName, LastName, Email, Password, Phone, Address, City, PostalCode, Country) VALUES
(21, 'Sujan', 'Doe', 'sujan.doe@example.com', 'password123', '1234567890', '123 My Street', 'Strathfield', '10001', 'Australia'),
(31, 'Raman', 'Smith', 'raman.smith@example.com', 'password456', '9876543210', '456 Om Avenue', 'Auburn', '90001', 'Australia');

-- Insert records into the Vendor table
INSERT INTO Vendor (VendorID, VendorName, ContactName, Phone, Email, Address, City, PostalCode, Country) VALUES 
(1, 'Speedy Footwear', 'John Runner', '123-456-7890', 'john.runner@speedyfootwear.com', '456 Sprint Avenue', 'San Francisco', '94103', 'USA'),
(2, 'Marathon Gear', 'Jane Sprint', '987-654-3210', 'jane.sprint@marathongear.com', '789 Endurance Street', 'Los Angeles', '90001', 'USA'),
(3, 'Power Fitness Supplies', 'Michael Johnson', '555-234-5678', 'm.johnson@powerfitness.com', '1234 Strength Lane', 'Chicago', '60601', 'USA'),
(4, 'FitPro Equipment', 'Emily Davis', '111-222-3333', 'emily.davis@fitpro.com', '789 Muscle Blvd', 'New York', '10001', 'USA'),
(5, 'Adventure Gear Co.', 'Sarah Hiker', '444-555-6666', 'sarah.hiker@adventuregear.com', '654 Mountain Path', 'Miami', '33101', 'USA'),
(6, 'Trail Blazers', 'David White', '777-888-9999', 'david.white@trailblazers.com', '321 Forest Avenue', 'Houston', '77001', 'USA');

-- Insert records into the Category table
INSERT INTO Category (CategoryID, CategoryName, Description) VALUES
(11, 'Running Shoes', 'Footwear designed for running and other athletic activities'),
(22, 'Fitness Equipment', 'Tools and machines for physical training and exercise'),
(33, 'Outdoor Gear', 'Equipment for outdoor sports and activities');

-- Insert records into the Product table for Running Shoes
-- 3 Vendors (1, 2, 3) will be associated with Running Shoes, 4 Products each
INSERT INTO Product (ProductID, ProductName, Description, Price, CategoryID, VendorID, StockQuantity, ImageURL) VALUES
(31, 'Nike Air Zoom Pegasus 38', 'Running shoes with responsive cushioning', 120.00, 11, 1, 50, 'images/nike_pegasus.jpg'),
(32, 'Adidas Ultraboost', 'Comfortable running shoes with excellent cushioning', 180.00, 11, 1, 30, 'images/adidas_ultraboost.jpg'),
(33, 'Under Armour HOVR Phantom', 'Lightweight running shoes with energy return', 150.00, 11, 2, 40, 'images/under_armour_hovr.jpg'),
(34, 'Nike Air Max', 'High-performance running shoes', 130.00, 11, 2, 50, 'images/nike_air_max.jpg');

-- Insert records into the Product table for Fitness Equipment
-- 3 Vendors (4, 5, 6) will be associated with Fitness Equipment, 4 Products each
INSERT INTO Product (ProductID, ProductName, Description, Price, CategoryID, VendorID, StockQuantity, ImageURL) VALUES
(35, 'Treadmill Pro-500', 'Advanced treadmill with multiple features', 800.00, 22, 4, 20, 'images/treadmill_pro500.jpg'),
(36, 'ProForm 505 CST Treadmill', 'Compact treadmill for home workouts', 600.00, 22, 5, 25, 'images/proform_505_cst.jpg'),
(37, 'Fitness Gloves', 'High-quality gloves for weight training', 25.00, 22, 5, 75, 'images/fitness_gloves.jpg'),
(38, 'Resistance Bands Set', 'Versatile bands for strength training', 35.00, 22, 6, 50, 'images/resistance_bands.jpg');

-- Insert records into the Product table for Outdoor Gear
-- 3 Vendors (1, 3, 6) will be associated with Outdoor Gear, 4 Products each
INSERT INTO Product (ProductID, ProductName, Description, Price, CategoryID, VendorID, StockQuantity, ImageURL) VALUES
(39, 'Tent Explorer 3000', 'Durable tent for extreme outdoor conditions', 150.00, 33, 3, 35, 'images/tent_explorer3000.jpg'),
(40, 'Hydration Backpack', 'Stay hydrated on your outdoor adventures', 40.00, 33, 6, 60, 'images/hydration_backpack.jpg'),
(41, 'Hiking Backpack', 'Spacious backpack for hiking trips', 90.00, 33, 6, 30, 'images/hiking_backpack.jpg');

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
