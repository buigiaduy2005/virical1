<?php
/**
 * Footer Admin Manager
 * Manages all 5 sections of the footer
 */

if (!defined('ABSPATH')) {
    exit;
}

class Virical_Footer_Manager {

    public function __construct() {
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_init', [$this, 'register_settings']);
    }

    public function add_admin_menu() {
        add_menu_page(
            'Quản Lý Footer',
            'Quản Lý Footer',
            'manage_options',
            'virical-footer-manager',
            [$this, 'render_settings_page'],
            'dashicons-layout',
            60
        );
    }

    public function register_settings() {
        // Section 1: About & Socials
        register_setting('virical_footer_group', 'virical_footer_desc');
        register_setting('virical_footer_group', 'virical_social_facebook');
        register_setting('virical_footer_group', 'virical_social_youtube');
        register_setting('virical_footer_group', 'virical_social_zalo');
        register_setting('virical_footer_group', 'virical_social_instagram');
        register_setting('virical_footer_group', 'virical_social_linkedin');

        // Section 2: Menu 1 (Products)
        register_setting('virical_footer_group', 'virical_footer_menu1_title');
        for ($i = 1; $i <= 6; $i++) {
            register_setting('virical_footer_group', "virical_footer_menu1_text_$i");
            register_setting('virical_footer_group', "virical_footer_menu1_url_$i");
        }

        // Section 3: Menu 2 (Info)
        register_setting('virical_footer_group', 'virical_footer_menu2_title');
        for ($i = 1; $i <= 6; $i++) {
            register_setting('virical_footer_group', "virical_footer_menu2_text_$i");
            register_setting('virical_footer_group', "virical_footer_menu2_url_$i");
        }

        // Section 4: Contact & Newsletter
        register_setting('virical_footer_group', 'virical_footer_contact_title');
        register_setting('virical_footer_group', 'virical_footer_address');
        register_setting('virical_footer_group', 'virical_footer_phone');
        register_setting('virical_footer_group', 'virical_footer_email');
        register_setting('virical_footer_group', 'virical_footer_newsletter_title');

        // Section 5: Bottom
        register_setting('virical_footer_group', 'virical_footer_copyright');
        for ($i = 1; $i <= 3; $i++) {
            register_setting('virical_footer_group', "virical_footer_bottom_text_$i");
            register_setting('virical_footer_group', "virical_footer_bottom_url_$i");
        }
    }

    public function render_settings_page() {
        $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'section1';
        ?>
        <div class="wrap">
            <h1>Quản Lý Footer</h1>
            
            <h2 class="nav-tab-wrapper">
                <a href="?page=virical-footer-manager&tab=section1" class="nav-tab <?php echo $active_tab == 'section1' ? 'nav-tab-active' : ''; ?>">1. Giới Thiệu & Social</a>
                <a href="?page=virical-footer-manager&tab=section2" class="nav-tab <?php echo $active_tab == 'section2' ? 'nav-tab-active' : ''; ?>">2. Menu Sản Phẩm</a>
                <a href="?page=virical-footer-manager&tab=section3" class="nav-tab <?php echo $active_tab == 'section3' ? 'nav-tab-active' : ''; ?>">3. Menu Thông Tin</a>
                <a href="?page=virical-footer-manager&tab=section4" class="nav-tab <?php echo $active_tab == 'section4' ? 'nav-tab-active' : ''; ?>">4. Liên Hệ</a>
                <a href="?page=virical-footer-manager&tab=section5" class="nav-tab <?php echo $active_tab == 'section5' ? 'nav-tab-active' : ''; ?>">5. Cuối Trang (Bottom)</a>
            </h2>

            <form method="post" action="options.php">
                <?php
                settings_fields('virical_footer_group');
                
                switch ($active_tab) {
                    case 'section1':
                        $this->render_section1();
                        break;
                    case 'section2':
                        $this->render_menu_section(1, 'Menu Sản Phẩm', 'virical_footer_menu1');
                        break;
                    case 'section3':
                        $this->render_menu_section(2, 'Menu Thông Tin', 'virical_footer_menu2');
                        break;
                    case 'section4':
                        $this->render_section4();
                        break;
                    case 'section5':
                        $this->render_section5();
                        break;
                }
                
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    private function render_section1() {
        ?>
        <h3>Thông Tin Giới Thiệu (Cột 1)</h3>
        <table class="form-table">
            <tr>
                <th scope="row">Mô tả công ty</th>
                <td>
                    <textarea name="virical_footer_desc" rows="5" class="large-text"><?php echo esc_textarea(get_option('virical_footer_desc', 'Thương hiệu đèn chiếu sáng hàng đầu Việt Nam với các giải pháp chiếu sáng thông minh và hiện đại.')); ?></textarea>
                    <p class="description">Hiển thị dưới logo ở chân trang.</p>
                </td>
            </tr>
            <tr>
                <th scope="row">Mạng Xã Hội</th>
                <td>
                    <p><label>Facebook URL:</label><br>
                    <input type="text" name="virical_social_facebook" value="<?php echo esc_attr(get_option('virical_social_facebook', '#')); ?>" class="regular-text"></p>
                    
                    <p><label>Youtube URL:</label><br>
                    <input type="text" name="virical_social_youtube" value="<?php echo esc_attr(get_option('virical_social_youtube', '#')); ?>" class="regular-text"></p>
                    
                    <p><label>Zalo URL:</label><br>
                    <input type="text" name="virical_social_zalo" value="<?php echo esc_attr(get_option('virical_social_zalo', 'https://zalo.me/virical')); ?>" class="regular-text"></p>
                    
                    <p><label>Instagram URL:</label><br>
                    <input type="text" name="virical_social_instagram" value="<?php echo esc_attr(get_option('virical_social_instagram', '#')); ?>" class="regular-text"></p>
                    
                    <p><label>LinkedIn URL:</label><br>
                    <input type="text" name="virical_social_linkedin" value="<?php echo esc_attr(get_option('virical_social_linkedin', '#')); ?>" class="regular-text"></p>
                </td>
            </tr>
        </table>
        <?php
    }

    private function render_menu_section($id, $default_title, $prefix) {
        ?>
        <h3>Cấu Hình <?php echo esc_html($default_title); ?></h3>
        <table class="form-table">
            <tr>
                <th scope="row">Tiêu đề cột</th>
                <td>
                    <input type="text" name="<?php echo $prefix; ?>_title" value="<?php echo esc_attr(get_option($prefix . '_title', $default_title)); ?>" class="regular-text">
                </td>
            </tr>
            <tr>
                <th scope="row">Danh sách liên kết</th>
                <td>
                    <?php for($i = 1; $i <= 6; $i++): ?>
                    <div style="margin-bottom: 15px; padding: 10px; background: #f9f9f9; border: 1px solid #ddd;">
                        <strong>Link <?php echo $i; ?></strong><br>
                        <label>Tên hiển thị:</label>
                        <input type="text" name="<?php echo $prefix; ?>_text_<?php echo $i; ?>" value="<?php echo esc_attr(get_option($prefix . "_text_$i")); ?>" class="regular-text"><br>
                        <label>Đường dẫn (URL):</label>
                        <input type="text" name="<?php echo $prefix; ?>_url_<?php echo $i; ?>" value="<?php echo esc_attr(get_option($prefix . "_url_$i")); ?>" class="regular-text">
                    </div>
                    <?php endfor; ?>
                </td>
            </tr>
        </table>
        <?php
    }

    private function render_section4() {
        ?>
        <h3>Thông Tin Liên Hệ (Cột 4)</h3>
        <table class="form-table">
            <tr>
                <th scope="row">Tiêu đề cột</th>
                <td>
                    <input type="text" name="virical_footer_contact_title" value="<?php echo esc_attr(get_option('virical_footer_contact_title', 'Liên Hệ')); ?>" class="regular-text">
                </td>
            </tr>
            <tr>
                <th scope="row">Địa chỉ</th>
                <td>
                    <textarea name="virical_footer_address" rows="3" class="regular-text"><?php echo esc_textarea(get_option('virical_footer_address', 'Số 30 Ngõ 100 Nguyễn Xiển, Thanh Xuân, Hà Nội, Việt Nam')); ?></textarea>
                </td>
            </tr>
            <tr>
                <th scope="row">Số điện thoại</th>
                <td>
                    <input type="text" name="virical_footer_phone" value="<?php echo esc_attr(get_option('virical_footer_phone', '0869995698')); ?>" class="regular-text">
                </td>
            </tr>
            <tr>
                <th scope="row">Email</th>
                <td>
                    <input type="text" name="virical_footer_email" value="<?php echo esc_attr(get_option('virical_footer_email', 'info@virical.vn')); ?>" class="regular-text">
                </td>
            </tr>
            <tr>
                <th scope="row">Tiêu đề Newsletter</th>
                <td>
                    <input type="text" name="virical_footer_newsletter_title" value="<?php echo esc_attr(get_option('virical_footer_newsletter_title', 'Đăng Ký Nhận Tin')); ?>" class="regular-text">
                </td>
            </tr>
        </table>
        <?php
    }

    private function render_section5() {
        ?>
        <h3>Chân Trang (Footer Bottom)</h3>
        <table class="form-table">
            <tr>
                <th scope="row">Bản quyền (Copyright)</th>
                <td>
                    <input type="text" name="virical_footer_copyright" value="<?php echo esc_attr(get_option('virical_footer_copyright', '© 2025 Virical. All Rights Reserved. | Designed by Virical Team')); ?>" class="large-text">
                </td>
            </tr>
            <tr>
                <th scope="row">Liên kết pháp lý</th>
                <td>
                    <?php for($i = 1; $i <= 3; $i++): ?>
                    <div style="margin-bottom: 15px;">
                        <input type="text" name="virical_footer_bottom_text_<?php echo $i; ?>" value="<?php echo esc_attr(get_option("virical_footer_bottom_text_$i")); ?>" placeholder="Tên Link <?php echo $i; ?>" style="width: 200px;">
                        <input type="text" name="virical_footer_bottom_url_<?php echo $i; ?>" value="<?php echo esc_attr(get_option("virical_footer_bottom_url_$i")); ?>" placeholder="URL Link <?php echo $i; ?>" style="width: 300px;">
                    </div>
                    <?php endfor; ?>
                    <p class="description">Ví dụ: Chính sách bảo mật, Điều khoản sử dụng...</p>
                </td>
            </tr>
        </table>
        <?php
    }
}

new Virical_Footer_Manager();
