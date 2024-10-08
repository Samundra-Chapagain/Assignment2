-- Drop the existing DB, if it exists
DROP DATABASE IF EXISTS OnlineSales;

-- Create a new DB for storing Sales
CREATE DATABASE OnlineSales;

-- Switch to it
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
    Role ENUM('admin', 'user') DEFAULT 'user',
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
    ImageURL VARCHAR(255)
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

-- Insert records into the Customer table
INSERT INTO Customer (CustomerID, FirstName, LastName, Email, Password, Phone, Address, City, PostalCode, Country, Role) VALUES
(1, 'Admin', 'User', 'admin@gmail.com', '123', '0000000000', 'Admin Address', 'Admin City', '00000', 'Admin Country', 'admin'),
(21, 'Sujan', 'Doe', 'sujan@gmail.com', '123', '1234567890', '123 My Street', 'Strathfield', '10001', 'Australia', 'user'),
(22, 'Ravi', 'Patel', 'ravi.patel@gmail.com', '123', '3123456789', '25 Lakeview Blvd', 'Sydney', '10002', 'Australia', 'user'),
(23, 'Amara', 'Williams', 'amara.williams@gmail.com', '123', '4789654321', '54 River Road', 'Sydney', '10003', 'Australia', 'user'),
(24, 'Aiden', 'Johnson', 'aiden.johnson@gmail.com', '123', '9876541234', '12 High Street', 'Sydney', '10004', 'Australia', 'user'),
(25, 'Lara', 'Jones', 'lara.jones@gmail.com', '123', '1234569870', '789 Park Avenue', 'Perth', '60001', 'Australia', 'user'),
(26, 'Tom', 'Smith', 'tom.smith@gmail.com', '123', '4567893210', '456 Rose Street', 'Melbourne', '30001', 'Australia', 'user'),
(27, 'Sophie', 'Lee', 'sophie.lee@gmail.com', '123', '7896541230', '34 Orchid Lane', 'Brisbane', '40001', 'Australia', 'user'),
(28, 'Liam', 'Brown', 'liam.brown@gmail.com', '123', '7418529630', '12 Maple Street', 'Adelaide', '50001', 'Australia', 'user'),
(29, 'Charlotte', 'Davis', 'charlotte.davis@gmail.com', '123', '9638527410', '23 Aspen Drive', 'Darwin', '80001', 'Australia', 'user'),
(30, 'Olivia', 'Garcia', 'olivia.garcia@gmail.com', '123', '1478523690', '567 Pine Street', 'Canberra', '26001', 'Australia', 'user'),
(31, 'Raman', 'Smith', 'raman@gmail.com', '123', '9876543210', '456 Om Avenue', 'Auburn', '90001', 'Australia', 'user'),
(32, 'Michael', 'Clark', 'michael.clark@gmail.com', '123', '9871236540', '123 Palm Grove', 'Hobart', '70001', 'Australia', 'user'),
(33, 'Emily', 'Wilson', 'emily.wilson@gmail.com', '123', '4569871230', '12 Riverbank Road', 'Alice Springs', '87001', 'Australia', 'user'),
(34, 'Sophia', 'White', 'sophia.white@gmail.com', '123', '6547891230', '78 Ocean Drive', 'Gold Coast', '42101', 'Australia', 'user'),
(35, 'James', 'Hall', 'james.hall@gmail.com', '123', '3214567890', '10 Lagoon Street', 'Toowoomba', '43501', 'Australia', 'user'),
(36, 'Isabella', 'Young', 'isabella.young@gmail.com', '123', '8527419630', '23 Poppy Crescent', 'Cairns', '48701', 'Australia', 'user'),
(37, 'Noah', 'Allen', 'noah.allen@gmail.com', '123', '7413698520', '45 Cedar Way', 'Rockhampton', '47001', 'Australia', 'user'),
(38, 'Mia', 'Scott', 'mia.scott@gmail.com', '123', '3218521470', '78 Coral Street', 'Mackay', '47401', 'Australia', 'user'),
(39, 'Jacob', 'Walker', 'jacob.walker@gmail.com', '123', '6543217890', '12 Garden Street', 'Bundaberg', '46701', 'Australia', 'user');

-- Insert records into the Vendor table
INSERT INTO Vendor (VendorID, VendorName, ContactName, Phone, Email, Address, City, PostalCode, Country) VALUES 
(1, 'Speedy Footwear', 'John Runner', '123-456-7890', 'john.runner@speedyfootwear.com', '456 Sprint Avenue', 'San Francisco', '94103', 'USA'),
(2, 'Marathon Gear', 'Jane Sprint', '987-654-3210', 'jane.sprint@marathongear.com', '789 Endurance Street', 'Los Angeles', '90001', 'USA'),
(3, 'Power Fitness Supplies', 'Michael Johnson', '555-234-5678', 'm.johnson@powerfitness.com', '1234 Strength Lane', 'Chicago', '60601', 'USA'),
(4, 'FitPro Equipment', 'Eaast Davis', '111-222-3333', 'Eaasr.david@fitpro.com', '789 Muscle Blvd', 'New York', '10001', 'USA'),
(5, 'Adventure Gear Co.', 'Sarah Tailor', '444-555-6666', 'sarah.hiker@adventuregear.com', '654 Mountain Path', 'Miami', '33101', 'USA'),
(6, 'Trail Blazers', 'David Wiese', '777-888-9999', 'david.wiese@trailblazers.com', '321 Forest Avenue', 'Houston', '77001', 'USA'),
(7, 'Elite Sportswear', 'Laura Griffin', '111-987-6543', 'laura.griffin@elitesportswear.com', '123 Fitness Street', 'Austin', '73301', 'USA'),
(8, 'Peak Performance Apparel', 'Mark Thompson', '222-456-7890', 'mark.thompson@peakperformance.com', '567 Mountain Lane', 'Denver', '80201', 'USA'),
(9, 'FitNation Gear', 'Kevin Williams', '333-654-7891', 'kevin.williams@fitnationgear.com', '789 Strength Road', 'Boston', '02101', 'USA'),
(10, 'EnduroTech Equipment', 'Emma Davis', '444-321-9876', 'emma.davis@endurotech.com', '321 Marathon Blvd', 'Atlanta', '30301', 'USA'),
(11, 'FlexFit Sports', 'Nick Peters', '555-789-1234', 'nick.peters@flexfit.com', '456 Gym Ave', 'Seattle', '98101', 'USA'),
(12, 'Xtreme Outdoors', 'Alex Stone', '666-123-4567', 'alex.stone@xtremeoutdoors.com', '678 Adventure Trail', 'Dallas', '75201', 'USA'),
(13, 'Pro Gear Supplies', 'Olivia White', '777-987-6543', 'olivia.white@progear.com', '789 Power Avenue', 'Houston', '77001', 'USA'),
(14, 'Stride Fitness', 'Liam Black', '888-654-9876', 'liam.black@stridefitness.com', '321 Cardio Lane', 'Orlando', '32801', 'USA'),
(15, 'Summit Trekking Co.', 'Daniel Brown', '999-321-6547', 'daniel.brown@summittrekking.com', '567 Peak Path', 'Salt Lake City', '84101', 'USA');

-- Insert records into the Category table
INSERT INTO Category (CategoryID, CategoryName, Description, ImageURL) VALUES
(11, 'Running Shoes', 'Footwear designed for running and other athletic activities', '11.jpg'),
(22, 'Fitness Equipment', 'Tools and machines for physical training and exercise', '22.jpg'),
(33, 'Outdoor Gear', 'Equipment for outdoor sports and activities', '33.jpg');

-- Insert records into the Product table for Running Shoes
INSERT INTO Product (ProductID, ProductName, Description, Price, CategoryID, VendorID, StockQuantity, ImageURL) VALUES
(31, 'Nike Air Zoom Pegasus 38', 'Running shoes with responsive cushioning', 120.00, 11, 1, 50, '/images/nike_pegasus.jpg'),
(32, 'Adidas Ultraboost', 'Comfortable running shoes with excellent cushioning', 180.00, 11, 1, 30, '/images/adidas_ultraboost.jpg'),
(33, 'Under Armour HOVR Phantom', 'Lightweight running shoes with energy return', 150.00, 11, 2, 40, '/images/under_armour_hovr.jpg'),
(34, 'Nike Air Max', 'High-performance running shoes', 130.00, 11, 2, 50, '/images/nike_air_max.jpg'),
(35, 'Treadmill Pro-500', 'Multiple features for treadmilling', 800.00, 22, 4, 20, '/images/treadmill_pro500.jpg'),
(36, 'ProForm 505 CST Treadmill', 'Best for home workouts', 600.00, 22, 5, 25, '/images/proform_505_cst.jpg'),
(37, 'Fitness Gloves', 'Top notch gloves for weight lifters', 25.00, 22, 5, 75, '/images/fitness_gloves.jpg'),
(38, 'Resistance Bands Set', 'Provides versatility for strength training', 35.00, 22, 6, 50, '/images/resistance_bands.jpg'),
(39, 'Tent Explorer 3000', 'Best suited for extreme outdoor conditions', 150.00, 33, 3, 35, '/images/tent_explorer3000.jpg'),
(40, 'Hydration Backpack', 'Stay hydrated on your outdoor adventures', 40.00, 33, 6, 60, '/images/hydration_backpack.jpg'),
(41, 'Hiking Backpack', 'You don’t want to miss this for hiking', 90.00, 33, 6, 30, '/images/hiking_backpack.jpg'),
(42, 'Garmin GPS Watch', 'Smartwatch with built-in GPS and fitness tracking', 250.00, 33, 12, 20, '/images/garmin_gps_watch.jpg'),
(43, 'Yoga Mat Pro', 'Non-slip surface with extra padding', 50.00, 22, 9, 40, '/images/yoga_mat_pro.jpg'),
(44, 'Running Socks Pack', 'Breathable running socks, pack of 3', 20.00, 11, 10, 100, '/images/running_socks_pack.jpg'),
(45, 'Elliptical Machine', 'Low impact cardio machine', 700.00, 22, 11, 15, '/images/elliptical_machine.jpg'),
(46, 'Climbing Rope', 'Durable and strong rope for rock climbing', 75.00, 33, 12, 25, '/images/climbing_rope.jpg');

-- Insert records into the CustomerOrders table
INSERT INTO CustomerOrders (OrderID, CustomerID, TotalAmount, ShippingAddress, City, PostalCode, Country, Status, PaymentMethod, PaymentStatus) VALUES
(1111, 21, 150.00, '123 Elm Street', 'New York', '10001', 'USA', 'Shipped', 'Credit Card', 'Paid'),
(2222, 31, 85.00, '456 Oak Avenue', 'Los Angeles', '90001', 'USA', 'Pending', 'PayPal', 'Paid'),
(3333, 22, 250.00, '789 Park Lane', 'Sydney', '10003', 'Australia', 'Shipped', 'Credit Card', 'Paid'),
(4444, 23, 320.00, '54 River Street', 'Sydney', '10003', 'Australia', 'Delivered', 'PayPal', 'Paid'),
(5555, 24, 190.00, '12 King Street', 'Melbourne', '30001', 'Australia', 'Shipped', 'Credit Card', 'Paid');

-- Insert records into the OrderDetails table
INSERT INTO OrderDetails (OrderDetailsID, OrderID, ProductID, Quantity, UnitPrice, TotalPrice) VALUES
(1, 1111, 31, 1, 120.00, 120.00),
(2, 2222, 35, 2, 25.00, 50.00),
(3, 3333, 32, 2, 180.00, 360.00),
(4, 4444, 36, 1, 600.00, 600.00),
(5, 5555, 41, 1, 90.00, 90.00);

-- Insert records into the Inventory table
INSERT INTO Inventory (InventoryID, ProductID, StockQuantity, ReorderLevel) VALUES
(1, 31, 50, 10),
(2, 32, 30, 8),
(3, 35, 20, 5),
(4, 37, 75, 15),
(5, 38, 50, 10),
(6, 41, 30, 7),
(7, 44, 100, 20),
(8, 46, 25, 5);

COMMIT;
