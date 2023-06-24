SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  sku VARCHAR(50) NOT NULL,
  title VARCHAR(255) NOT NULL,
  image VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  price DECIMAL(10, 2) NOT NULL,
  category VARCHAR(100) NOT NULL
);

INSERT INTO products (sku, title, image, description, price, category)
VALUES
  ('SKU001', 'Product 1', 'https://example.com/product1.jpg', 'Description of Product 1', 9.99, 'Category 1'),
  ('SKU002', 'Product 2', 'https://example.com/product2.jpg', 'Description of Product 2', 19.99, 'Category 2'),
  ('SKU003', 'Product 3', 'https://example.com/product3.jpg', 'Description of Product 3', 29.99, 'Category 1'),
  ('SKU004', 'Product 4', 'https://example.com/product4.jpg', 'Description of Product 4', 39.99, 'Category 3'),
  ('SKU005', 'Product 5', 'https://example.com/product5.jpg', 'Description of Product 5', 49.99, 'Category 2');
  
COMMIT;