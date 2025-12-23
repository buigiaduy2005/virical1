-- Update menu items
-- Change "Sản phẩm đèn" to "Sản phẩm" (ID 11)
-- Change "Giải pháp thông minh" to "Giải pháp" (ID 12)

UPDATE wp_virical_navigation_menus SET item_title = 'Sản phẩm' WHERE id = 11;
UPDATE wp_virical_navigation_menus SET item_title = 'Giải pháp' WHERE id = 12;
