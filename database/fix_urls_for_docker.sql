-- ===================================
-- FIX URLs FOR DOCKER LOCAL DEV
-- ===================================
-- This script updates URLs to http://localhost:8000 for local Docker development
--

SET NAMES utf8mb4;
START TRANSACTION;

-- ===================================
-- STEP 1: Update WordPress Core URLs
-- ===================================
UPDATE wp_options
SET option_value = 'http://localhost:8000'
WHERE option_name IN ('siteurl', 'home');

-- ===================================
-- STEP 2: Update Posts Content
-- ===================================
UPDATE wp_posts
SET post_content = REPLACE(post_content, 'http://localhost:8082', 'http://localhost:8000')
WHERE post_content LIKE '%localhost:8082%';

UPDATE wp_posts
SET post_content = REPLACE(post_content, 'http://localhost:9000', 'http://localhost:8000')
WHERE post_content LIKE '%localhost:9000%';

UPDATE wp_posts
SET post_content = REPLACE(post_content, 'https://virical.vn', 'http://localhost:8000')
WHERE post_content LIKE '%virical.vn%';

-- ===================================
-- STEP 3: Update Post GUIDs
-- ===================================
UPDATE wp_posts
SET guid = REPLACE(guid, 'http://localhost:8082', 'http://localhost:8000')
WHERE guid LIKE '%localhost:8082%';

UPDATE wp_posts
SET guid = REPLACE(guid, 'http://localhost:9000', 'http://localhost:8000')
WHERE guid LIKE '%localhost:9000%';

UPDATE wp_posts
SET guid = REPLACE(guid, 'https://virical.vn', 'http://localhost:8000')
WHERE guid LIKE '%virical.vn%';

-- ===================================
-- STEP 4: Update Post Meta
-- ===================================
UPDATE wp_postmeta
SET meta_value = REPLACE(meta_value, 'http://localhost:8082', 'http://localhost:8000')
WHERE meta_value LIKE '%localhost:8082%';

UPDATE wp_postmeta
SET meta_value = REPLACE(meta_value, 'http://localhost:9000', 'http://localhost:8000')
WHERE meta_value LIKE '%localhost:9000%';

UPDATE wp_postmeta
SET meta_value = REPLACE(meta_value, 'https://virical.vn', 'http://localhost:8000')
WHERE meta_value LIKE '%virical.vn%';

-- ===================================
-- STEP 5: Update Custom Tables
-- ===================================
-- Products
UPDATE wp_virical_products
SET image_url = REPLACE(image_url, 'http://localhost:8082', 'http://localhost:8000')
WHERE image_url LIKE '%localhost:8082%';

UPDATE wp_virical_products
SET image_url = REPLACE(image_url, 'http://localhost:9000', 'http://localhost:8000')
WHERE image_url LIKE '%localhost:9000%';

UPDATE wp_virical_products
SET image_url = REPLACE(image_url, 'https://virical.vn', 'http://localhost:8000')
WHERE image_url LIKE '%virical.vn%';

-- Indoor Products
UPDATE wp_indoor_products
SET product_image = REPLACE(product_image, 'http://localhost:8082', 'http://localhost:8000')
WHERE product_image LIKE '%localhost:8082%';

UPDATE wp_indoor_products
SET product_image = REPLACE(product_image, 'http://localhost:9000', 'http://localhost:8000')
WHERE product_image LIKE '%localhost:9000%';

UPDATE wp_indoor_products
SET product_image = REPLACE(product_image, 'https://virical.vn', 'http://localhost:8000')
WHERE product_image LIKE '%virical.vn%';

-- Projects
UPDATE wp_virical_projects
SET main_image = REPLACE(main_image, 'http://localhost:8082', 'http://localhost:8000')
WHERE main_image LIKE '%localhost:8082%';

UPDATE wp_virical_projects
SET main_image = REPLACE(main_image, 'http://localhost:9000', 'http://localhost:8000')
WHERE main_image LIKE '%localhost:9000%';

UPDATE wp_virical_projects
SET main_image = REPLACE(main_image, 'https://virical.vn', 'http://localhost:8000')
WHERE main_image LIKE '%virical.vn%';

COMMIT;
