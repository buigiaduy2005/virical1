<?php
/**
 * Virical Custom Menu Renderer
 * Renders navigation menu from wp_virical_navigation_menus table
 */

if (!function_exists('virical_render_navigation_menu')) {
    /**
     * Render navigation menu with dropdown support
     *
     * @param string $location Menu location (primary, footer, etc.)
     * @param string $menu_class CSS class for menu ul
     * @return void
     */
    function virical_render_navigation_menu($location = 'primary', $menu_class = 'main-nav') {
        global $wpdb;

        // Get all active menus for this location
        $menus = $wpdb->get_results($wpdb->prepare(
            "SELECT id, parent_id, item_title, item_url, item_icon, item_description, sort_order
            FROM wp_virical_navigation_menus
            WHERE menu_location = %s AND is_active = 1
            ORDER BY sort_order ASC",
            $location
        ));

        if (empty($menus)) {
            // Fallback menu if no menus found
            echo '<ul class="' . esc_attr($menu_class) . '">';
            echo '<li><a href="' . home_url('/') . '">Trang Chủ</a></li>';
            echo '</ul>';
            return;
        }

        // Organize menus into parent-child structure
        $menu_tree = [];
        $menu_items = [];

        // First pass: store all items by ID
        foreach ($menus as $menu) {
            $menu_items[$menu->id] = $menu;
            $menu_items[$menu->id]->children = [];
        }

        // Second pass: build tree structure
        foreach ($menus as $menu) {
            if ($menu->parent_id === NULL) {
                // Top level menu
                $menu_tree[] = $menu->id;
            } else {
                // Child menu - add to parent's children array
                if (isset($menu_items[$menu->parent_id])) {
                    $menu_items[$menu->parent_id]->children[] = $menu->id;
                }
            }
        }

        // Render the menu
        echo '<ul class="' . esc_attr($menu_class) . '">';

        foreach ($menu_tree as $parent_id) {
            $parent = $menu_items[$parent_id];
            $has_children = !empty($parent->children);
            $is_active = virical_is_menu_active($parent->item_url);
            
            // Check if this is Products menu for mega menu
            $is_products = (stripos($parent->item_title, 'sản phẩm') !== false || 
                           stripos($parent->item_title, 'product') !== false);
            
            // Force has_children for Products to show mega menu
            if ($is_products) {
                $has_children = true;
            }

            // Start parent menu item
            echo '<li class="menu-item' . ($has_children ? ' menu-item-has-children' : '') . ($is_active ? ' current-menu-item' : '') . '">';

            // Parent menu link
            echo '<a href="' . esc_url($parent->item_url) . '"';
            if ($parent->item_description) {
                echo ' title="' . esc_attr($parent->item_description) . '"';
            }
            if ($is_active) {
                echo ' class="active"';
            }
            echo '>';
            echo esc_html($parent->item_title);
            echo '</a>';

            // Render submenu if has children (including forced for Products)
            if ($has_children) {
                if ($is_products) {
                    // Render MEGA MENU for products
                    echo virical_render_products_mega_menu();
                } else if (!empty($parent->children)) {
                    // Regular dropdown submenu (only if actually has nav menu children)
                    echo '<ul class="sub-menu">';
                    
                    foreach ($parent->children as $child_id) {
                        $child = $menu_items[$child_id];
                        $child_active = virical_is_menu_active($child->item_url);
                        
                        echo '<li class="menu-item' . ($child_active ? ' current-menu-item' : '') . '">';
                        echo '<a href="' . esc_url($child->item_url) . '"';
                        if ($child->item_description) {
                            echo ' title="' . esc_attr($child->item_description) . '"';
                        }
                        if ($child_active) {
                            echo ' class="active"';
                        }
                        echo '>';
                        echo esc_html($child->item_title);
                        echo '</a>';
                        echo '</li>';
                    }
                    
                    echo '</ul>';
                }
            }

            echo '</li>';
        }

        echo '</ul>';
    }
}

/**
 * Get menu item by URL (for active state)
 */
if (!function_exists('virical_is_menu_active')) {
    function virical_is_menu_active($menu_url) {
        $current_url = $_SERVER['REQUEST_URI'];
        
        // Remove trailing slashes for comparison
        $normalized_current = rtrim($current_url, '/');
        $normalized_menu = rtrim($menu_url, '/');
        
        if (empty($normalized_menu)) $normalized_menu = '/';
        if (empty($normalized_current)) $normalized_current = '/';

        if ($normalized_menu === '/') {
            return $normalized_current === '/';
        }
        
        return strpos($normalized_current, $normalized_menu) === 0;
    }
}

/**
 * Render Products Mega Menu
 */
if (!function_exists('virical_render_products_mega_menu')) {
    function virical_render_products_mega_menu() {
        global $wpdb;
        
        // Get all product categories
        $categories = $wpdb->get_results(
            "SELECT id, parent_id, name, slug, image_url, sort_order
            FROM {$wpdb->prefix}virical_product_categories
            WHERE is_active = 1
            ORDER BY parent_id ASC, sort_order ASC"
        );
        
        if (empty($categories)) {
            return '';
        }
       
        // Build mega menu HTML in GRID layout with ICONS
        $html = '<div class="mega-menu">';
        $html .= '<div class="mega-menu-grid">';
        
        foreach ($categories as $cat) {
            $cat_url = home_url('/san-pham/?category=' . $cat->slug);
            $icon_url = $cat->image_url ?: 'https://via.placeholder.com/60';
            
            $html .= '<div class="mega-menu-item">';
            $html .= '<a href="' . esc_url($cat_url) . '" class="mega-menu-item-link">';
            
            // Icon
            $html .= '<div class="mega-menu-item-icon">';
            $html .= '<img src="' . esc_url($icon_url) . '" alt="' . esc_attr($cat->name) . '">';
            $html .= '</div>';
            
            // Name
            $html .= '<div class="mega-menu-item-name">';
            $html .= esc_html($cat->name);
            $html .= '</div>';
            
            $html .= '</a>';
            $html .= '</div>';
        }
        
        $html .= '</div>'; // .mega-menu-grid
        $html .= '</div>'; // .mega-menu
        
        return $html;
    }
}

?>