<?php
/**
 * Smart Solutions Page Admin Settings
 */

// Add admin menu
add_action('admin_menu', 'virical_smart_solutions_menu');

function virical_smart_solutions_menu() {
    add_menu_page(
        'Giải Pháp Thông Minh',
        'Giải Pháp TM',
        'manage_options',
        'virical-smart-solutions',
        'virical_smart_solutions_page',
        'dashicons-lightbulb',
        31
    );
}

// Register settings
add_action('admin_init', 'virical_smart_solutions_register_settings');

function virical_smart_solutions_register_settings() {
    register_setting('virical_smart_solutions_options', 'smart_hero_bg_image');
    register_setting('virical_smart_solutions_options', 'smart_hero_gradient_start');
    register_setting('virical_smart_solutions_options', 'smart_hero_gradient_end');
    register_setting('virical_smart_solutions_options', 'smart_hero_use_gradient');
}

// Admin page
function virical_smart_solutions_page() {
    wp_enqueue_media();
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');
    ?>
    <div class="wrap">
        <h1>Cài Đặt Trang Giải Pháp Thông Minh</h1>
        
        <form method="post" action="options.php">
            <?php settings_fields('virical_smart_solutions_options'); ?>
            <?php do_settings_sections('virical_smart_solutions_options'); ?>
            
            <div class="card" style="max-width: 800px; margin-top: 20px; padding: 20px;">
                <h2>Hero Section (Banner Đầu Trang)</h2>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">Hình nền Hero</th>
                        <td>
                            <input type="text" id="smart_hero_bg_image" name="smart_hero_bg_image" class="regular-text" value="<?php echo esc_attr(get_option('smart_hero_bg_image')); ?>" placeholder="URL hình ảnh">
                            <button type="button" class="button smart-upload-btn" data-target="smart_hero_bg_image">Chọn Hình</button>
                            <p class="description">Hình nền cho hero section. Để trống để dùng hình mặc định.</p>
                            <div id="smart_hero_bg_image_preview" style="margin-top: 10px;">
                                <?php if (get_option('smart_hero_bg_image')): ?>
                                    <img src="<?php echo esc_url(get_option('smart_hero_bg_image')); ?>" style="max-width: 300px; border: 1px solid #ddd;">
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">Sử dụng màu nền gradient</th>
                        <td>
                            <label>
                                <input type="checkbox" name="smart_hero_use_gradient" value="1" <?php checked(get_option('smart_hero_use_gradient', '0'), '1'); ?>>
                                Bật gradient (tắt để dùng nền trong suốt/trắng)
                            </label>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">Màu gradient bắt đầu</th>
                        <td>
                            <input type="text" id="smart_hero_gradient_start" name="smart_hero_gradient_start" class="color-picker" value="<?php echo esc_attr(get_option('smart_hero_gradient_start', '#ffffff')); ?>">
                            <p class="description">Màu đầu tiên của gradient (mặc định: trắng #ffffff)</p>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">Màu gradient kết thúc</th>
                        <td>
                            <input type="text" id="smart_hero_gradient_end" name="smart_hero_gradient_end" class="color-picker" value="<?php echo esc_attr(get_option('smart_hero_gradient_end', '#f5f5f5')); ?>">
                            <p class="description">Màu cuối cùng của gradient (mặc định: xám nhạt #f5f5f5)</p>
                        </td>
                    </tr>
                </table>
                
                <?php submit_button('Lưu Cài Đặt'); ?>
            </div>
        </form>
    </div>
    
    <script>
    jQuery(document).ready(function($){
        // Color picker
        $('.color-picker').wpColorPicker();
        
        // Media uploader
        $('.smart-upload-btn').click(function(e) {
            e.preventDefault();
            var target = $(this).data('target');
            var frame = wp.media({ 
                title: 'Chọn Hình Ảnh',
                multiple: false
            }).open()
            .on('select', function(){
                var attachment = frame.state().get('selection').first().toJSON();
                $('#' + target).val(attachment.url);
                $('#' + target + '_preview').html('<img src="'+attachment.url+'" style="max-width: 300px; border: 1px solid #ddd;">');
            });
        });
    });
    </script>
    <?php
}
?>
