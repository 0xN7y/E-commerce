-- dn name Ecommerce; 


CREATE TABLE customer (
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





CREATE TABLE product (
  id            BIGINT AUTO_INCREMENT PRIMARY KEY,
  title         VARCHAR(255) NOT NULL,
  description   TEXT,
  brand         VARCHAR(100),
  price_cents   BIGINT NOT NULL,
  currency      VARCHAR(10) NOT NULL DEFAULT 'USD',
  stock         INT NOT NULL DEFAULT 0,
  img_location  VARCHAR(500) NOT NULL,
  rating        DECIMAL(2,1) NOT NULL CHECK (rating >= 1.0 AND rating <= 5.0),
  created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);



CREATE TABLE admin (
    id              BIGINT AUTO_INCREMENT PRIMARY KEY,
    name            VARCHAR(100) NOT NULL,
    email           VARCHAR(255) NOT NULL UNIQUE,
    password_hash   VARCHAR(255) NOT NULL,
    role            VARCHAR(6) NOT NULL DEFAULT 'admin',
    is_active       TINYINT(1) NOT NULL DEFAULT 1,
    last_login      TIMESTAMP NULL DEFAULT NULL,
    created_at      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
                    ON UPDATE CURRENT_TIMESTAMP
);


-- echo password_hash("admin", PASSWORD_DEFAULT);

INSERT INTO admin 
(name, email, password_hash, role, is_active)
VALUES
(
    'admin',
    'admin@email.com',
    '$2y$10$pqL0mAdfZi49MJkFqQMhTeW3vPUHPz5oo2nNg3tpbGGZW.u6YNk4u',
    'admin',
    1
);






CREATE TABLE orders (
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

CREATE TABLE order_item (
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






-- Insert order
INSERT INTO orders (
  order_number,
  customer_id,
  status,
  subtotal_cents,
  tax_cents,
  shipping_cents,
  total_cents,
  placed_at
) VALUES (
  'ORD-1001',   -- unique order number
  1,            -- customer_id from customer table
  'pending',    -- order status
  35000,        -- subtotal (15000 + 20000)
  0,            -- tax
  0,            -- shipping
  35000,        -- total
  NOW()         -- placed_at
);


-- Now add the products to order_item:
-- Vintage Camera
INSERT INTO order_item (
  order_id,
  product_id,
  product_title,
  sku,
  quantity,
  unit_price_cents,
  currency,
  total_cents
) VALUES (
  1,              -- order_id from orders
  1,              -- product_id from product
  'Vintage Camera',
  'CAM-RETRO-001',
  1,
  15000,
  'ETB',
  15000
);

-- -- Smartwatch
-- INSERT INTO order_item (
--   order_id,
--   product_id,
--   product_title,
--   sku,
--   quantity,
--   unit_price_cents,
--   currency,
--   total_cents
-- ) VALUES (
--   1,
--   6,
--   'Smartwatch',
--   'WATCH-FIT-001',
--   1,
--   20000,
--   'ETB',
--   20000
-- );


-- To display orders for user1:

SELECT o.id, o.order_number, o.status, o.total_cents, o.placed_at
FROM orders o
JOIN customer c ON o.customer_id = c.id
WHERE c.username = 'user1';




-- Query Order Items for an Orde
SELECT oi.product_title, oi.quantity, oi.unit_price_cents, oi.total_cents
FROM order_item oi
WHERE oi.order_id = 1;


CREATE TABLE app_settings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    setting_name VARCHAR(100) NOT NULL,
    description VARCHAR(255),
    value TINYINT(1) NOT NULL DEFAULT 1
);

INSERT INTO app_settings (setting_name, description, value)
VALUES ('Price Demo Mode', 'Enables demo pricing functionality', 1);



