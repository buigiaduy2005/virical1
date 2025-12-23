<?php
/**
 * Top Banner Admin Settings
 * 
 * @package Virical
 */

// Register settings
function virical_top_banner_register_settings() {
    register_setting('virical_top_banner_settings', 'virical_top_banner_image');
    register_setting('virical_top_banner_settings', 'virical_top_banner_link');
    register_setting('virical_top_banner_settings', 'virical_top_banner_active');
    register_setting('virical_top_banner_settings', 'virical_top_banner_video');
    register_setting('virical_top_banner_settings', 'virical_top_banner_video_active');
    register_setting('virical_top_banner_settings', 'virical_top_banner_title');
    register_setting('virical_top_banner_settings', 'virical_top_banner_subtitle');
}
add_action('admin_init', 'virical_top_banner_register_settings');

// Add admin menu
function virical_top_banner_admin_menu() {
    add_menu_page(
        'Top Banner Settings',
        'Top Banner',
        'manage_options',
        'virical-top-banner',
        'virical_top_banner_admin_page',
        'dashicons-images-alt2'
    );
}
add_action('admin_menu', 'virical_top_banner_admin_menu');

// Debug notice
function virical_top_banner_debug_notice() {
    // Only show if page is not found in menu to avoid clutter
    // echo '<div class="notice notice-info"><p>Top Banner Admin File Loaded</p></div>';
}
add_action('admin_notices', 'virical_top_banner_debug_notice');

// Admin page content
function virical_top_banner_admin_page() {
    // Handle form submission
    if (isset($_POST['submit']) && check_admin_referer('virical_top_banner_settings')) {
        update_option('virical_top_banner_image', sanitize_text_field($_POST['top_banner_image']));
        update_option('virical_top_banner_link', esc_url_raw($_POST['top_banner_link']));
        update_option('virical_top_banner_video', esc_url_raw($_POST['top_banner_video']));
        update_option('virical_top_banner_title', sanitize_text_field($_POST['top_banner_title']));
        update_option('virical_top_banner_subtitle', sanitize_text_field($_POST['top_banner_subtitle']));
        update_option('virical_top_banner_active', isset($_POST['top_banner_active']) ? '1' : '0');
        
        echo '<div class="notice notice-success is-dismissible"><p>Settings saved!</p></div>';
    }
    
    // Get current values
    $image = get_option('virical_top_banner_image', '');
    $video = get_option('virical_top_banner_video', '');
    $title = get_option('virical_top_banner_title', 'VIRICAL');
    $subtitle = get_option('virical_top_banner_subtitle', 'FEELING LIGHT');
    $link = get_option('virical_top_banner_link', '');
    $active = get_option('virical_top_banner_active', '1');
    
    // Enqueue media uploader
    wp_enqueue_media();
    ?>
    
    <div class="wrap">
        <h1>Top Banner Settings</h1>
        <p>Manage the banner image/video displayed above the hero slider on the homepage.</p>
        
        <form method="post" action="">
            <?php wp_nonce_field('virical_top_banner_settings'); ?>
            
            <table class="form-table">
                <tr>
                    <th><label for="top_banner_active">Active Status</label></th>
                    <td>
                        <input type="checkbox" id="top_banner_active" name="top_banner_active" value="1" <?php checked($active, '1'); ?> />
                        <label for="top_banner_active">Show this banner on homepage</label>
                    </td>
                </tr>
                <tr>
                    <th><label for="top_banner_video">Banner Video (Optional)</label></th>
                    <td>
                        <input type="text" id="top_banner_video" name="top_banner_video" value="<?php echo esc_url($video); ?>" class="regular-text" />
                        <button type="button" class="button upload-video-button">Select Video</button>
                        <p class="description">Upload or select a video (MP4) for the top banner. If set, this will override the image.</p>
                    </td>
                </tr>
                <tr>
                    <th><label for="top_banner_title">Banner Title</label></th>
                    <td>
                        <input type="text" id="top_banner_title" name="top_banner_title" value="<?php echo esc_attr($title); ?>" class="regular-text" />
                        <p class="description">Main title text overlaid on the banner.</p>
                    </td>
                </tr>
                <tr>
                    <th><label for="top_banner_subtitle">Banner Subtitle</label></th>
                    <td>
                        <input type="text" id="top_banner_subtitle" name="top_banner_subtitle" value="<?php echo esc_attr($subtitle); ?>" class="regular-text" />
                        <p class="description">Subtitle text overlaid on the banner.</p>
                    </td>
                </tr>
                <tr>
                    <th><label for="top_banner_image">Banner Image</label></th>
                    <td>
                        <div class="banner-preview-wrapper" style="margin-bottom: 10px;">
                            <?php if ($image): ?>
                                <img src="<?php echo esc_url($image); ?>" id="banner-preview" style="max-width: 100%; height: auto; border: 1px solid #ccc; display: block; max-height: 200px;">
                            <?php else: ?>
                                <img src="" id="banner-preview" style="max-width: 100%; height: auto; border: 1px solid #ccc; display: none; max-height: 200px;">
                            <?php endif; ?>
                        </div>
                        <input type="text" id="top_banner_image" name="top_banner_image" value="<?php echo esc_url($image); ?>" class="regular-text" />
                        <button type="button" class="button upload-banner-button">Select Image</button>
                        <button type="button" class="button remove-banner-button" <?php echo !$image ? 'style="display:none;"' : ''; ?>>Remove</button>
                        <p class="description">Upload or select an image for the top banner. Recommended size: 1920x400px. Used as fallback if video fails or is not set.</p>
                    </td>
                </tr>
                <tr>
                    <th><label for="top_banner_link">Banner Link (Optional)</label></th>
                    <td>
                        <input type="url" id="top_banner_link" name="top_banner_link" value="<?php echo esc_url($link); ?>" class="regular-text" placeholder="https://..." />
                        <p class="description">Where should users be taken when they click the banner?</p>
                    </td>
                </tr>
            </table>
            
            <p class="submit">
                <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
            </p>
        </form>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        // Media uploader
        $('.upload-banner-button').on('click', function(e) {
            e.preventDefault();
            var button = $(this);
            
            var frame = wp.media({
                title: 'Select Banner Image',
                button: {
                    text: 'Use this image'
                },
                multiple: false
            });
            
            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                $('#top_banner_image').val(attachment.url);
                $('#banner-preview').attr('src', attachment.url).show();
                $('.remove-banner-button').show();
            });
            
            frame.open();
        });

        // Video uploader
        $('.upload-video-button').on('click', function(e) {
            e.preventDefault();
            
            var frame = wp.media({
                title: 'Select Banner Video',
                button: {
                    text: 'Use this video'
                },
                library: {
                    type: 'video'
                },
                multiple: false
            });
            
            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                $('#top_banner_video').val(attachment.url);
            });
            
            frame.open();
        });
        
        // Remove image
        $('.remove-banner-button').on('click', function() {
            $('#top_banner_image').val('');
            $('#banner-preview').hide().attr('src', '');
            $(this).hide();
        });
    });
    </script>
    <?php
}
