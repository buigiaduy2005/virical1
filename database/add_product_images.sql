-- Add 3 additional image columns to products table
-- This allows each product to have up to 4 images total

ALTER TABLE wp_virical_products
ADD COLUMN image_url_2 VARCHAR(500) DEFAULT NULL AFTER image_url,
ADD COLUMN image_url_3 VARCHAR(500) DEFAULT NULL AFTER image_url_2,
ADD COLUMN image_url_4 VARCHAR(500) DEFAULT NULL AFTER image_url_3;

-- Verify columns were added
DESCRIBE wp_virical_products;
