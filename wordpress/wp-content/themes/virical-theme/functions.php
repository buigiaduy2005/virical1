<?php
/**
 * Virical Theme Functions
 * 
 * @package Virical
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup
 */
function virical_theme_setup() {
    // Add theme support
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'virical'),
        'footer' => __('Footer Menu', 'virical'),
    ));
}
add_action('after_setup_theme', 'virical_theme_setup');

/**
 * Enqueue scripts and styles
 */
function virical_enqueue_scripts() {
    // Theme stylesheet
    wp_enqueue_style('virical-style', get_stylesheet_uri(), array(), '1.0.0');
    
    // Theme scripts
    wp_enqueue_script('virical-script', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'virical_enqueue_scripts');

/**
 * Admin scripts and styles
 */
function virical_admin_enqueue_scripts() {
    wp_enqueue_style('virical-admin', get_template_directory_uri() . '/assets/css/admin.css', array(), '1.0.0');
    wp_enqueue_script('virical-admin', get_template_directory_uri() . '/assets/js/admin.js', array('jquery'), '1.0.0', true);
    
    // Localize script for AJAX
    wp_localize_script('virical-admin', 'virical_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('virical_menu_nonce')
    ));
}
add_action('admin_enqueue_scripts', 'virical_admin_enqueue_scripts');

/**
 * Initialize Dynamic Configuration System
 */
function virical_init_configuration_system() {
    // Include the Admin Menu Manager class
    require_once get_template_directory() . '/includes/class-virical-admin-menu-manager.php';
    
    // Include other managers if they exist
    $managers = [
        'class-virical-template-manager.php',
        'class-virical-navigation-manager.php',
        'class-virical-routing-manager.php',
        'contact-admin.php',
        'footer-admin-manager.php',
        'about-page-admin.php'
    ];
    
    foreach ($managers as $file) {
        if (file_exists(get_template_directory() . '/includes/' . $file)) {
            require_once get_template_directory() . '/includes/' . $file;
        }
    }

    // Initialize the managers
    if (class_exists('ViricalAdminMenuManager')) $GLOBALS['virical_menu_manager'] = new ViricalAdminMenuManager();
    if (class_exists('ViricalTemplateManager')) {
        $GLOBALS['virical_template_manager'] = new ViricalTemplateManager();
        $GLOBALS['virical_template_manager']->init();
    }
    if (class_exists('ViricalNavigationManager')) {
        $GLOBALS['virical_navigation_manager'] = new ViricalNavigationManager();
        $GLOBALS['virical_navigation_manager']->init();
    }
    if (class_exists('ViricalRoutingManager')) {
        $GLOBALS['virical_routing_manager'] = new ViricalRoutingManager();
        $GLOBALS['virical_routing_manager']->init();
    }
}
add_action('init', 'virical_init_configuration_system');

/**
 * Phone Reveal Effect Settings
 */
require_once get_template_directory() . '/includes/phone-reveal-settings.php';

/**
 * Smart Solutions Page Admin Settings
 */
require_once get_template_directory() . '/includes/smart-solutions-admin.php';

/**
 * REGISTER EQUIPMENT POST TYPE (EMBEDDED)
 * Directly embedded to ensure it registers correctly
 */
function virical_register_equipment_post_type() {
    $labels = array(
        'name'                  => 'Equipment Items',
        'singular_name'         => 'Equipment Item',
        'menu_name'             => 'Equipment',
        'name_admin_bar'        => 'Equipment Item',
        'add_new'               => 'Add New',
        'add_new_item'          => 'Add New Equipment Item',
        'new_item'              => 'New Equipment Item',
        'edit_item'             => 'Edit Equipment Item',
        'view_item'             => 'View Equipment Item',
        'all_items'             => 'All Equipment',
        'search_items'          => 'Search Equipment',
        'parent_item_colon'     => 'Parent Equipment:',
        'not_found'             => 'No equipment found.',
        'not_found_in_trash'    => 'No equipment found in Trash.',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'equipment' ),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 25, // Below Comments
        'menu_icon'          => 'dashicons-hammer',
        'supports'           => array( 'title', 'thumbnail', 'page-attributes' ),
    );

    register_post_type( 'equipment_item', $args );
}
add_action( 'init', 'virical_register_equipment_post_type', 0 );

/**
 * REGISTER PROJECT POST TYPE
 */
function virical_register_project_post_type() {
    $labels = array(
        'name'                  => 'Dự Án',
        'singular_name'         => 'Dự Án',
        'menu_name'             => 'Dự Án',
        'name_admin_bar'        => 'Dự Án',
        'add_new'               => 'Thêm Mới',
        'add_new_item'          => 'Thêm Dự Án Mới',
        'new_item'              => 'Dự Án Mới',
        'edit_item'             => 'Sửa Dự Án',
        'view_item'             => 'Xem Dự Án',
        'all_items'             => 'Tất Cả Dự Án',
        'search_items'          => 'Tìm Dự Án',
        'parent_item_colon'     => 'Dự Án Cha:',
        'not_found'             => 'Không tìm thấy dự án.',
        'not_found_in_trash'    => 'Không có dự án trong thùng rác.',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'du-an' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 26,
        'menu_icon'          => 'dashicons-building',
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
    );

    register_post_type( 'aura_project', $args );
    
    // Register Taxonomy for Projects
    register_taxonomy( 'project_category', 'aura_project', array(
        'labels' => array(
            'name' => 'Loại Công Trình',
            'singular_name' => 'Loại Công Trình',
            'menu_name' => 'Loại Công Trình',
        ),
        'public' => true,
        'hierarchical' => true,
        'show_ui' => true,
        'rewrite' => array('slug' => 'loai-cong-trinh'),
    ));
}
add_action( 'init', 'virical_register_project_post_type', 0 );


/**
 * EQUIPMENT META BOXES
 */
function virical_equipment_add_meta_boxes() {
    add_meta_box(
        'equipment_details',
        'Equipment Details',
        'virical_equipment_render_meta_box',
        'equipment_item',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'virical_equipment_add_meta_boxes' );

function virical_equipment_render_meta_box( $post ) {
    $code = get_post_meta( $post->ID, '_equipment_code', true );
    $link = get_post_meta( $post->ID, '_equipment_link', true );
    wp_nonce_field( 'virical_equipment_save', 'virical_equipment_nonce' );
    ?>
    <p>
        <label for="equipment_code"><strong>Product Code:</strong></label><br>
        <input type="text" id="equipment_code" name="equipment_code" value="<?php echo esc_attr( $code ); ?>" class="widefat" placeholder="e.g., AWB-2024">
    </p>
    <p>
        <label for="equipment_link"><strong>Product Link:</strong></label><br>
        <input type="url" id="equipment_link" name="equipment_link" value="<?php echo esc_attr( $link ); ?>" class="widefat" placeholder="https://...">
    </p>
    <?php
}

function virical_equipment_save_meta_boxes( $post_id ) {
    if ( ! isset( $_POST['virical_equipment_nonce'] ) || ! wp_verify_nonce( $_POST['virical_equipment_nonce'], 'virical_equipment_save' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    if ( isset( $_POST['equipment_code'] ) ) {
        update_post_meta( $post_id, '_equipment_code', sanitize_text_field( $_POST['equipment_code'] ) );
    }
    if ( isset( $_POST['equipment_link'] ) ) {
        update_post_meta( $post_id, '_equipment_link', esc_url_raw( $_POST['equipment_link'] ) );
    }
}
add_action( 'save_post', 'virical_equipment_save_meta_boxes' );

// ... Rest of the standard functions ...

/**
 * Run database migrations
 */
function virical_run_migrations() {
    if (!is_admin()) return;
    $migrations = [
        '001-create-admin-menu-table.php' => 'virical_migration_001',
        '002-populate-admin-menus.php' => 'virical_migration_002',
        '003-create-templates-table.php' => 'virical_migration_003',
        '004-create-navigation-table.php' => 'virical_migration_004',
        '005-create-routing-table.php' => 'virical_migration_005'
    ];
    foreach ($migrations as $file => $prefix) {
        if (file_exists(get_template_directory() . '/migrations/' . $file)) {
            require_once get_template_directory() . '/migrations/' . $file;
            $check_func = $prefix . '_should_run';
            $exec_func = $prefix . '_execute';
            if (function_exists($check_func) && $check_func()) {
                $exec_func();
            }
        }
    }
}
add_action('admin_init', 'virical_run_migrations');

/**
 * Theme activation hook
 */
function virical_theme_activate() {
    virical_theme_setup();
    flush_rewrite_rules();
    update_option('virical_theme_version', '1.0.0');
    update_option('virical_theme_activated', current_time('mysql'));
}
add_action('after_switch_theme', 'virical_theme_activate');
add_action('switch_theme', 'virical_theme_deactivate');
function virical_theme_deactivate() {
    flush_rewrite_rules();
}

// Include other necessary files
if (file_exists(get_template_directory() . '/includes/template-functions.php')) {
    require_once get_template_directory() . '/includes/template-functions.php';
}
if (file_exists(get_template_directory() . '/includes/widgets.php')) {
    require_once get_template_directory() . '/includes/widgets.php';
}
if (file_exists(get_template_directory() . '/includes/customizer.php')) {
    require_once get_template_directory() . '/includes/customizer.php';
}

require_once get_template_directory() . '/includes/top-banner-admin.php';
require_once get_template_directory() . '/includes/products-admin.php';
require_once get_template_directory() . '/includes/projects-admin.php';
// Global Admin Search
if (file_exists(get_template_directory() . '/includes/admin-global-search.php')) {
    require_once get_template_directory() . '/includes/admin-global-search.php';
}

// Hero Slider Post Type
require_once get_template_directory() . '/includes/slider-post-type.php';

/**
 * Custom rewrite rules
 */
function virical_custom_rewrite_rules() {
    add_rewrite_rule('^san-pham/([^/]+)/?$', 'index.php?pagename=san-pham&product=$matches[1]', 'top');
    add_rewrite_rule('^cong-trinh/([^/]+)/?$', 'index.php?pagename=cong-trinh&project=$matches[1]', 'top');
    add_rewrite_rule('^danh-muc-san-pham/([^/]+)/?$', 'index.php?pagename=san-pham&product_category=$matches[1]', 'top');
    add_rewrite_rule('^loai-cong-trinh/([^/]+)/?$', 'index.php?pagename=cong-trinh&project_type=$matches[1]', 'top');
}
add_action('init', 'virical_custom_rewrite_rules');

function virical_query_vars($vars) {
    $vars[] = 'product';
    $vars[] = 'project';
    $vars[] = 'product_category';
    $vars[] = 'project_type';
    return $vars;
}
add_filter('query_vars', 'virical_query_vars');

// Helper Functions
function virical_get_homepage_settings($key = null) {
    global $wpdb;
    static $settings_cache = null;
    if ($settings_cache === null) {
        $results = $wpdb->get_results("SELECT setting_key, setting_value, setting_type FROM {$wpdb->prefix}homepage_settings");
        $settings_cache = array();
        foreach ($results as $row) {
            $value = $row->setting_value;
            if ($row->setting_type === 'json') $value = json_decode($value, true);
            $settings_cache[$row->setting_key] = $value;
        }
    }
    return $key ? (isset($settings_cache[$key]) ? $settings_cache[$key] : null) : $settings_cache;
}

function virical_get_company_info($key, $default = '') {
    $option_map = [
        'phone' => 'virical_company_phone',
        'mobile' => 'virical_company_mobile',
        'email' => 'virical_company_email',
        'support_email' => 'virical_company_support_email',
        'address' => 'virical_company_address',
        'address_short' => 'virical_company_address_short',
        'name' => 'virical_company_name',
        'short_name' => 'virical_company_short_name',
        'slogan' => 'virical_company_slogan',
        'description' => 'virical_company_description',
        'business_hours' => 'virical_business_hours',
        'business_hours_showroom' => 'virical_business_hours_showroom',
        'hotline' => 'virical_hotline',
        'fax' => 'virical_fax',
        'google_maps' => 'virical_google_maps_embed',
    ];
    $option_name = $option_map[$key] ?? 'virical_company_' . $key;
    return get_option($option_name, $default);
}

function virical_display_phone($with_icon = true) {
    $phone = virical_get_company_info('phone');
    if ($with_icon) echo '<i class="fas fa-phone"></i> ';
    echo '<a href="tel:' . esc_attr($phone) . '">' . esc_html($phone) . '</a>';
}

function virical_display_email($with_icon = true) {
    $email = virical_get_company_info('email');
    if ($with_icon) echo '<i class="fas fa-envelope"></i> ';
    echo '<a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a>';
}

function virical_get_social_link($platform, $default = '#') {
    return get_option('virical_social_' . strtolower($platform), $default);
}