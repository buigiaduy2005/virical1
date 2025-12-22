<?php
/**
 * Plugin Name: Force Equipment CPT
 * Description: Forces the registration of the Equipment Post Type outside of the theme.
 * Version: 1.1
 */

add_action('init', 'virical_force_register_equipment_cpt', 10);

function virical_force_register_equipment_cpt() {
    $labels = array(
        'name'                  => 'Equipment (Force)',
        'singular_name'         => 'Equipment Item',
        'menu_name'             => 'Equipment (Force)',
        'name_admin_bar'        => 'Equipment Item',
        'add_new'               => 'Add New',
        'add_new_item'          => 'Add New Equipment',
        'edit_item'             => 'Edit Equipment',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_position'      => 2,
        'menu_icon'          => 'dashicons-hammer',
        'supports'           => array('title', 'thumbnail', 'page-attributes'), // 'thumbnail' is CRITICAL for images
        'show_in_rest'       => true,
    );

    register_post_type('equipment_item', $args);
}

// Add Meta Box with Instruction
add_action('add_meta_boxes', function() {
    add_meta_box(
        'equipment_image_hint',
        'HÌNH ẢNH SẢN PHẨM (QUAN TRỌNG)',
        function() {
            echo '<div style="padding: 10px; background: #fff8e5; border-left: 4px solid #ffb900;">';
            echo '<p><strong>Lưu ý:</strong> Để hiển thị trong vòng xoay 3D, bạn <strong>BẮT BUỘC</strong> phải chọn ảnh ở mục <strong>"Ảnh đại diện" (Featured Image)</strong> ở cột bên phải màn hình.</p>';
            echo '</div>';
        },
        'equipment_item',
        'normal',
        'high'
    );
});

// Original Meta Box for Code and Link
add_action('add_meta_boxes', 'virical_equipment_add_meta_boxes_force');
function virical_equipment_add_meta_boxes_force() {
    add_meta_box(
        'equipment_details_force',
        'Thông tin chi tiết sản phẩm',
        'virical_equipment_render_meta_box_force',
        'equipment_item',
        'normal',
        'high'
    );
}

function virical_equipment_render_meta_box_force($post) {
    $code = get_post_meta($post->ID, '_equipment_code', true);
    $link = get_post_meta($post->ID, '_equipment_link', true);
    wp_nonce_field('virical_equipment_save_force', 'virical_equipment_nonce_force');
    ?>
    <p>
        <label><strong>Mã sản phẩm (Product Code):</strong></label><br>
        <input type="text" name="equipment_code" value="<?php echo esc_attr($code); ?>" class="widefat" placeholder="VD: AWB-2024">
    </p>
    <p>
        <label><strong>Link sản phẩm (Product Link):</strong></label><br>
        <input type="url" name="equipment_link" value="<?php echo esc_attr($link); ?>" class="widefat" placeholder="https://...">
    </p>
    <?php
}

add_action('save_post', function($post_id) {
    if (!isset($_POST['virical_equipment_nonce_force']) || !wp_verify_nonce($_POST['virical_equipment_nonce_force'], 'virical_equipment_save_force')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (isset($_POST['equipment_code'])) update_post_meta($post_id, '_equipment_code', sanitize_text_field($_POST['equipment_code']));
    if (isset($_POST['equipment_link'])) update_post_meta($post_id, '_equipment_link', esc_url_raw($_POST['equipment_link']));
});