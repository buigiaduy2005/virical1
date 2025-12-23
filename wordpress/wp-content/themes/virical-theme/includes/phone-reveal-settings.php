<?php
/**
 * Virical Phone Reveal Admin Settings
 */

function virical_register_phone_reveal_settings() {
    add_menu_page(
        'Phone Effect',
        'Phone Effect',
        'manage_options',
        'virical-phone-reveal',
        'virical_render_phone_reveal_page',
        'dashicons-smartphone',
        25
    );

    register_setting('virical_phone_reveal_options', 'virical_phone_center_image');
    register_setting('virical_phone_reveal_options', 'virical_phone_bg_image');
    register_setting('virical_phone_reveal_options', 'virical_phone_center_logo'); // Center logo
    register_setting('virical_phone_reveal_active', 'virical_phone_reveal_active');

    // Register settings for 6 features (3 left, 3 right)
    for ($i = 1; $i <= 6; $i++) {
        register_setting('virical_phone_reveal_options', 'virical_phone_feat_' . $i . '_icon');
        register_setting('virical_phone_reveal_options', 'virical_phone_feat_' . $i . '_title');
        register_setting('virical_phone_reveal_options', 'virical_phone_feat_' . $i . '_desc');
        register_setting('virical_phone_reveal_options', 'virical_phone_feat_' . $i . '_link');
    }
}
add_action('admin_menu', 'virical_register_phone_reveal_settings');

function virical_render_phone_reveal_page() {
    // Enqueue media uploader
    wp_enqueue_media();
    ?>
    <div class="wrap">
        <h1>Phone Reveal 3D Effect Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('virical_phone_reveal_options'); ?>
            <?php do_settings_sections('virical_phone_reveal_options'); ?>

            <table class="form-table">
                <tr>
                    <th scope="row">Enable Section</th>
                    <td>
                        <input type="checkbox" name="virical_phone_reveal_active" value="1" <?php checked(get_option('virical_phone_reveal_active'), 1); ?> />
                    </td>
                </tr>
                <tr>
                    <th scope="row">Center Phone Image</th>
                    <td>
                        <input type="text" name="virical_phone_center_image" id="virical_phone_center_image" class="regular-text" value="<?php echo esc_attr(get_option('virical_phone_center_image')); ?>">
                        <button type="button" class="button virical-upload-btn" data-target="virical_phone_center_image">Upload Image</button>
                        <p class="description">Recommended: Transparent PNG, vertical orientation (e.g. 400x800px).</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Background Image (Optional)</th>
                    <td>
                        <input type="text" name="virical_phone_bg_image" id="virical_phone_bg_image" class="regular-text" value="<?php echo esc_attr(get_option('virical_phone_bg_image')); ?>">
                        <button type="button" class="button virical-upload-btn" data-target="virical_phone_bg_image">Upload Image</button>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Center Logo (Smart Home Icon)</th>
                    <td>
                        <input type="text" name="virical_phone_center_logo" id="virical_phone_center_logo" class="regular-text" value="<?php echo esc_attr(get_option('virical_phone_center_logo')); ?>">
                        <button type="button" class="button virical-upload-btn" data-target="virical_phone_center_logo">Upload Logo</button>
                        <p class="description">Logo hiển thị ở giữa khi features bung ra. Recommended: PNG 120x120px.</p>
                    </td>
                </tr>
            </table>

            <hr>
            <h2>Features (Left Side)</h2>
            <?php for ($i = 1; $i <= 3; $i++) : ?>
                <h3>Feature <?php echo $i; ?> (Left)</h3>
                <table class="form-table">
                    <tr>
                        <th scope="row">Icon URL</th>
                        <td>
                            <input type="text" name="virical_phone_feat_<?php echo $i; ?>_icon" id="virical_phone_feat_<?php echo $i; ?>_icon" class="regular-text" value="<?php echo esc_attr(get_option('virical_phone_feat_' . $i . '_icon')); ?>">
                            <button type="button" class="button virical-upload-btn" data-target="virical_phone_feat_<?php echo $i; ?>_icon">Upload</button>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Title</th>
                        <td><input type="text" name="virical_phone_feat_<?php echo $i; ?>_title" class="regular-text" value="<?php echo esc_attr(get_option('virical_phone_feat_' . $i . '_title')); ?>"></td>
                    </tr>
                    <tr>
                        <th scope="row">Description</th>
                        <td><textarea name="virical_phone_feat_<?php echo $i; ?>_desc" class="large-text" rows="2"><?php echo esc_textarea(get_option('virical_phone_feat_' . $i . '_desc')); ?></textarea></td>
                    </tr>
                    <tr>
                        <th scope="row">Link</th>
                        <td><input type="text" name="virical_phone_feat_<?php echo $i; ?>_link" class="regular-text" value="<?php echo esc_attr(get_option('virical_phone_feat_' . $i . '_link')); ?>"></td>
                    </tr>
                </table>
            <?php endfor; ?>

            <hr>
            <h2>Features (Right Side)</h2>
            <?php for ($i = 4; $i <= 6; $i++) : ?>
                <h3>Feature <?php echo $i; ?> (Right)</h3>
                <table class="form-table">
                    <tr>
                        <th scope="row">Icon URL</th>
                        <td>
                            <input type="text" name="virical_phone_feat_<?php echo $i; ?>_icon" id="virical_phone_feat_<?php echo $i; ?>_icon" class="regular-text" value="<?php echo esc_attr(get_option('virical_phone_feat_' . $i . '_icon')); ?>">
                            <button type="button" class="button virical-upload-btn" data-target="virical_phone_feat_<?php echo $i; ?>_icon">Upload</button>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Title</th>
                        <td><input type="text" name="virical_phone_feat_<?php echo $i; ?>_title" class="regular-text" value="<?php echo esc_attr(get_option('virical_phone_feat_' . $i . '_title')); ?>"></td>
                    </tr>
                    <tr>
                        <th scope="row">Description</th>
                        <td><textarea name="virical_phone_feat_<?php echo $i; ?>_desc" class="large-text" rows="2"><?php echo esc_textarea(get_option('virical_phone_feat_' . $i . '_desc')); ?></textarea></td>
                    </tr>
                    <tr>
                        <th scope="row">Link</th>
                        <td><input type="text" name="virical_phone_feat_<?php echo $i; ?>_link" class="regular-text" value="<?php echo esc_attr(get_option('virical_phone_feat_' . $i . '_link')); ?>"></td>
                    </tr>
                </table>
            <?php endfor; ?>

            <?php submit_button(); ?>
        </form>
    </div>

    <script>
    jQuery(document).ready(function($){
        $('.virical-upload-btn').click(function(e) {
            e.preventDefault();
            var targetField = $(this).data('target');
            var image = wp.media({ 
                title: 'Upload Image',
                multiple: false
            }).open()
            .on('select', function(e){
                var uploaded_image = image.state().get('selection').first();
                $('#' + targetField).val(uploaded_image.toJSON().url);
            });
        });
    });
    </script>
    <?php
}
?>