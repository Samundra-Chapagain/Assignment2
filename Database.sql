BEGIN;
create DATABASE OnlineSales;
use OnlineSales;

CREATE TABLE Customer (
    CustomerID INT AUTO_INCREMENT PRIMARY KEY,
    FirstName VARCHAR(100),
    LastName VARCHAR(100),
    Email VARCHAR(255) UNIQUE,
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
CREATE TABLE `Order` (
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

-- Insert records into the Vendor table
INSERT INTO Vendor (VendorName, ContactName, Phone, Email, Address, City, PostalCode, Country) VALUES
('Ace Sports', 'Tom Parker', '1231231234', 'contact@acesports.com', '111 First Avenue', 'Boston', '02101', 'USA'),
('ProGear', 'Linda Miller', '2342342345', 'sales@progear.com', '222 Second Street', 'Seattle', '98101', 'USA'),
('Elite Athletics', 'Kevin Wright', '3453453456', 'support@eliteathletics.com', '333 Third Road', 'Denver', '80201', 'USA'),
('Champion Gear', 'Sarah Green', '4564564567', 'info@championgear.com', '444 Fourth Blvd', 'Dallas', '75201', 'USA'),
('TopPerformance', 'James Carter', '5675675678', 'contact@topperformance.com', '555 Fifth Avenue', 'San Francisco', '94101', 'USA');

-- Insert records into the Category table
INSERT INTO Category (CategoryName, Description) VALUES
('Running Shoes', 'Footwear designed for running and other athletic activities'),
('Fitness Equipment', 'Tools and machines for physical training and exercise'),
('Outdoor Gear', 'Equipment for outdoor sports and activities'),
('Team Sports', 'Apparel and gear for team-based sports like soccer, basketball'),
('Accessories', 'Sport accessories like gloves, belts, etc.');

-- Insert records into the Product table
INSERT INTO Product (ProductName, Description, Price, CategoryID, VendorID, StockQuantity, ImageURL) VALUES
('Nike Air Zoom Pegasus 38', 'Running shoes with responsive cushioning', 120.00, 1, 1, 50, 'nike_pegasus.jpg'),
('Treadmill Pro-500', 'Advanced treadmill with multiple features', 800.00, 2, 2, 20, 'treadmill_pro500.jpg'),
('Tent Explorer 3000', 'Durable tent for extreme outdoor conditions', 150.00, 3, 3, 35, 'tent_explorer3000.jpg'),
('Adidas Basketball Jersey', 'Comfortable basketball jersey', 60.00, 4, 4, 100, 'adidas_jersey.jpg'),
('Fitness Gloves', 'High-quality gloves for weight training', 25.00, 5, 5, 75, 'fitness_gloves.jpg');

-- Insert records into the Order table
INSERT INTO `Order` (CustomerID, TotalAmount, ShippingAddress, City, PostalCode, Country, Status, PaymentMethod, PaymentStatus) VALUES
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

