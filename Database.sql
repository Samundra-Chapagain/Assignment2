CREATE DATABASE db_sportwebsite;

USE db_sportwebsite;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL
);

INSERT INTO users (username, password, email) VALUES
('user1', 'pass123', 'user1@example.com'),
('user2', 'pass123', 'user2@example.com'),
('user3', 'pass123', 'user3@example.com'),
('user4', 'pass123', 'user4@example.com'),
('user5', 'pass123', 'user5@example.com'),
('user6', 'pass123', 'user6@example.com');

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);

INSERT INTO categories (name) VALUES
('Football'),
('Basketball'),
('Tennis'),
('Running'),
('Cycling'),
('Swimming');

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    category_id INT,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

INSERT INTO products (name, description, price, category_id) VALUES
('Football', 'A high-quality football for practice and games.', 25.99, 1),
('Basketball', 'Official size and weight basketball.', 29.99, 2),
('Tennis Racket', 'Lightweight racket for all skill levels.', 35.50, 3),
('Running Shoes', 'Comfortable shoes for running.', 50.00, 4),
('Cycling Helmet', 'Safety helmet for cyclists.', 20.00, 5),
('Swimming Goggles', 'Anti-fog swimming goggles.', 15.99, 6);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    total DECIMAL(10, 2) NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);
