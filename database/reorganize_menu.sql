-- Reorganize menu to match user's design
-- New order: Giới Thiệu, Trang Chủ, Sản Phẩm, Công Trình, Giải Pháp, Liên Hệ

-- Update "Dự án" to "Công Trình"
UPDATE wp_virical_navigation_menus SET item_title = 'Công Trình' WHERE id = 13;

-- Update sort order
UPDATE wp_virical_navigation_menus SET sort_order = 1 WHERE id = 10; -- Giới thiệu
UPDATE wp_virical_navigation_menus SET sort_order = 2 WHERE id = 9;  -- Trang chủ
UPDATE wp_virical_navigation_menus SET sort_order = 3 WHERE id = 11; -- Sản phẩm
UPDATE wp_virical_navigation_menus SET sort_order = 4 WHERE id = 13; -- Công Trình (was Dự án)
UPDATE wp_virical_navigation_menus SET sort_order = 5 WHERE id = 12; -- Giải pháp
UPDATE wp_virical_navigation_menus SET sort_order = 6 WHERE id = 14; -- Liên hệ
