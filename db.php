<?php
session_start();

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "Ecommerce";


$conn = mysqli_connect($servername, $username, $password);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS $dbname");
mysqli_select_db($conn, $dbname);


$result = mysqli_query($conn, "SHOW TABLES LIKE 'customer'");
if (mysqli_num_rows($result) == 0) {
   
    echo "<div style='font-family:sans-serif;text-align:center;margin-top:50px;'>
            <h2>Initializing Database...</h2>
            <p>Please wait while we set things up.</p>
          </div>";

 
    $schema = "
    CREATE TABLE IF NOT EXISTS customer (
      id INT AUTO_INCREMENT PRIMARY KEY,
      email VARCHAR(255) NOT NULL UNIQUE,
      password VARCHAR(255) NOT NULL,
      first_name VARCHAR(100) NOT NULL,
      last_name  VARCHAR(100) NOT NULL,
      username   VARCHAR(100) NOT NULL UNIQUE,
      phone VARCHAR(20),
      city VARCHAR(100) NOT NULL,
      region VARCHAR(100),
      postal_code VARCHAR(20),
      country_code CHAR(2) NOT NULL,
      card_number VARCHAR(25),
      card_expiry VARCHAR(10),
      card_cvv VARCHAR(5),
      billing_name VARCHAR(255),
      billing_line1 VARCHAR(255),
      billing_city VARCHAR(100),
      billing_region VARCHAR(100),
      billing_postal_code VARCHAR(20),
      billing_country_code CHAR(2),
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
      updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );

    CREATE TABLE IF NOT EXISTS product (
      id BIGINT AUTO_INCREMENT PRIMARY KEY,
      title VARCHAR(255) NOT NULL,
      description TEXT,
      brand VARCHAR(100),
      price_cents BIGINT NOT NULL,
      currency VARCHAR(10) NOT NULL DEFAULT 'USD',
      stock INT NOT NULL DEFAULT 0,
      img_location VARCHAR(500) NOT NULL,
      rating DECIMAL(2,1) NOT NULL CHECK (rating >= 1.0 AND rating <= 5.0),
      created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );

    CREATE TABLE IF NOT EXISTS admin (
      id BIGINT AUTO_INCREMENT PRIMARY KEY,
      name VARCHAR(100) NOT NULL,
      email VARCHAR(255) NOT NULL UNIQUE,
      password_hash VARCHAR(255) NOT NULL,
      role VARCHAR(6) NOT NULL DEFAULT 'admin',
      is_active TINYINT(1) NOT NULL DEFAULT 1,
      last_login TIMESTAMP NULL DEFAULT NULL,
      created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );

    INSERT IGNORE INTO admin (name, email, password_hash, role, is_active)
    VALUES ('admin','admin@email.com',
    '$2y$10$pqL0mAdfZi49MJkFqQMhTeW3vPUHPz5oo2nNg3tpbGGZW.u6YNk4u','admin',1);

    CREATE TABLE IF NOT EXISTS orders (
      id BIGINT AUTO_INCREMENT PRIMARY KEY,
      order_number VARCHAR(64) NOT NULL UNIQUE,
      customer_id INT NULL,
      status VARCHAR(20) NOT NULL DEFAULT 'pending',
      subtotal_cents BIGINT NOT NULL DEFAULT 0,
      tax_cents BIGINT NOT NULL DEFAULT 0,
      shipping_cents BIGINT NOT NULL DEFAULT 0,
      total_cents BIGINT NOT NULL DEFAULT 0,
      placed_at DATETIME NULL,
      created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      INDEX idx_orders_customer_id (customer_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

    CREATE TABLE IF NOT EXISTS order_item (
      id BIGINT AUTO_INCREMENT PRIMARY KEY,
      order_id BIGINT NOT NULL,
      product_id BIGINT NULL,
      product_title VARCHAR(255) NOT NULL,
      sku VARCHAR(64),
      quantity INT NOT NULL,
      unit_price_cents BIGINT NOT NULL,
      currency VARCHAR(10) NOT NULL DEFAULT 'USD',
      total_cents BIGINT NOT NULL,
      INDEX idx_item_order_id (order_id),
      INDEX idx_item_product_id (product_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

    CREATE TABLE IF NOT EXISTS app_settings (
      id INT PRIMARY KEY AUTO_INCREMENT,
      setting_name VARCHAR(100) NOT NULL,
      description VARCHAR(255),
      value TINYINT(1) NOT NULL DEFAULT 1
    );

    INSERT IGNORE INTO app_settings (setting_name, description, value)
    VALUES ('Price Demo Mode', 'Enables demo pricing functionality', 1);
    ";

    if (mysqli_multi_query($conn, $schema)) {
        do { mysqli_next_result($conn); } while (mysqli_more_results($conn));
    }
}
?>

