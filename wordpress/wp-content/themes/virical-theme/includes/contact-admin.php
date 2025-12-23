<?php
/**
 * Contact Admin Manager
 * Handles hero image settings and contact form submissions
 */

if (!defined('ABSPATH')) {
    exit;
}

class Contact_Admin_Manager {
    private $table_name;

    public function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'contact_submissions';

        add_action('admin_menu', [$this, 'add_contact_menu']);
        add_action('admin_init', [$this, 'register_settings']);
        add_action('admin_init', [$this, 'create_table']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_scripts']);
        
        // AJAX handlers
        add_action('wp_ajax_submit_contact_form', [$this, 'handle_contact_submission']);
        add_action('wp_ajax_nopriv_submit_contact_form', [$this, 'handle_contact_submission']);
    }

    /**
     * Enqueue admin scripts for media uploader
     */
    public function enqueue_admin_scripts($hook) {
        if ($hook === 'contact_page_contact-settings') {
            wp_enqueue_media();
        }
    }

    /**
     * Create table for contact submissions
     */
    public function create_table() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        // dbDelta requires specific formatting: 2 spaces after PRIMARY KEY, each field on new line
        $sql = "CREATE TABLE {$this->table_name} (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name varchar(100) NOT NULL,
            email varchar(100) NOT NULL,
            phone varchar(20),
            subject varchar(255),
            message text NOT NULL,
            submitted_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            status varchar(20) DEFAULT 'new',
            PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        // Explicit fallback check: If column is missing, force add it
        // This handles cases where dbDelta might fail silently or table exists with old schema
        $column_check = $wpdb->get_results("SHOW COLUMNS FROM {$this->table_name} LIKE 'submitted_at'");
        if (empty($column_check)) {
            $wpdb->query("ALTER TABLE {$this->table_name} ADD COLUMN submitted_at datetime DEFAULT CURRENT_TIMESTAMP");
        }
    }

    /**
     * Add menu items to admin
     */
    public function add_contact_menu() {
        // Main Contact menu
        add_menu_page(
            'Liên Hệ',
            'Liên Hệ',
            'manage_options',
            'contact-management',
            [$this, 'render_submissions_page'],
            'dashicons-email-alt',
            27
        );

        add_submenu_page(
            'contact-management',
            'Tin Nhắn',
            'Tin Nhắn',
            'manage_options',
            'contact-management',
            [$this, 'render_submissions_page']
        );

        add_submenu_page(
            'contact-management',
            'Cài đặt Trang Liên Hệ',
            'Cài đặt',
            'manage_options',
            'contact-settings',
            [$this, 'render_settings_page']
        );
    }

    /**
     * Register settings for Contact Page
     */
    public function register_settings() {
        register_setting('contact_settings_group', 'contact_hero_image');
        register_setting('contact_settings_group', 'contact_address');
        register_setting('contact_settings_group', 'contact_phone');
        register_setting('contact_settings_group', 'contact_hotline');
        register_setting('contact_settings_group', 'contact_email');
        register_setting('contact_settings_group', 'contact_working_hours');
    }

    /**
     * Render settings page
     */
    public function render_settings_page() {
        ?>
        <div class="wrap">
            <h1>Cài đặt Trang Liên Hệ</h1>
            <form method="post" action="options.php">
                <?php settings_fields('contact_settings_group'); ?>
                <?php do_settings_sections('contact_settings_group'); ?>
                <table class="form-table">
                    <tr>
                        <th scope="row">Hình nền Hero (URL)</th>
                        <td>
                            <input type="text" name="contact_hero_image" id="contact_hero_image" value="<?php echo esc_attr(get_option('contact_hero_image')); ?>" class="regular-text">
                            <button type="button" class="button select-image-button">Chọn hình</button>
                            <p class="description">Đường dẫn hình ảnh hiển thị ở phần đầu trang liên hệ.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Địa chỉ</th>
                        <td>
                            <input type="text" name="contact_address" value="<?php echo esc_attr(get_option('contact_address', 'No.31 Sunrise D, The Manor central park, Hoàng Mai, Hà Nội')); ?>" class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Điện thoại (TEL)</th>
                        <td>
                            <input type="text" name="contact_phone" value="<?php echo esc_attr(get_option('contact_phone', '024.6658.2588')); ?>" class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Hotline</th>
                        <td>
                            <input type="text" name="contact_hotline" value="<?php echo esc_attr(get_option('contact_hotline', '0963.954.969')); ?>" class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Email</th>
                        <td>
                            <input type="email" name="contact_email" value="<?php echo esc_attr(get_option('contact_email', 'info@auralighting.vn')); ?>" class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Giờ làm việc</th>
                        <td>
                            <textarea name="contact_working_hours" rows="4" class="regular-text"><?php echo esc_textarea(get_option('contact_working_hours', "Thứ 2 - Thứ 6: 8:00 - 17:30\nThứ 7: 8:00 - 12:00\nChủ nhật: Nghỉ")); ?></textarea>
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <script>
            jQuery(document).ready(function($){
                $('.select-image-button').click(function(e) {
                    e.preventDefault();
                    var custom_uploader = wp.media({
                        title: 'Chọn Hình Hero',
                        button: {
                            text: 'Sử dụng hình này'
                        },
                        multiple: false
                    }).on('select', function() {
                        var attachment = custom_uploader.state().get('selection').first().toJSON();
                        $('#contact_hero_image').val(attachment.url);
                    }).open();
                });
            });
        </script>
        <?php
    }

    /**
     * Render submissions list page
     */
    public function render_submissions_page() {
        global $wpdb;
        // Check for column existence before query to avoid error
        $column_check = $wpdb->get_results("SHOW COLUMNS FROM {$this->table_name} LIKE 'submitted_at'");
        
        if (empty($column_check)) {
             // Try to fix it right here if it's missing (belt and suspenders)
             $wpdb->query("ALTER TABLE {$this->table_name} ADD COLUMN submitted_at datetime DEFAULT CURRENT_TIMESTAMP");
        }

        $submissions = $wpdb->get_results("SELECT * FROM {$this->table_name} ORDER BY submitted_at DESC");
        ?>
        <div class="wrap">
            <h1>Tin Nhắn Từ Khách Hàng</h1>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th width="150">Ngày gửi</th>
                        <th width="150">Họ và tên</th>
                        <th width="150">Số điện thoại</th>
                        <th width="200">Email</th>
                        <th>Nội dung</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($submissions): ?>
                        <?php foreach ($submissions as $item): ?>
                            <tr>
                                <td><?php echo esc_html($item->submitted_at); ?></td>
                                <td><?php echo esc_html($item->name); ?></td>
                                <td><?php echo esc_html($item->phone); ?></td>
                                <td><?php echo esc_html($item->email); ?></td>
                                <td>
                                    <strong><?php echo esc_html($item->subject); ?></strong><br>
                                    <?php echo nl2br(esc_html($item->message)); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">Chưa có tin nhắn nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php
    }

    /**
     * Handle Contact Form Submission via AJAX
     */
    public function handle_contact_submission() {
        check_ajax_referer('contact_form_nonce', 'nonce');

        global $wpdb;
        $name = sanitize_text_field($_POST['name']);
        $email = sanitize_email($_POST['email']);
        $phone = sanitize_text_field($_POST['phone']);
        $subject = sanitize_text_field($_POST['subject']);
        $message = sanitize_textarea_field($_POST['message']);

        if (empty($name) || empty($email) || empty($message)) {
            wp_send_json_error(['message' => 'Vui lòng điền đầy đủ thông tin bắt buộc.']);
        }

        $result = $wpdb->insert(
            $this->table_name,
            [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'subject' => $subject,
                'message' => $message,
                'submitted_at' => current_time('mysql')
            ]
        );

        if ($result) {
            wp_send_json_success(['message' => 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm nhất.']);
        } else {
            wp_send_json_error(['message' => 'Có lỗi xảy ra, vui lòng thử lại sau.']);
        }
    }
}

new Contact_Admin_Manager();