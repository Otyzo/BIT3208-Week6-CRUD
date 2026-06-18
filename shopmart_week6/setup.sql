-- ShopMart Database Setup Script
-- Run this in phpMyAdmin SQL tab or MySQL CLI

CREATE DATABASE IF NOT EXISTS shopmart;
USE shopmart;

-- Products Table
CREATE TABLE IF NOT EXISTS products (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(150)   NOT NULL,
    description TEXT,
    price       DECIMAL(10,2)  NOT NULL,
    stock_qty   INT            DEFAULT 0 CHECK (stock_qty >= 0),
    category    VARCHAR(100),
    created_at  TIMESTAMP      DEFAULT CURRENT_TIMESTAMP
);

-- Sample Data
INSERT INTO products (name, description, price, stock_qty, category) VALUES
('Wireless Headphones',  'Noise-cancelling Bluetooth headphones', 3500.00, 20, 'Electronics'),
('Running Shoes',        'Lightweight breathable running shoes',  2800.00, 15, 'Footwear'),
('Leather Wallet',       'Slim genuine leather bifold wallet',     950.00, 30, 'Accessories'),
('Stainless Water Bottle','1L insulated stainless steel bottle',   750.00, 50, 'Kitchenware'),
('Desk Lamp',            'LED desk lamp with adjustable brightness',1200.00,10, 'Home & Office');
