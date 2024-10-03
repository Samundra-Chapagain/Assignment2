/* Introduction to SQL 					*/
/* Script file for MySQL DBMS			*/
/* This script file creates the following tables:	*/
/* tblVendor, tblProduct, tblCustomer, tblInvoice, tblLine		*/
/* and loads the default data rows			*/

BEGIN;
create DATABASE if not exists OnlineSales;
use OnlineSales;

CREATE TABLE Customer (
    CustomerID INT AUTO_INCREMENT PRIMARY KEY,
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
    VendorID INT AUTO_INCREMENT PRIMARY KEY,
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
    CategoryID INT AUTO_INCREMENT PRIMARY KEY,
    CategoryName VARCHAR(100),
    Description TEXT
);

-- Create Product Table
CREATE TABLE Product (
    ProductID INT AUTO_INCREMENT PRIMARY KEY,
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
    OrderID INT AUTO_INCREMENT PRIMARY KEY,
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
    OrderDetailsID INT AUTO_INCREMENT PRIMARY KEY,
    OrderID INT,
    ProductID INT,
    Quantity INT,
    UnitPrice DECIMAL(10, 2),
    TotalPrice DECIMAL(10, 2),
    FOREIGN KEY (OrderID) REFERENCES `Order`(OrderID),
    FOREIGN KEY (ProductID) REFERENCES Product(ProductID)
);

-- Create Inventory Table
CREATE TABLE Inventory (
    InventoryID INT AUTO_INCREMENT PRIMARY KEY,
    ProductID INT,
    StockQuantity INT,
    ReorderLevel INT,
    LastUpdated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (ProductID) REFERENCES Product(ProductID)
);


/* Loading data rows	*/			
				
-- Insert records into the Customer table
INSERT INTO Customer (FirstName, LastName, Email, Password, Phone, Address, City, PostalCode, Country) VALUES
('John', 'Doe', 'john.doe@example.com', 'password123', '1234567890', '123 Elm Street', 'New York', '10001', 'USA'),
('Jane', 'Smith', 'jane.smith@example.com', 'password456', '9876543210', '456 Oak Avenue', 'Los Angeles', '90001', 'USA'),
('Michael', 'Brown', 'michael.brown@example.com', 'password789', '5555555555', '789 Pine Road', 'Chicago', '60601', 'USA'),
('Emily', 'Davis', 'emily.davis@example.com', 'password111', '4444444444', '321 Birch Lane', 'Houston', '77001', 'USA'),
('David', 'Wilson', 'david.wilson@example.com', 'password222', '3333333333', '654 Cedar Court', 'Miami', '33101', 'USA');

INSERT INTO Vendor (VendorID, VendorName, ContactName, Phone, Email, Address, City, PostalCode, Country) VALUES 
(1, 'Speedy Footwear', 'John Runner', '123-456-7890', 'john.runner@speedyfootwear.com', '456 Sprint Avenue', 'San Francisco', '94103', 'USA'),
(2, 'Marathon Gear', 'Jane Sprint', '987-654-3210', 'jane.sprint@marathongear.com', '789 Endurance Street', 'Los Angeles', '90001', 'USA'),
(3, 'Power Fitness Supplies', 'Michael Johnson', '555-234-5678', 'm.johnson@powerfitness.com', '1234 Strength Lane', 'Chicago', '60601', 'USA'),
(4, 'FitPro Equipment', 'Emily Davis', '111-222-3333', 'emily.davis@fitpro.com', '789 Muscle Blvd', 'New York', '10001', 'USA'),
(5, 'Adventure Gear Co.', 'Sarah Hiker', '444-555-6666', 'sarah.hiker@adventuregear.com', '654 Mountain Path', 'Miami', '33101', 'USA'),
(6, 'Trail Blazers', 'David White', '777-888-9999', 'david.white@trailblazers.com', '321 Forest Avenue', 'Houston', '77001', 'USA'),
(7, 'Summit Outdoor', 'Paul Green', '555-666-7777', 'paul.green@summitoutdoor.com', '123 Peak Road', 'Denver', '80202', 'USA'),
(8, 'Team Sports Gear', 'Linda Black', '888-999-0000', 'linda.black@teamsportsgear.com', '456 Champion Street', 'Seattle', '98101', 'USA'),
(9, 'Pro Sports Equipment', 'Jessica Harris', '999-111-2222', 'jessica.harris@prosports.com', '789 Victory Plaza', 'Las Vegas', '89101', 'USA'),
(10, 'AllStar Sports Supplies', 'Chris Moore', '111-333-5555', 'chris.moore@allstarsports.com', '321 Stadium Lane', 'Dallas', '75201', 'USA');


-- Insert records into the Category table
INSERT INTO Category (CategoryID, CategoryName, Description) VALUES
(11, 'Running Shoes', 'Footwear designed for running and other athletic activities'),
(22, 'Fitness Equipment', 'Tools and machines for physical training and exercise'),
(33, 'Outdoor Gear', 'Equipment for outdoor sports and activities'),
(44, 'Team Sports', 'Apparel and gear for team-based sports like soccer, basketball');

-- Insert records into the Product table
INSERT INTO Product (ProductName, Description, Price, CategoryID, VendorID, StockQuantity, ImageURL) VALUES
('Nike Air Zoom Pegasus 38', 'Running shoes with responsive cushioning', 120.00, 11, 1, 50, 'images/nike_pegasus.jpg'),
('Treadmill Pro-500', 'Advanced treadmill with multiple features', 800.00, 22, 2, 20, 'images/treadmill_pro500.jpg'),
('Tent Explorer 3000', 'Durable tent for extreme outdoor conditions', 150.00, 33, 3, 35, 'images/tent_explorer3000.jpg'),
('Adidas Basketball Jersey', 'Comfortable basketball jersey', 60.00, 44, 8, 100, 'images/adidas_jersey.jpg'),
('Nike Air Max', 'High-performance running shoes', 130.00, 11, 2, 50, 'images/nike_air_max.jpg'),
('Adidas Ultraboost', 'Comfortable running shoes with excellent cushioning', 180.00, 11, 2, 30, 'images/adidas_ultraboost.jpg'),
('Fitness Gloves', 'High-quality gloves for weight training', 25.00, 22, 3, 75, 'images/fitness_gloves.jpg'),
('Under Armour HOVR Phantom', 'Lightweight running shoes with energy return', 150.00, 11, 1, 40, 'images/under_armour_hovr.jpg'),
('ProForm 505 CST Treadmill', 'Compact treadmill for home workouts', 600.00, 22, 2, 25, 'images/proform_505_cst.jpg'),
('Hydration Backpack', 'Stay hydrated on your outdoor adventures', 40.00, 33, 5, 60, 'images/hydration_backpack.jpg'),
('Soccer Cleats', 'Durable cleats for optimal performance on the field', 70.00, 11, 8, 80, 'images/soccer_cleats.jpg'),
('Resistance Bands Set', 'Versatile bands for strength training', 35.00, 22, 3, 50, 'images/resistance_bands.jpg'),
('Hiking Backpack', 'Spacious backpack for hiking trips', 90.00, 33, 6, 30, 'images/hiking_backpack.jpg');



-- Insert records into the Order table
INSERT INTO CustomerOrders (CustomerID, TotalAmount, ShippingAddress, City, PostalCode, Country, Status, PaymentMethod, PaymentStatus) VALUES
(1, 150.00, '123 Elm Street', 'New York', '10001', 'USA', 'Shipped', 'Credit Card', 'Paid'),
(2, 85.00, '456 Oak Avenue', 'Los Angeles', '90001', 'USA', 'Pending', 'PayPal', 'Paid'),
(3, 275.00, '789 Pine Road', 'Chicago', '60601', 'USA', 'Delivered', 'Credit Card', 'Paid'),
(4, 50.00, '321 Birch Lane', 'Houston', '77001', 'USA', 'Shipped', 'Credit Card', 'Pending'),
(5, 200.00, '654 Cedar Court', 'Miami', '33101', 'USA', 'Cancelled', 'Credit Card', 'Refunded');

-- Insert records into the OrderDetails table
INSERT INTO OrderDetails (OrderID, ProductID, Quantity, UnitPrice, TotalPrice) VALUES
(1, 1, 1, 120.00, 120.00),
(2, 5, 2, 25.00, 50.00),
(3, 2, 1, 800.00, 800.00),
(4, 4, 1, 60.00, 60.00),
(5, 3, 2, 150.00, 300.00);

-- Insert records into the Inventory table
INSERT INTO Inventory (ProductID, StockQuantity, ReorderLevel) VALUES
(1, 50, 10),
(2, 20, 5),
(3, 35, 10),
(4, 100, 20),
(5, 75, 15);

