<?php
/**
 * The template for displaying the footer
 *
 * @package Virical
 */
?>

        </div><!-- .ast-container -->
    </div><!-- #content -->

    <footer id="colophon" class="site-footer" role="contentinfo">
        <div class="footer-main">
            <div class="ast-container">
                <div class="footer-content">
                    <!-- Section 1: Company Info -->
                    <div class="footer-widget footer-about">
                        <div class="footer-logo-wrapper" style="width: 200px !important; height: 60px !important; overflow: hidden !important; margin-bottom: 19px; position: relative; display: block;">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/virical-logo.svg' ); ?>" style="position: absolute !important; top: -589px !important; left: -282px !important; width: 497px !important; height: auto !important; max-width: none !important;"
                                 alt="<?php bloginfo( 'name' ); ?>">
                        </div>
                        <p><?php echo esc_html(get_option('virical_footer_desc', 'Thương hiệu đèn chiếu sáng hàng đầu Việt Nam với các giải pháp chiếu sáng thông minh và hiện đại.')); ?></p>
                        <div class="social-links">
                            <?php if($url = get_option('virical_social_facebook')): ?>
                            <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <?php endif; ?>
                            
                            <?php if($url = get_option('virical_social_youtube')): ?>
                            <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener">
                                <i class="fab fa-youtube"></i>
                            </a>
                            <?php endif; ?>
                            
                            <?php if($url = get_option('virical_social_zalo')): ?>
                            <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener" style="font-weight: bold; font-size: 18px;">
                                Z
                            </a>
                            <?php endif; ?>
                            
                            <?php if($url = get_option('virical_social_instagram')): ?>
                            <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <?php endif; ?>
                            
                            <?php if($url = get_option('virical_social_linkedin')): ?>
                            <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Section 2: Products Menu -->
                    <div class="footer-widget">
                        <h3><?php echo esc_html(get_option('virical_footer_menu1_title', 'Sản Phẩm')); ?></h3>
                        <ul>
                            <?php for($i=1; $i<=6; $i++): 
                                $text = get_option("virical_footer_menu1_text_$i");
                                $url = get_option("virical_footer_menu1_url_$i");
                                if($text && $url):
                            ?>
                            <li><a href="<?php echo esc_url($url); ?>"><?php echo esc_html($text); ?></a></li>
                            <?php endif; endfor; ?>
                        </ul>
                    </div>

                    <!-- Section 3: Information Menu -->
                    <div class="footer-widget">
                        <h3><?php echo esc_html(get_option('virical_footer_menu2_title', 'Thông Tin')); ?></h3>
                        <ul>
                            <?php for($i=1; $i<=6; $i++): 
                                $text = get_option("virical_footer_menu2_text_$i");
                                $url = get_option("virical_footer_menu2_url_$i");
                                if($text && $url):
                            ?>
                            <li><a href="<?php echo esc_url($url); ?>"><?php echo esc_html($text); ?></a></li>
                            <?php endif; endfor; ?>
                        </ul>
                    </div>

                    <!-- Section 4: Contact Info -->
                    <div class="footer-widget footer-contact">
                        <h3><?php echo esc_html(get_option('virical_footer_contact_title', 'Liên Hệ')); ?></h3>
                        <ul class="contact-info">
                            <li>
                                <i class="fas fa-map-marker-alt"></i>
                                <span><?php echo nl2br(esc_html(get_option('virical_footer_address', 'Số 30 Ngõ 100 Nguyễn Xiển, Thanh Xuân, Hà Nội, Việt Nam'))); ?></span>
                            </li>
                            <li>
                                <i class="fas fa-phone"></i>
                                <span><?php echo esc_html(get_option('virical_footer_phone', '0869995698')); ?></span>
                            </li>
                            <li>
                                <i class="fas fa-envelope"></i>
                                <span><?php echo esc_html(get_option('virical_footer_email', 'info@virical.vn')); ?></span>
                            </li>
                        </ul>
                        <div class="newsletter">
                            <h4><?php echo esc_html(get_option('virical_footer_newsletter_title', 'Đăng Ký Nhận Tin')); ?></h4>
                            <form class="newsletter-form" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post">
                                <input type="email" name="email" placeholder="Email của bạn" required>
                                <button type="submit">Đăng Ký</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 5: Footer Bottom -->
        <div class="footer-bottom">
            <div class="ast-container">
                <div class="footer-bottom-content">
                    <div class="copyright">
                        <p><?php echo esc_html(get_option('virical_footer_copyright', '© 2025 Virical. All Rights Reserved. | Designed by Virical Team')); ?></p>
                    </div>
                    <div class="footer-links">
                        <ul>
                            <?php for($i=1; $i<=3; $i++): 
                                $text = get_option("virical_footer_bottom_text_$i");
                                $url = get_option("virical_footer_bottom_url_$i");
                                if($text && $url):
                            ?>
                            <li><a href="<?php echo esc_url($url); ?>"><?php echo esc_html($text); ?></a></li>
                            <?php endif; endfor; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer><!-- #colophon -->

    <style>
    /* Footer Styles */
    .site-footer {
        background: #1a1a1a;
        color: #bbb;
        padding: 0;
        margin-top: 80px;
    }

    .footer-main {
        padding: 60px 0 40px;
        border-bottom: 1px solid #333;
    }

    .footer-content {
        display: grid;
        grid-template-columns: 1.5fr 1fr 1fr 1.5fr;
        gap: 40px;
    }

    .footer-widget h3 {
        color: #fff;
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 20px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .footer-widget ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-widget ul li {
        margin-bottom: 12px;
    }

    .footer-widget ul li a {
        color: #bbb;
        text-decoration: none;
        transition: color 0.3s;
        font-size: 14px;
    }

    .footer-widget ul li a:hover {
        color: #d94948;
    }

    .footer-about p {
        margin: 20px 0;
        line-height: 1.8;
        font-size: 14px;
    }

    .footer-logo-wrapper {
        margin-bottom: 20px;
    }

    .social-links {
        display: flex;
        gap: 15px;
    }

    .social-links a {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #333;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        text-decoration: none;
        transition: all 0.3s;
    }

    .social-links a:hover {
        background: #d94948;
        transform: translateY(-3px);
    }

    .contact-info {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .contact-info li {
        display: flex;
        align-items: flex-start;
        margin-bottom: 15px;
        font-size: 14px;
    }

    .contact-info li i {
        color: #d94948;
        margin-right: 10px;
        margin-top: 3px;
        width: 16px;
    }

    .newsletter {
        margin-top: 25px;
    }

    .newsletter h4 {
        color: #fff;
        font-size: 16px;
        margin-bottom: 15px;
    }

    .newsletter-form {
        display: flex;
        gap: 10px;
    }

    .newsletter-form input {
        flex: 1;
        padding: 10px 15px;
        background: #333;
        border: 1px solid #444;
        color: #fff;
        border-radius: 4px;
        font-size: 14px;
    }

    .newsletter-form input::placeholder {
        color: #888;
    }

    .newsletter-form button {
        padding: 10px 20px;
        background: #d94948;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        transition: background 0.3s;
    }

    .newsletter-form button:hover {
        background: #c73938;
    }

    /* Footer Bottom */
    .footer-bottom {
        background: #111;
        padding: 20px 0;
    }

    .footer-bottom-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .copyright p {
        margin: 0;
        font-size: 14px;
        color: #888;
    }

    .footer-links ul {
        display: flex;
        gap: 30px;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .footer-links a {
        color: #888;
        text-decoration: none;
        font-size: 14px;
        transition: color 0.3s;
    }

    .footer-links a:hover {
        color: #d94948;
    }

    /* Responsive */
    @media (max-width: 991px) {
        .footer-content {
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }
    }

    @media (max-width: 768px) {
        .footer-content {
            grid-template-columns: 1fr;
            gap: 30px;
        }

        .footer-bottom-content {
            flex-direction: column;
            gap: 20px;
            text-align: center;
        }

        .footer-links ul {
            flex-direction: column;
            gap: 10px;
        }
    }
    </style>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>