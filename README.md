# 🍽️ PesanInAja — Online Food Ordering System

PesanInAja is a full-featured web-based food ordering platform built with a strict **MVC architecture** using native PHP. It provides a seamless experience for customers to browse menus, manage their cart, place orders, and track delivery status — while giving restaurant administrators a powerful dashboard to manage operations, verify payments, and fulfill orders.

---

## ⚙️ Tech Stack

| Layer        | Technology                          |
|--------------|-------------------------------------|
| **Back-end** | Native PHP (no framework), PDO      |
| **Front-end**| Tailwind CSS (CDN), Vanilla JS      |
| **Database** | MySQL 8.x                           |
| **Architecture** | Strict MVC (Model-View-Controller) |
| **Server**   | Apache (Laragon / cPanel / XAMPP)    |

---

## ✨ Key Features

### Customer Features
- **Menu Catalog** — Browse food & drink items with category filtering and keyword search.
- **Shopping Cart** — Add items, adjust quantities (+/-), and remove items with real-time subtotals.
- **Checkout** — Review order, enter delivery information, and place order with automatic tax calculation (PPN 11%).
- **Payment Proof Upload** — Upload transfer receipt images (JPG/PNG/WebP, max 5MB) for admin verification.
- **Order Tracking** — View order history with real-time status timeline (Pending → Confirmed → Cooking → Ready → Delivered).
- **Food Rating** — Submit 1-5 star ratings and text reviews for items in delivered orders.

### Admin Features
- **Dashboard** — Overview statistics: total orders, revenue, pending orders, today's activity, customer count.
- **Menu Management** — Full CRUD (Create, Read, Update, Delete) for menu items with image upload and availability toggle.
- **Category Management** — Create and delete menu categories.
- **Order Management** — View all orders with status filtering, update fulfillment status, and manage the order pipeline.
- **Payment Verification** — Review uploaded payment proofs and approve or reject them.

### Security
- CSRF token protection on all forms.
- Passwords hashed with `password_hash()` / `password_verify()` (bcrypt).
- All database queries use PDO prepared statements (SQL injection prevention).
- User input sanitized via `htmlspecialchars()` (XSS prevention).
- File uploads validated by MIME type, size, and extension.
- Role-based access control with admin guards.

---

## 📁 Directory Structure (Folders Only)

```
pesaninaja/
├── app/                        # 🔒 Protected application code (not web-accessible)
│   ├── config/                 #    Database connection and application constants
│   ├── controllers/            #    Request handlers (Auth, Menu, Cart, Checkout, Order, Admin, Rating)
│   ├── helpers/                #    Utility functions (CSRF, sanitize, upload, redirect, etc.)
│   ├── models/                 #    Data access layer (User, Menu, Cart, Order, OrderItem, Rating)
│   └── views/                  #    Presentation layer
│       ├── admin/              #    Admin dashboard, menu CRUD, and order management views
│       ├── auth/               #    Login and registration forms
│       ├── cart/               #    Shopping cart page
│       ├── checkout/           #    Checkout and order confirmation
│       ├── components/         #    Reusable UI components (icons, alerts, menu cards)
│       ├── layouts/            #    Base layouts (main customer layout, admin sidebar layout)
│       ├── menu/               #    Public menu catalog
│       └── orders/             #    Customer order history and detail
│
├── public/                     # 🌐 Web-accessible root (Apache document root)
│   ├── css/                    #    Stylesheets and SVG assets
│   ├── js/                     #    Client-side JavaScript
│   └── uploads/                #    User-uploaded files
│       ├── menus/              #    Menu item images
│       └── payments/           #    Payment proof images
│
├── .htaccess                   #    Root URL rewriting (routes requests to public/)
├── database.sql                #    Full database schema and seed data
└── README.md
```

> **Why two folders?** The `app/` folder contains sensitive code (database credentials, business logic) that must never be directly accessible via URL. The `public/` folder is the only directory exposed to the web. See [Security Architecture](#security) for details.

---

## 📋 Prerequisites

Before running PesanInAja, ensure you have the following installed:

- **PHP** >= 8.1
- **MySQL** >= 8.0
- **Apache** with `mod_rewrite` enabled (or Laragon/XAMPP which includes this)
- **PHP Extensions:**
  - `pdo_mysql` — Database connectivity
  - `fileinfo` — MIME type detection for uploads
  - `mbstring` — Multi-byte string support

To verify your PHP extensions:
```bash
php -m | grep -E "pdo_mysql|fileinfo|mbstring"
```

---

## 🚀 Local Development Guide

### Step 1: Clone or Download the Project

Place the project in your web server's document root:

```bash
# Laragon
cd D:\software\laragon\www

# XAMPP
cd C:\xampp\htdocs

# Then clone
git clone <repository-url> pesaninaja
cd pesaninaja
```

### Step 2: Create and Import the Database

Using the command line:
```bash
mysql -u root -e "SOURCE database.sql"
```

Or import `database.sql` via phpMyAdmin:
1. Open phpMyAdmin (`http://localhost/phpmyadmin`)
2. Click **Import** → Choose `database.sql` → Click **Go**

This creates the `pesaninaja_db` database with all tables and seed data.

### Step 3: Configure Database Credentials

Edit `app/config/database.php` if your MySQL credentials differ from the defaults:

```php
private static string $host     = 'localhost';
private static string $dbName   = 'pesaninaja_db';
private static string $username = 'root';
private static string $password = '';  // Update if your MySQL has a password
```

### Step 4: Ensure Upload Directories Are Writable

```bash
# Linux/macOS
chmod -R 755 public/uploads/

# Windows (Laragon/XAMPP) — no action needed, writable by default.
```

### Step 5: Start the Development Server

**Option A — Using PHP Built-in Server (recommended for quick testing):**

```bash
php -S localhost:8000 -t public
```

Then open `http://localhost:8000` in your browser.

> **Note:** When using the PHP built-in server, the root `.htaccess` is not used. The `-t public` flag sets `public/` as the document root directly, which is the correct behavior.

**Option B — Using Laragon:**

Start Laragon and visit `http://pesaninaja.test/`

**Option C — Using XAMPP:**

Start Apache and visit `http://localhost/pesaninaja/`

### Step 6: Login with Seed Accounts

| Role     | Username   | Password       |
|----------|------------|----------------|
| Admin    | `admin`    | `admin123`     |
| Customer | `customer` | `customer123`  |

---

## 🌐 cPanel Deployment Guide (Shared Hosting)

Deploying an MVC application to cPanel shared hosting requires separating the `public/` contents (which go into `public_html`) from the `app/` code (which stays outside the web root for security).

### Step 1: Upload Files via File Manager or FTP

Upload the project to your home directory with this structure:

```
/home/yourusername/
├── pesaninaja_app/             # ← Upload app/ folder contents here
│   ├── config/
│   ├── controllers/
│   ├── helpers/
│   ├── models/
│   └── views/
│
└── public_html/                # ← Upload public/ folder contents here
    ├── index.php               #    (the front controller)
    ├── .htaccess               #    (from public/.htaccess)
    ├── css/
    ├── js/
    └── uploads/
```

### Step 2: Update Paths in `public_html/index.php`

Open `public_html/index.php` and update the require paths to point to the new `app/` location:

```php
// Before (local development)
require_once __DIR__ . '/../app/config/app.php';

// After (cPanel deployment)
require_once '/home/yourusername/pesaninaja_app/config/app.php';
```

### Step 3: Update `APP_ROOT` in `app/config/app.php`

```php
// Before (auto-detected)
define('APP_ROOT', dirname(__DIR__));

// After (explicit path for cPanel)
define('APP_ROOT', '/home/yourusername/pesaninaja_app');
```

### Step 4: Update `PUBLIC_ROOT` in `app/config/app.php`

```php
// Before
define('PUBLIC_ROOT', APP_ROOT . '/../public');

// After
define('PUBLIC_ROOT', '/home/yourusername/public_html');
```

### Step 5: Configure the Database

1. In cPanel, go to **MySQL Databases** and create:
   - A new database (e.g., `yourusername_pesaninaja`)
   - A new database user with a strong password
   - Assign the user to the database with **All Privileges**
2. Import `database.sql` via **phpMyAdmin** in cPanel.
3. Update `app/config/database.php`:

```php
private static string $host     = 'localhost';
private static string $dbName   = 'yourusername_pesaninaja';
private static string $username = 'yourusername_dbuser';
private static string $password = 'your_secure_password';
```

### Step 6: Set Upload Directory Permissions

Via cPanel File Manager or SSH:

```bash
chmod -R 755 ~/public_html/uploads/
```

### Step 7: Verify `.htaccess` in `public_html`

Ensure `public_html/.htaccess` contains:

```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]
```

> **Important:** The root `.htaccess` (from the project root) is NOT needed on cPanel since `public_html` is already the web root. Only the `.htaccess` from `public/` is required.

### Step 8: Test the Deployment

Visit your domain: `https://yourdomain.com/`

---

## 📜 License

This project is developed for educational purposes.

---

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/your-feature`)
3. Commit your changes (`git commit -m 'Add your feature'`)
4. Push to the branch (`git push origin feature/your-feature`)
5. Open a Pull Request
