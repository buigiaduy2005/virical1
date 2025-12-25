<?php
/**
 * About Page Admin Settings
 * 
 * @package Virical
 */

// Register settings
function aura_about_page_register_settings() {
    // Hero section
    register_setting('aura_about_page_settings', 'aura_about_hero_image');
    register_setting('aura_about_page_settings', 'aura_about_hero_title');
    register_setting('aura_about_page_settings', 'aura_about_hero_subtitle');
    
    // Introduction section
    register_setting('aura_about_page_settings', 'aura_about_intro_title');
    register_setting('aura_about_page_settings', 'aura_about_intro_content');
    register_setting('aura_about_page_settings', 'aura_about_intro_image');
    
    // Story sections
    register_setting('aura_about_page_settings', 'aura_about_story_sections');
    
    // Company values
    register_setting('aura_about_page_settings', 'aura_about_company_values');
    
    // Team members
    register_setting('aura_about_page_settings', 'aura_about_team_members');
    
    // Achievements
    register_setting('aura_about_page_settings', 'aura_about_achievements');
    
    // Partners
    register_setting('aura_about_page_settings', 'aura_about_partners');
}
add_action('admin_init', 'aura_about_page_register_settings');

// Add admin menu
function aura_about_page_admin_menu() {
    add_menu_page(
        'About Page Settings',
        'About Page',
        'manage_options',
        'aura-about-page',
        'aura_about_page_admin_page',
        'dashicons-info',
        30
    );
}
add_action('admin_menu', 'aura_about_page_admin_menu');

// Admin page content
function aura_about_page_admin_page() {
    // Handle form submission
    if (isset($_POST['submit'])) {
        // Save hero section
        update_option('aura_about_hero_image', sanitize_text_field($_POST['hero_image']));
        update_option('aura_about_hero_title', sanitize_text_field($_POST['hero_title']));
        update_option('aura_about_hero_subtitle', sanitize_text_field($_POST['hero_subtitle']));
        
        // Save introduction section
        update_option('aura_about_intro_title', sanitize_text_field($_POST['intro_title']));
        update_option('aura_about_intro_content', wp_kses_post($_POST['intro_content']));
        update_option('aura_about_intro_image', esc_url_raw($_POST['intro_image']));
        
        // Save story sections
        $story_sections = array();
        if (isset($_POST['story_sections'])) {
            foreach ($_POST['story_sections'] as $section) {
                $story_sections[] = array(
                    'title' => sanitize_text_field($section['title']),
                    'content' => wp_kses_post($section['content']),
                    'image' => esc_url_raw($section['image'])
                );
            }
        }
        update_option('aura_about_story_sections', $story_sections);
        
        // Save company values
        $company_values = array();
        if (isset($_POST['company_values'])) {
            foreach ($_POST['company_values'] as $value) {
                $company_values[] = array(
                    'icon' => sanitize_text_field($value['icon']),
                    'title' => sanitize_text_field($value['title']),
                    'description' => sanitize_textarea_field($value['description'])
                );
            }
        }
        update_option('aura_about_company_values', $company_values);
        
        // Save team members
        $team_members = array();
        if (isset($_POST['team_members'])) {
            foreach ($_POST['team_members'] as $member) {
                $team_members[] = array(
                    'photo' => esc_url_raw($member['photo']),
                    'name' => sanitize_text_field($member['name']),
                    'position' => sanitize_text_field($member['position']),
                    'bio' => sanitize_textarea_field($member['bio']),
                    'facebook' => esc_url_raw($member['facebook'] ?? ''),
                    'linkedin' => esc_url_raw($member['linkedin'] ?? '')
                );
            }
        }
        update_option('aura_about_team_members', $team_members);
        
        // Save achievements
        $achievements = array();
        if (isset($_POST['achievements'])) {
            foreach ($_POST['achievements'] as $achievement) {
                $achievements[] = array(
                    'number' => intval($achievement['number']),
                    'suffix' => sanitize_text_field($achievement['suffix'] ?? ''),
                    'title' => sanitize_text_field($achievement['title']),
                    'description' => sanitize_text_field($achievement['description'])
                );
            }
        }
        update_option('aura_about_achievements', $achievements);
        
        // Save partners
        $partners = array();
        if (isset($_POST['partners'])) {
            foreach ($_POST['partners'] as $partner) {
                $partners[] = array(
                    'name' => sanitize_text_field($partner['name']),
                    'logo' => esc_url_raw($partner['logo'])
                );
            }
        }
        update_option('aura_about_partners', $partners);
        
        echo '<div class="notice notice-success"><p>Cài đặt đã được lưu!</p></div>';
    }
    
    // Get current values
    $hero_image = get_option('aura_about_hero_image', '');
    $hero_title = get_option('aura_about_hero_title', 'CHÚNG TÔI');
    $hero_subtitle = get_option('aura_about_hero_subtitle', 'Virical - Feeling Light');
    $intro_title = get_option('aura_about_intro_title', 'VỀ VIRICAL');
    $intro_content = get_option('aura_about_intro_content', 'Virical là công ty chuyên thiết kế và cung cấp giải pháp chiếu sáng cao cấp cho các công trình kiến trúc, nội thất tại Việt Nam.');
    $intro_image = get_option('aura_about_intro_image', '');
    $story_sections = get_option('aura_about_story_sections', array());
    $company_values = get_option('aura_about_company_values', array());
    $team_members = get_option('aura_about_team_members', array());
    $achievements = get_option('aura_about_achievements', array());
    $partners = get_option('aura_about_partners', array());
    
    // Enqueue media uploader
    wp_enqueue_media();
    ?>
    
    <style>
        .about-admin-container { max-width: 1200px; }
        .about-section-card { background: #fff; border: 1px solid #ccd0d4; padding: 20px; margin-bottom: 30px; border-radius: 4px; box-shadow: 0 1px 1px rgba(0,0,0,.04); }
        .about-section-card h2 { margin-top: 0; padding-bottom: 10px; border-bottom: 1px solid #eee; margin-bottom: 20px; }
        .dynamic-item { background: #f9f9f9; border: 1px solid #ddd; padding: 20px; margin-bottom: 20px; position: relative; border-radius: 4px; }
        .dynamic-item h3 { margin-top: 0; background: #eee; padding: 10px; margin: -20px -20px 20px -20px; border-radius: 4px 4px 0 0; }
        .remove-item-btn { position: absolute; top: 10px; right: 10px; color: #a00; cursor: pointer; text-decoration: none; font-weight: bold; }
        .remove-item-btn:hover { color: #f00; }
        .image-preview { max-width: 200px; max-height: 150px; display: block; margin-top: 10px; border: 1px solid #ddd; background: #fff; padding: 5px; }
        .image-preview:empty { display: none; }
        .image-preview img { max-width: 100%; height: auto; display: block; }
    </style>
    
    <div class="wrap about-admin-container">
        <h1>Quản Lý Trang Giới Thiệu</h1>
        
        <form method="post" action="">
            <?php wp_nonce_field('aura_about_page_settings'); ?>
            
            <!-- Hero Section -->
            <div class="about-section-card">
                <h2>1. Phần Đầu Trang (Hero)</h2>
                <table class="form-table">
                    <tr>
                        <th><label for="hero_image">Hình nền Hero</label></th>
                        <td>
                            <input type="text" id="hero_image" name="hero_image" value="<?php echo esc_url($hero_image); ?>" class="regular-text" />
                            <button type="button" class="button upload-image-button">Chọn ảnh</button>
                            <div class="image-preview"><?php if($hero_image) echo '<img src="'.$hero_image.'">'; ?></div>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="hero_title">Tiêu đề chính</label></th>
                        <td><input type="text" id="hero_title" name="hero_title" value="<?php echo esc_attr($hero_title); ?>" class="regular-text" /></td>
                    </tr>
                    <tr>
                        <th><label for="hero_subtitle">Tiêu đề phụ</label></th>
                        <td><input type="text" id="hero_subtitle" name="hero_subtitle" value="<?php echo esc_attr($hero_subtitle); ?>" class="regular-text" /></td>
                    </tr>
                </table>
            </div>
            
            <!-- Introduction Section -->
            <div class="about-section-card">
                <h2>2. Phần Giới Thiệu Chung</h2>
                <table class="form-table">
                    <tr>
                        <th><label for="intro_title">Tiêu đề</label></th>
                        <td><input type="text" id="intro_title" name="intro_title" value="<?php echo esc_attr($intro_title); ?>" class="regular-text" /></td>
                    </tr>
                    <tr>
                        <th><label for="intro_content">Nội dung</label></th>
                        <td>
                            <?php 
                            wp_editor($intro_content, 'intro_content', array(
                                'textarea_name' => 'intro_content',
                                'textarea_rows' => 10,
                                'media_buttons' => true
                            ));
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="intro_image">Hình ảnh giới thiệu</label></th>
                        <td>
                            <input type="text" id="intro_image" name="intro_image" value="<?php echo esc_url($intro_image); ?>" class="regular-text" />
                            <button type="button" class="button upload-image-button">Chọn ảnh</button>
                            <div class="image-preview"><?php if($intro_image) echo '<img src="'.$intro_image.'">'; ?></div>
                        </td>
                    </tr>
                </table>
            </div>
            
            <!-- Story Sections -->
            <div class="about-section-card">
                <h2>3. Các Câu Chuyện / Khối Nội Dung (Xen kẽ)</h2>
                <div id="story-sections-container">
                    <?php 
                    foreach ($story_sections as $index => $section): 
                    ?>
                    <div class="dynamic-item">
                        <a href="#" class="remove-item-btn remove-section">Xóa khối này</a>
                        <h3>Khối nội dung <?php echo $index + 1; ?></h3>
                        <table class="form-table">
                            <tr>
                                <th>Tiêu đề</th>
                                <td><input type="text" name="story_sections[<?php echo $index; ?>][title]" value="<?php echo esc_attr($section['title']); ?>" class="regular-text" /></td>
                            </tr>
                            <tr>
                                <th>Nội dung</th>
                                <td><textarea name="story_sections[<?php echo $index; ?>][content]" rows="5" class="large-text"><?php echo esc_textarea($section['content']); ?></textarea></td>
                            </tr>
                            <tr>
                                <th>Hình ảnh</th>
                                <td>
                                    <input type="text" name="story_sections[<?php echo $index; ?>][image]" value="<?php echo esc_url($section['image']); ?>" class="regular-text" />
                                    <button type="button" class="button upload-image-button">Chọn ảnh</button>
                                    <div class="image-preview"><?php if(!empty($section['image'])) echo '<img src="'.$section['image'].'">'; ?></div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="button button-primary" id="add-story-section">+ Thêm khối nội dung mới</button>
            </div>
            
            <!-- Company Values -->
            <div class="about-section-card">
                <h2>4. Giá Trị Cốt Lõi</h2>
                <div id="values-container">
                    <?php 
                    foreach ($company_values as $index => $value): 
                    ?>
                    <div class="dynamic-item">
                        <a href="#" class="remove-item-btn remove-value">Xóa</a>
                        <table class="form-table">
                            <tr>
                                <th>Icon Class</th>
                                <td>
                                    <input type="text" name="company_values[<?php echo $index; ?>][icon]" value="<?php echo esc_attr($value['icon']); ?>" class="regular-text" />
                                </td>
                            </tr>
                            <tr>
                                <th>Tiêu đề</th>
                                <td><input type="text" name="company_values[<?php echo $index; ?>][title]" value="<?php echo esc_attr($value['title']); ?>" class="regular-text" /></td>
                            </tr>
                            <tr>
                                <th>Mô tả</th>
                                <td><textarea name="company_values[<?php echo $index; ?>][description]" rows="3" class="large-text"><?php echo esc_textarea($value['description']); ?></textarea></td>
                            </tr>
                        </table>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="button button-primary" id="add-value">+ Thêm giá trị mới</button>
            </div>
            
            <!-- Team Members -->
            <div class="about-section-card">
                <h2>5. Đội Ngũ Nhân Sự</h2>
                <div id="team-container">
                    <?php 
                    foreach ($team_members as $index => $member): 
                    ?>
                    <div class="dynamic-item">
                        <a href="#" class="remove-item-btn remove-member">Xóa nhân sự</a>
                        <table class="form-table">
                            <tr>
                                <th>Ảnh chân dung</th>
                                <td>
                                    <input type="text" name="team_members[<?php echo $index; ?>][photo]" value="<?php echo esc_url($member['photo']); ?>" class="regular-text" />
                                    <button type="button" class="button upload-image-button">Chọn ảnh</button>
                                    <div class="image-preview"><?php if(!empty($member['photo'])) echo '<img src="'.$member['photo'].'">'; ?></div>
                                </td>
                            </tr>
                            <tr>
                                <th>Họ tên</th>
                                <td><input type="text" name="team_members[<?php echo $index; ?>][name]" value="<?php echo esc_attr($member['name']); ?>" class="regular-text" /></td>
                            </tr>
                            <tr>
                                <th>Chức vụ</th>
                                <td><input type="text" name="team_members[<?php echo $index; ?>][position]" value="<?php echo esc_attr($member['position']); ?>" class="regular-text" /></td>
                            </tr>
                            <tr>
                                <th>Tiểu sử ngắn</th>
                                <td><textarea name="team_members[<?php echo $index; ?>][bio]" rows="3" class="large-text"><?php echo esc_textarea($member['bio']); ?></textarea></td>
                            </tr>
                        </table>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="button button-primary" id="add-member">+ Thêm nhân sự mới</button>
            </div>
            
            <!-- Partners -->
            <div class="about-section-card">
                <h2>6. Đối Tác</h2>
                <div id="partners-container">
                    <?php 
                    foreach ($partners as $index => $partner): 
                    ?>
                    <div class="dynamic-item">
                        <a href="#" class="remove-item-btn remove-partner">Xóa đối tác</a>
                        <table class="form-table">
                            <tr>
                                <th>Tên đối tác</th>
                                <td><input type="text" name="partners[<?php echo $index; ?>][name]" value="<?php echo esc_attr($partner['name']); ?>" class="regular-text" /></td>
                            </tr>
                            <tr>
                                <th>Logo</th>
                                <td>
                                    <input type="text" name="partners[<?php echo $index; ?>][logo]" value="<?php echo esc_url($partner['logo']); ?>" class="regular-text" />
                                    <button type="button" class="button upload-image-button">Chọn logo</button>
                                    <div class="image-preview"><?php if(!empty($partner['logo'])) echo '<img src="'.$partner['logo'].'">'; ?></div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="button button-primary" id="add-partner">+ Thêm đối tác mới</button>
            </div>
            
            <p class="submit">
                <input type="submit" name="submit" class="button button-primary" value="Lưu Tất Cả Thay Đổi" />
            </p>
        </form>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        // Media uploader
        $(document).on('click', '.upload-image-button', function(e) {
            e.preventDefault();
            var button = $(this);
            var target = button.prev('input');
            var preview = button.next('.image-preview');
            
            var frame = wp.media({
                title: 'Chọn Hình Ảnh',
                button: { text: 'Sử dụng hình này' },
                multiple: false
            });
            
            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                target.val(attachment.url);
                preview.html('<img src="' + attachment.url + '">').show();
            });
            
            frame.open();
        });
        
        // Add dynamic sections
        $('#add-story-section').on('click', function() {
            var index = $('#story-sections-container .dynamic-item').length;
            var html = '<div class="dynamic-item">' +
                '<a href="#" class="remove-item-btn remove-section">Xóa khối này</a>' +
                '<h3>Khối nội dung mới</h3>' +
                '<table class="form-table">' +
                '<tr><th>Tiêu đề</th><td><input type="text" name="story_sections[' + index + '][title]" class="regular-text" /></td></tr>' +
                '<tr><th>Nội dung</th><td><textarea name="story_sections[' + index + '][content]" rows="5" class="large-text"></textarea></td></tr>' +
                '<tr><th>Hình ảnh</th><td><input type="text" name="story_sections[' + index + '][image]" class="regular-text" /><button type="button" class="button upload-image-button">Chọn ảnh</button><div class="image-preview"></div></td></tr>' +
                '</table></div>';
            $('#story-sections-container').append(html);
        });
        
        $('#add-value').on('click', function() {
            var index = $('#values-container .dynamic-item').length;
            var html = '<div class="dynamic-item"><a href="#" class="remove-item-btn remove-value">Xóa</a>' +
                '<table class="form-table">' +
                '<tr><th>Icon Class</th><td><input type="text" name="company_values[' + index + '][icon]" value="fas fa-lightbulb" class="regular-text" /></td></tr>' +
                '<tr><th>Tiêu đề</th><td><input type="text" name="company_values[' + index + '][title]" class="regular-text" /></td></tr>' +
                '<tr><th>Mô tả</th><td><textarea name="company_values[' + index + '][description]" rows="3" class="large-text"></textarea></td></tr>' +
                '</table></div>';
            $('#values-container').append(html);
        });
        
        $('#add-member').on('click', function() {
            var index = $('#team-container .dynamic-item').length;
            var html = '<div class="dynamic-item"><a href="#" class="remove-item-btn remove-member">Xóa nhân sự</a>' +
                '<table class="form-table">' +
                '<tr><th>Ảnh chân dung</th><td><input type="text" name="team_members[' + index + '][photo]" class="regular-text" /><button type="button" class="button upload-image-button">Chọn ảnh</button><div class="image-preview"></div></td></tr>' +
                '<tr><th>Họ tên</th><td><input type="text" name="team_members[' + index + '][name]" class="regular-text" /></td></tr>' +
                '<tr><th>Chức vụ</th><td><input type="text" name="team_members[' + index + '][position]" class="regular-text" /></td></tr>' +
                '<tr><th>Tiểu sử ngắn</th><td><textarea name="team_members[' + index + '][bio]" rows="3" class="large-text"></textarea></td></tr>' +
                '</table></div>';
            $('#team-container').append(html);
        });
        
        $('#add-partner').on('click', function() {
            var index = $('#partners-container .dynamic-item').length;
            var html = '<div class="dynamic-item"><a href="#" class="remove-item-btn remove-partner">Xóa đối tác</a>' +
                '<table class="form-table">' +
                '<tr><th>Tên đối tác</th><td><input type="text" name="partners[' + index + '][name]" class="regular-text" /></td></tr>' +
                '<tr><th>Logo</th><td><input type="text" name="partners[' + index + '][logo]" class="regular-text" /><button type="button" class="button upload-image-button">Chọn logo</button><div class="image-preview"></div></td></tr>' +
                '</table></div>';
            $('#partners-container').append(html);
        });
        
        // Remove buttons
        $(document).on('click', '.remove-item-btn', function(e) {
            e.preventDefault();
            if (confirm('Bạn có chắc chắn muốn xóa mục này?')) {
                $(this).closest('.dynamic-item').remove();
            }
        });
    });
    </script>
    <?php
}