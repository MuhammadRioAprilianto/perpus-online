-- ============================================================
-- PesanInAja - Online Food Ordering System
-- Complete Database Schema
-- ============================================================

CREATE DATABASE IF NOT EXISTS pesaninaja_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE pesaninaja_db;

-- ------------------------------------------------------------
-- Users table
-- Stores both customer and admin accounts
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) DEFAULT NULL,
    address TEXT DEFAULT NULL,
    role ENUM('admin', 'customer') DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- User addresses table
-- Stores multiple saved delivery addresses per user
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS user_addresses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    label VARCHAR(50) NOT NULL,
    recipient_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) DEFAULT NULL,
    full_address TEXT NOT NULL,
    is_main TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Categories table
-- Organizes menu items into logical groups
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    slug VARCHAR(60) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Menus table
-- Food and beverage items available for ordering
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS menus (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT DEFAULT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT DEFAULT NULL,
    price DECIMAL(12, 2) NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    is_available TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Cart items table
-- Persistent shopping cart for logged-in users
-- Uses UNIQUE constraint to prevent duplicate entries
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS cart_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    menu_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (menu_id) REFERENCES menus(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_menu (user_id, menu_id)
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Orders table
-- Master order record with payment and status tracking
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    order_number VARCHAR(20) NOT NULL UNIQUE,
    total_amount DECIMAL(12, 2) NOT NULL,
    tax_amount DECIMAL(12, 2) DEFAULT 0.00,
    grand_total DECIMAL(12, 2) NOT NULL,
    status ENUM('pending', 'confirmed', 'cooking', 'ready', 'delivered', 'cancelled') DEFAULT 'pending',
    payment_proof VARCHAR(255) DEFAULT NULL,
    payment_status ENUM('unpaid', 'uploaded', 'verified', 'rejected') DEFAULT 'unpaid',
    notes TEXT DEFAULT NULL,
    customer_name VARCHAR(100) NOT NULL,
    customer_phone VARCHAR(20) DEFAULT NULL,
    customer_address TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Order items table
-- Snapshots menu details at the time of order placement
-- Preserves pricing integrity even if menu changes later
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    menu_id INT DEFAULT NULL,
    menu_name VARCHAR(100) NOT NULL,
    menu_price DECIMAL(12, 2) NOT NULL,
    quantity INT NOT NULL,
    subtotal DECIMAL(12, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (menu_id) REFERENCES menus(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Ratings table
-- Customer reviews and star ratings for delivered orders
-- Unique constraint prevents duplicate ratings per item per order
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS ratings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    menu_id INT NOT NULL,
    user_id INT NOT NULL,
    rating TINYINT NOT NULL,
    review TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (menu_id) REFERENCES menus(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_order_menu_rating (order_id, menu_id, user_id)
) ENGINE=InnoDB;

-- ============================================================
-- SEED DATA
-- ============================================================

-- Default admin account (password: admin123)
INSERT INTO users (username, email, password, full_name, role) VALUES
('admin', 'admin@pesaninaja.com', '$2y$10$PLz56OOlXU2hHuidMW.O8OiRpbRcMTGqGOeGM6l5YF6qaTQ.nrxLW', 'Administrator', 'admin');

-- Default customer account (password: customer123)
INSERT INTO users (username, email, password, full_name, phone, address, role) VALUES
('customer', 'customer@pesaninaja.com', '$2y$10$ookBkj3gBFHUGHjMuSmrJ.ZQry5jqYDWNJbrtbqCFCGuF3rKRWK6y', 'John Customer', '081234567890', 'Jl. Contoh No. 123, Jakarta', 'customer');

-- Seed categories
INSERT INTO categories (name, slug) VALUES
('Makanan', 'makanan'),
('Minuman', 'minuman'),
('Cemilan', 'cemilan'),
('Dessert', 'dessert');

-- Seed menu items
INSERT INTO menus (category_id, name, description, price, is_available) VALUES
(1, 'Nasi Goreng Spesial', 'Nasi goreng dengan telur, ayam, dan sayuran segar. Disajikan dengan kerupuk dan acar.', 25000.00, 1),
(1, 'Mie Goreng Jawa', 'Mie goreng khas Jawa dengan bumbu rahasia dan taburan bawang goreng.', 22000.00, 1),
(1, 'Ayam Bakar Madu', 'Ayam bakar dengan olesan madu pilihan, disajikan dengan nasi dan lalapan.', 35000.00, 1),
(1, 'Soto Ayam Lamongan', 'Soto ayam khas Lamongan dengan kuah kuning yang gurih dan segar.', 20000.00, 1),
(1, 'Rendang Sapi', 'Rendang sapi Padang yang empuk dan kaya rempah, disajikan dengan nasi putih.', 40000.00, 1),
(1, 'Gado-Gado Jakarta', 'Sayuran segar dengan bumbu kacang khas Jakarta dan kerupuk.', 18000.00, 1),
(2, 'Es Teh Manis', 'Teh manis dingin yang menyegarkan dengan es batu.', 5000.00, 1),
(2, 'Jus Alpukat', 'Jus alpukat segar dengan susu cokelat dan es krim.', 15000.00, 1),
(2, 'Kopi Susu Gula Aren', 'Kopi robusta pilihan dengan susu segar dan gula aren asli.', 18000.00, 1),
(2, 'Es Jeruk Segar', 'Perasan jeruk segar dengan madu dan es batu.', 10000.00, 1),
(3, 'Pisang Goreng Keju', 'Pisang goreng crispy dengan taburan keju dan susu kental manis.', 15000.00, 1),
(3, 'Tahu Crispy', 'Tahu goreng crispy dengan bumbu pedas manis.', 12000.00, 1),
(3, 'Kentang Goreng', 'Kentang goreng renyah dengan saus sambal dan mayonnaise.', 16000.00, 1),
(4, 'Es Krim Vanilla', 'Es krim vanilla premium dengan topping cokelat.', 12000.00, 1),
(4, 'Puding Cokelat', 'Puding cokelat lembut dengan vla vanilla.', 10000.00, 1),
(4, 'Brownies Panggang', 'Brownies cokelat panggang yang lembut dan fudgy.', 20000.00, 1);
