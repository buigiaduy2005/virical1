-- Update menu order: Trang chủ before Giới thiệu
-- Current: Giới thiệu (1), Trang chủ (2), Sản phẩm (3), Giải pháp (4), Liên hệ (5)  
-- Target:  Trang chủ (1), Giới thiệu (2), Sản phẩm (3), Giải pháp (4), Liên hệ (5)

UPDATE wp_virical_navigation_menus 
SET sort_order = 1 
WHERE item_title = 'Trang chủ' AND menu_location = 'primary';

UPDATE wp_virical_navigation_menus 
SET sort_order = 2 
WHERE item_title = 'Giới thiệu' AND menu_location = 'primary';

-- Verify the change
SELECT id, item_title, sort_order 
FROM wp_virical_navigation_menus 
WHERE menu_location = 'primary' 
ORDER BY sort_order;
