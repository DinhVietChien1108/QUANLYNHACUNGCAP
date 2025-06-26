-- Create database
CREATE DATABASE IF NOT EXISTS supplier_management;
USE supplier_management;

-- Create suppliers table
CREATE TABLE IF NOT EXISTS suppliers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    email VARCHAR(255),
    address VARCHAR(255)
);

-- Create categories table
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

-- Create supplied_items table
CREATE TABLE IF NOT EXISTS supplied_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    supplier_id INT,
    price DECIMAL(10,2),
    description TEXT,
    category_id INT,
    FOREIGN KEY (supplier_id) REFERENCES suppliers(id) ON DELETE SET NULL,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- Create orders table
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    supplier_id INT,
    order_date DATE NOT NULL,
    value DECIMAL(10,2),
    description TEXT,
    FOREIGN KEY (supplier_id) REFERENCES suppliers(id) ON DELETE SET NULL
);

-- Create order_items table (junction table for orders and items)
CREATE TABLE IF NOT EXISTS order_items (
    order_id INT,
    item_id INT,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (order_id, item_id),
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (item_id) REFERENCES supplied_items(id) ON DELETE CASCADE
);

-- Create users table for authentication
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    email VARCHAR(100),
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample data
INSERT INTO users (username, password, full_name, email, role) VALUES
('admin', '$2y$10$YourNewPasswordHashHere', 'Administrator', 'admin@example.com', 'admin');
-- Note: password is 'admin123' hashed with bcrypt
-- Run create_admin.php to generate a correct password hash

INSERT INTO categories (name) VALUES
('Electronics'),
('Office Supplies'),
('Furniture'),
('IT Equipment'),
('Services');

INSERT INTO suppliers (name, phone, email, address) VALUES
('Tech Solutions Inc.', '0123456789', 'contact@techsolutions.com', '123 Tech Street, City'),
('Office Depot', '0987654321', 'sales@officedepot.com', '456 Office Avenue, Town'),
('Furniture World', '0123987456', 'info@furnitureworld.com', '789 Furniture Road, Village');

INSERT INTO supplied_items (name, supplier_id, price, description, category_id) VALUES
('Laptop Dell XPS 13', 1, 1200.00, 'High-performance laptop with 16GB RAM', 1),
('Office Chair', 3, 150.00, 'Ergonomic office chair with lumbar support', 3),
('Printer HP LaserJet', 1, 300.00, 'Color laser printer', 1),
('Paper A4 (500 sheets)', 2, 5.00, 'Standard A4 paper for printing', 2),
('IT Maintenance Service', 1, 500.00, 'Monthly IT maintenance service', 5);

INSERT INTO orders (supplier_id, order_date, value, description) VALUES
(1, '2023-01-15', 1500.00, 'Order for IT equipment'),
(2, '2023-02-20', 200.00, 'Office supplies order'),
(3, '2023-03-10', 750.00, 'Furniture for new office');

INSERT INTO order_items (order_id, item_id, quantity, price) VALUES
(1, 1, 1, 1200.00),
(1, 3, 1, 300.00),
(2, 4, 40, 5.00),
(3, 2, 5, 150.00);
