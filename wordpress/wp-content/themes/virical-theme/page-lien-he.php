<?php
/**
 * Template Name: Contact Page New
 * Description: Trang Liên Hệ với thiết kế mới
 */

get_header();

// Get settings from admin
$hero_bg = get_option('contact_hero_image', get_template_directory_uri() . '/assets/images/canhocaocapvin.jpg');
$address = get_option('contact_address', 'No.31 Sunrise D, The Manor central park, Hoàng Mai, Hà Nội');
$phone = get_option('contact_phone', '024.6658.2588');
$hotline = get_option('contact_hotline', '0963.954.969');
$email = get_option('contact_email', 'info@auralighting.vn');
$working_hours = get_option('contact_working_hours', "Thứ 2 - Thứ 6: 8:00 - 17:30\nThứ 7: 8:00 - 12:00\nChủ nhật: Nghỉ");
?>

<div class="new-contact-page">
    <!-- Hero Section -->
    <section class="hero-section" style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('<?php echo esc_url($hero_bg); ?>') center/cover;">
        <div class="hero-content">
            <h1>LIÊN HỆ</h1>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="contact-container">
            <!-- Company Information -->
            <div class="company-info">
                <h2 class="info-title">Thông Tin Liên Hệ</h2>
                
                <div class="info-item">
                    <h3>📍 Địa Chỉ</h3>
                    <p><?php echo esc_html($address); ?></p>
                </div>

                <div class="info-item">
                    <h3>📞 Điện Thoại</h3>
                    <p>TEL: <?php echo esc_html($phone); ?><br>
                    Hotline: <?php echo esc_html($hotline); ?></p>
                </div>

                <div class="info-item">
                    <h3>✉️ Email</h3>
                    <p><?php echo esc_html($email); ?></p>
                </div>

                <div class="info-item">
                    <h3>🕒 Giờ Làm Việc</h3>
                    <p><?php echo nl2br(esc_html($working_hours)); ?></p>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="contact-form">
                <h2 class="form-title">Gửi Tin Nhắn Cho Chúng Tôi</h2>
                <form id="ajax-contact-form">
                    <?php wp_nonce_field('contact_form_nonce', 'nonce'); ?>
                    <div class="form-group">
                        <label for="name">Họ và Tên *</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Số Điện Thoại</label>
                        <input type="tel" id="phone" name="phone">
                    </div>
                    <div class="form-group">
                        <label for="subject">Chủ Đề</label>
                        <input type="text" id="subject" name="subject">
                    </div>
                    <div class="form-group">
                        <label for="message">Nội Dung *</label>
                        <textarea id="message" name="message" placeholder="Nhập nội dung tin nhắn của bạn..." required></textarea>
                    </div>
                    <div id="form-response"></div>
                    <button type="submit" class="submit-btn">GỬI TIN NHẮN</button>
                </form>
            </div>
        </div>
    </section>
</div>

<style>
    /* Reset some potential theme conflicts */
    .new-contact-page {
        font-family: 'Segoe UI', Roboto, Arial, sans-serif;
        background: #f8f9fa;
        color: #333;
        overflow-x: hidden;
    }

    /* Hero Section */
    .new-contact-page .hero-section {
        height: 60vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        margin-top: -32px; /* Offset potential padding from site-main */
    }
    .new-contact-page .hero-content h1 {
        font-size: 3rem;
        font-weight: 700;
        letter-spacing: 2px;
        color: #fff;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        margin: 0;
    }

    /* Contact Section */
    .new-contact-page .contact-section {
        padding: 80px 0;
        background: #fff;
    }
    .new-contact-page .contact-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 40px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 80px;
        align-items: start;
    }

    /* Contact Form */
    .new-contact-page .contact-form {
        background: #f8f9fa;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    .new-contact-page .form-title {
        font-size: 1.8rem;
        font-weight: 600;
        margin-bottom: 30px;
        color: #333;
    }
    .new-contact-page .form-group {
        margin-bottom: 25px;
    }
    .new-contact-page .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #555;
        text-align: left;
    }
    .new-contact-page .form-group input,
    .new-contact-page .form-group textarea {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 1rem;
        transition: border-color 0.2s ease;
    }
    .new-contact-page .form-group input:focus,
    .new-contact-page .form-group textarea:focus {
        outline: none;
        border-color: #ffd36a;
    }
    .new-contact-page .form-group textarea {
        height: 120px;
        resize: vertical;
    }
    .new-contact-page .submit-btn {
        background: #ff6b35;
        color: #fff;
        padding: 12px 30px;
        border: none;
        border-radius: 6px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s ease;
        width: 100%;
    }
    .new-contact-page .submit-btn:hover {
        background: #e55a2b;
    }
    .new-contact-page .submit-btn:disabled {
        background: #ccc;
        cursor: not-allowed;
    }

    /* Company Info */
    .new-contact-page .company-info {
        padding: 20px 0;
    }
    .new-contact-page .info-title {
        font-size: 1.8rem;
        font-weight: 600;
        margin-bottom: 30px;
        color: #333;
    }
    .new-contact-page .info-item {
        margin-bottom: 25px;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 8px;
        border-left: 4px solid #333;
        text-align: left;
    }
    .new-contact-page .info-item h3 {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 8px;
        color: #333;
        margin-top: 0;
    }
    .new-contact-page .info-item p {
        color: #666;
        line-height: 1.6;
        margin: 0;
    }
    
    #form-response {
        margin-bottom: 20px;
        padding: 10px;
        border-radius: 4px;
        display: none;
    }
    #form-response.success {
        background: #d4edda;
        color: #155724;
        display: block;
    }
    #form-response.error {
        background: #f8d7da;
        color: #721c24;
        display: block;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .new-contact-page .hero-content h1 { font-size: 2rem; }
        .new-contact-page .contact-container { grid-template-columns: 1fr; gap: 40px; padding: 0 20px; }
        .new-contact-page .contact-form { padding: 30px 20px; }
    }
</style>

<script>
jQuery(document).ready(function($) {
    $('#ajax-contact-form').on('submit', function(e) {
        e.preventDefault();
        
        var $form = $(this);
        var $submitBtn = $form.find('.submit-btn');
        var $response = $('#form-response');
        
        $submitBtn.prop('disabled', true).text('ĐANG GỬI...');
        $response.hide().removeClass('success error');
        
        var formData = {
            action: 'submit_contact_form',
            nonce: $('#nonce').val(),
            name: $('#name').val(),
            email: $('#email').val(),
            phone: $('#phone').val(),
            subject: $('#subject').val(),
            message: $('#message').val()
        };
        
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: formData,
            success: function(res) {
                if (res.success) {
                    $response.addClass('success').text(res.data.message).show();
                    $form[0].reset();
                } else {
                    $response.addClass('error').text(res.data.message).show();
                }
            },
            error: function() {
                $response.addClass('error').text('Có lỗi kết nối, vui lòng thử lại.').show();
            },
            complete: function() {
                $submitBtn.prop('disabled', false).text('GỬI TIN NHẮN');
            }
        });
    });
});
</script>

<?php get_footer(); ?>
