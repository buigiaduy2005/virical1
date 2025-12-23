<?php
/**
 * Register Hero Slider Post Type
 * 
 * @package Virical
 */

function virical_register_slider_post_type() {
    $labels = array(
        'name'               => 'Hero Sliders',
        'singular_name'      => 'Slider',
        'menu_name'          => 'Hero Slider',
        'add_new'            => 'Thêm Slider mới',
        'add_new_item'       => 'Thêm Slider mới',
        'edit_item'          => 'Sửa Slider',
        'new_item'           => 'Slider mới',
        'view_item'          => 'Xem Slider',
        'search_items'       => 'Tìm kiếm Slider',
        'not_found'          => 'Không tìm thấy slider nào',
        'not_found_in_trash' => 'Không tìm thấy slider trong thùng rác'
    );

    $args = array(
        'labels'              => $labels,
        'public'              => false, // Không cần trang chi tiết riêng
        'show_ui'             => true,  // Hiển thị trong admin
        'show_in_menu'        => true,
        'menu_position'       => 20,
        'menu_icon'           => 'dashicons-images-alt2',
        'supports'            => array('title', 'thumbnail', 'page-attributes'), // Title, Ảnh, Thứ tự
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'rewrite'             => false
    );

    register_post_type('aura_slider', $args);
}
add_action('init', 'virical_register_slider_post_type');

/**
 * Add Meta Boxes for Slider Details (Subtitle & Link)
 */
function virical_slider_add_meta_boxes() {
    add_meta_box(
        'slider_details',
        'Thông tin chi tiết Slider',
        'virical_slider_render_meta_box',
        'aura_slider',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'virical_slider_add_meta_boxes');

function virical_slider_render_meta_box($post) {
    // Get current values
    $subtitle = get_post_meta($post->ID, '_slide_subtitle', true);
    $link = get_post_meta($post->ID, '_slide_link', true);
    
    // Security nonce
    wp_nonce_field('virical_slider_save', 'virical_slider_nonce');
    ?>
    <p>
        <label for="slide_subtitle"><strong>Tiêu đề hiển thị trên ảnh (Subtitle):</strong></label><br>
        <input type="text" id="slide_subtitle" name="slide_subtitle" value="<?php echo esc_attr($subtitle); ?>" class="widefat" placeholder="Ví dụ: CHẤT LƯỢNG - UY TÍN - CHUYÊN NGHIỆP">
        <span class="description">Dòng chữ lớn hiển thị giữa hình ảnh.</span>
    </p>
    <p>
        <label for="slide_link"><strong>Đường dẫn (Link) khi click vào:</strong></label><br>
        <input type="url" id="slide_link" name="slide_link" value="<?php echo esc_attr($link); ?>" class="widefat" placeholder="https://...">
    </p>
    <?php
}

function virical_slider_save_meta_boxes($post_id) {
    // Verify nonce
    if (!isset($_POST['virical_slider_nonce']) || !wp_verify_nonce($_POST['virical_slider_nonce'], 'virical_slider_save')) {
        return;
    }
    
    // Auto save check
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    
    // Permission check
    if (!current_user_can('edit_post', $post_id)) return;

    // Save fields
    if (isset($_POST['slide_subtitle'])) {
        update_post_meta($post_id, '_slide_subtitle', sanitize_text_field($_POST['slide_subtitle']));
    }
    if (isset($_POST['slide_link'])) {
        update_post_meta($post_id, '_slide_link', esc_url_raw($_POST['slide_link']));
    }
}
add_action('save_post', 'virical_slider_save_meta_boxes');

/**
 * Add columns to Admin List View
 */
function virical_slider_columns($columns) {
    $new_columns = array(
        'cb' => $columns['cb'],
        'thumbnail' => 'Hình ảnh', // Move thumbnail to start
        'title' => 'Tên Slider (Admin)',
        'slide_subtitle' => 'Tiêu đề hiển thị',
        'slide_link' => 'Link',
        'date' => $columns['date']
    );
    return $new_columns;
}
add_filter('manage_aura_slider_posts_columns', 'virical_slider_columns');

function virical_slider_custom_column($column, $post_id) {
    switch ($column) {
        case 'thumbnail':
            if (has_post_thumbnail($post_id)) {
                echo get_the_post_thumbnail($post_id, array(80, 50));
            } else {
                echo 'No Image';
            }
            break;
        case 'slide_subtitle':
            echo esc_html(get_post_meta($post_id, '_slide_subtitle', true));
            break;
        case 'slide_link':
            echo esc_url(get_post_meta($post_id, '_slide_link', true));
            break;
    }
}
add_action('manage_aura_slider_posts_custom_column', 'virical_slider_custom_column', 10, 2);
