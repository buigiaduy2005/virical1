<?php
/**
 * Template Name: Front Page - Dynamic Aura Design
 * 
 * @package Aura_Lighting
 */

get_header(); ?>

<!-- Hero Video Section (Controlled by Top Banner Settings) -->
<?php
$top_banner_active = get_option('virical_top_banner_active', '1');
$banner_video = get_option('virical_top_banner_video', '');
$banner_image = get_option('virical_top_banner_image', ''); // Fallback image

if ($top_banner_active == '1') : ?>
<section class="hero-video-section" style="position: relative; height: 100vh; overflow: hidden; background: #000;">
    <?php if (!empty($banner_video)) : ?>
        <video autoplay muted loop playsinline style="position: absolute; top: 50%; left: 50%; min-width: 100%; min-height: 100%; width: auto; height: auto; transform: translate(-50%, -50%); object-fit: cover; z-index: 1;">
            <source src="<?php echo esc_url($banner_video); ?>" type="video/mp4">
        </video>
    <?php elseif (!empty($banner_image)) : ?>
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: url('<?php echo esc_url($banner_image); ?>'); background-size: cover; background-position: center; z-index: 1;"></div>
    <?php else: ?>
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: #1a1a1a; display: flex; align-items: center; justify-content: center; z-index: 1;">
            <h2 style="color: rgba(255,255,255,0.2); font-size: 2rem;">VIRICAL LIGHTING</h2>
        </div>
    <?php endif; ?>
    
    <div class="video-overlay" style="position: absolute; inset: 0; background: rgba(0,0,0,0.2); z-index: 2;"></div>
    
    <?php
    $banner_title = get_option('virical_top_banner_title', 'VIRICAL');
    $banner_subtitle = get_option('virical_top_banner_subtitle', 'FEELING LIGHT');
    ?>
    <div class="hero-content" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 3; text-align: center; width: 100%; padding: 0 20px;">
        <h2 style="color: #fff; font-size: 4rem; font-weight: 300; letter-spacing: 5px; margin-bottom: 20px; text-shadow: 0 2px 10px rgba(0,0,0,0.5);"><?php echo esc_html($banner_title); ?></h2>
        <p style="color: #fff; font-size: 1.2rem; letter-spacing: 3px; font-weight: 300; text-shadow: 0 2px 5px rgba(0,0,0,0.5);"><?php echo esc_html($banner_subtitle); ?></p>
    </div>
</section>
<?php endif; ?>

<!-- Phone Reveal 3D Effect Section -->
<?php get_template_part('template-parts/section-phone-reveal'); ?>

<!-- About Section - Enhanced -->
<section class="content-section about-section">
    <div class="container">
        <div class="section-header">
            <h3 class="section-subtitle"><?php echo esc_html( get_theme_mod( 'aura_about_subtitle', 'VỀ CHÚNG TÔI' ) ); ?></h3>
            <h2 class="section-title"><?php echo esc_html( get_theme_mod( 'aura_about_title', 'VIRICAL - FEELING LIGHT' ) ); ?></h2>
            <div class="section-divider"></div>
            <div class="section-desc">
                <?php echo wp_kses_post( get_theme_mod( 'aura_about_content', 'VIRICAL là thương hiệu đèn chiếu sáng cao cấp, mang đến những giải pháp ánh sáng hoàn hảo cho mọi không gian. Với công nghệ tiên tiến và thiết kế sang trọng, chúng tôi tạo nên những trải nghiệm ánh sáng độc đáo và ấn tượng.' ) ); ?>
            </div>
            <div class="section-divider"></div>
        </div>

        <!-- Company Highlights -->
        <div class="company-highlights">
            <div class="highlight-item">
                <div class="highlight-number">15+</div>
                <div class="highlight-label">Năm Kinh Nghiệm</div>
                <div class="highlight-desc">Trong lĩnh vực chiếu sáng chuyên nghiệp</div>
            </div>
            <div class="highlight-item">
                <div class="highlight-number">500+</div>
                <div class="highlight-label">Dự Án Hoàn Thành</div>
                <div class="highlight-desc">Các công trình lớn nhỏ trên toàn quốc</div>
            </div>
            <div class="highlight-item">
                <div class="highlight-number">1000+</div>
                <div class="highlight-label">Khách Hàng Tin Tưởng</div>
                <div class="highlight-desc">Từ dân dụng đến thương mại cao cấp</div>
            </div>
            <div class="highlight-item">
                <div class="highlight-number">100%</div>
                <div class="highlight-label">Cam Kết Chất Lượng</div>
                <div class="highlight-desc">Sản phẩm chính hãng, bảo hành toàn diện</div>
            </div>
        </div>

        <!-- Core Values -->
        <div class="core-values">
            <div class="value-item">
                <div class="value-icon">
                    <i class="fa fa-lightbulb"></i>
                </div>
                <h3 class="value-title">Đổi Mới Sáng Tạo</h3>
                <p class="value-desc">Không ngừng nghiên cứu và ứng dụng công nghệ chiếu sáng tiên tiến nhất, mang đến những giải pháp ánh sáng đột phá và độc đáo.</p>
            </div>
            <div class="value-item">
                <div class="value-icon">
                    <i class="fa fa-award"></i>
                </div>
                <h3 class="value-title">Chất Lượng Vượt Trội</h3>
                <p class="value-desc">Cam kết cung cấp sản phẩm đạt chuẩn quốc tế, được kiểm định nghiêm ngặt và bảo hành dài hạn, đảm bảo sự hài lòng tuyệt đối.</p>
            </div>
            <div class="value-item">
                <div class="value-icon">
                    <i class="fa fa-leaf"></i>
                </div>
                <h3 class="value-title">Bền Vững Môi Trường</h3>
                <p class="value-desc">Ưu tiên các giải pháp chiếu sáng tiết kiệm năng lượng, thân thiện môi trường, góp phần xây dựng tương lai xanh và bền vững.</p>
            </div>
            <div class="value-item">
                <div class="value-icon">
                    <i class="fa fa-users"></i>
                </div>
                <h3 class="value-title">Tư Vấn Chuyên Nghiệp</h3>
                <p class="value-desc">Đội ngũ chuyên gia giàu kinh nghiệm, luôn sẵn sàng tư vấn và thiết kế giải pháp chiếu sáng phù hợp nhất cho từng dự án.</p>
            </div>
        </div>

        <!-- Why Choose Us -->
        <div class="why-choose-section">
            <h3 class="why-title">Tại Sao Chọn VIRICAL?</h3>
            <div class="why-content">
                <div class="why-col">
                    <ul class="why-list">
                        <li><i class="fa fa-check-circle"></i> <strong>Đại lý chính thức</strong> của các thương hiệu chiếu sáng hàng đầu thế giới</li>
                        <li><i class="fa fa-check-circle"></i> <strong>Showroom rộng 500m²</strong> trưng bày hàng ngàn mẫu đèn cao cấp</li>
                        <li><i class="fa fa-check-circle"></i> <strong>Tư vấn thiết kế miễn phí</strong> bởi đội ngũ chuyên gia lighting designer</li>
                    </ul>
                </div>
                <div class="why-col">
                    <ul class="why-list">
                        <li><i class="fa fa-check-circle"></i> <strong>Bảo hành dài hạn</strong> lên đến 5 năm cho tất cả sản phẩm</li>
                        <li><i class="fa fa-check-circle"></i> <strong>Dịch vụ sau bán hàng</strong> chuyên nghiệp, nhanh chóng 24/7</li>
                        <li><i class="fa fa-check-circle"></i> <strong>Giá cạnh tranh nhất</strong> với chính sách ưu đãi hấp dẫn cho dự án lớn</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Products Section -->
<?php
$products_args = array(
    'post_type'      => 'aura_product',
    'posts_per_page' => 8,
    'meta_key'       => '_featured',
    'orderby'        => array(
        'meta_value' => 'DESC',
        'date'       => 'DESC'
    ),
    'post_status'    => 'publish'
);

$products_query = new WP_Query( $products_args );

if ( $products_query->have_posts() ) : ?>
    <section class="products-section">
        <div class="container">
            <h2 class="section-title"><?php echo esc_html( get_theme_mod( 'aura_products_title', 'SẢN PHẨM NỔI BẬT' ) ); ?></h2>
            <div class="products-grid">
                <?php while ( $products_query->have_posts() ) : $products_query->the_post(); ?>
                    <div class="product-card">
                        <a href="<?php the_permalink(); ?>" class="product-link">
                            <div class="product-image">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail( 'aura-product-thumb' ); ?>
                                <?php else : ?>
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.jpg" alt="<?php the_title(); ?>">
                                <?php endif; ?>
                            </div>
                            <h3 class="product-name"><?php the_title(); ?></h3>
                            <?php 
                            $product_code = get_post_meta( get_the_ID(), '_product_code', true );
                            if ( $product_code ) : ?>
                                <p class="product-code"><?php echo esc_html( $product_code ); ?></p>
                            <?php endif; ?>
                        </a>
                    </div>
                <?php endwhile; ?>
            </div>
            <div class="products-cta">
                <a href="<?php echo get_post_type_archive_link( 'aura_product' ); ?>" class="btn-view-all">
                    Xem tất cả sản phẩm
                </a>
            </div>
        </div>
    </section>
    <?php wp_reset_postdata();
endif; ?>



<!-- Featured Projects List Section -->
<?php get_template_part('template-parts/section-projects-list'); ?>

<!-- Featured Products 3D Carousel -->
<?php
$equipment_args = array(
    'post_type'      => 'equipment_item',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby'        => 'menu_order',
    'order'          => 'ASC'
);

$equipment_query = new WP_Query( $equipment_args );

if ( $equipment_query->have_posts() ) : 
    $total_items = $equipment_query->post_count;
?>
<section class="featured-products-carousel-section">
    <div class="container">
        <div class="section-header">
            <h3 class="section-subtitle">EQUIPMENT SELECTOR</h3>
            <h2 class="section-title">SẢN PHẨM TIÊU BIỂU</h2>
            <div class="section-divider"></div>
        </div>
        
        <div class="carousel-3d-wrapper">
            <div class="carousel-3d-container">
                <!-- Product Items -->
                <?php 
                $i = 0;
                while ( $equipment_query->have_posts() ) : $equipment_query->the_post(); 
                    $code = get_post_meta( get_the_ID(), '_equipment_code', true );
                    $link = get_post_meta( get_the_ID(), '_equipment_link', true );
                    $image_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
                    if ( ! $image_url ) {
                        $image_url = get_template_directory_uri() . '/assets/images/placeholder.jpg';
                    }
                ?>
                <div class="carousel-3d-item" data-index="<?php echo $i; ?>">
                    <div class="product-3d-card">
                        <div class="product-3d-image">
                            <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php the_title_attribute(); ?>">
                        </div>
                        <h3 class="product-3d-name"><?php the_title(); ?></h3>
                        <?php if ( $code ) : ?>
                            <p class="product-3d-code"><?php echo esc_html( $code ); ?></p>
                        <?php endif; ?>
                        
                        <?php if ( $link ) : ?>
                            <a href="<?php echo esc_url( $link ); ?>" class="product-3d-select" style="display:inline-block; text-decoration:none; line-height:1.2; padding-top:14px; color:white;">Select</a>
                        <?php else : ?>
                            <button class="product-3d-select">Select</button>
                        <?php endif; ?>
                    </div>
                </div>
                <?php 
                $i++;
                endwhile; 
                ?>
            </div>
            
            <!-- Navigation Controls -->
            <div class="carousel-3d-nav">
                <button class="carousel-3d-prev" aria-label="Previous">
                    <i class="fa fa-chevron-left"></i>
                </button>
                <button class="carousel-3d-next" aria-label="Next">
                    <i class="fa fa-chevron-right"></i>
                </button>
            </div>
            
            <!-- Indicators -->
            <div class="carousel-3d-indicators">
                <?php for ( $j = 0; $j < $total_items; $j++ ) : ?>
                    <span class="indicator <?php echo ( $j === 0 ) ? 'active' : ''; ?>" data-index="<?php echo $j; ?>"></span>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</section>
<?php 
    wp_reset_postdata();
endif; 
?>

<!-- Styles specific to this page -->
<style>
/* Aura Dynamic Design Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Quicksand', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
    overflow-x: hidden;
    background: #fff;
}

/* Top Banner Section */
.top-banner-section {
    width: 100%;
    overflow: hidden;
}

.top-banner-wrapper img {
    width: 100%;
    height: auto;
    display: block;
}

/* Hero Slider Section */
.hero-slider-section {
    position: relative;
    height: 100vh;
    overflow: hidden;
}

.hero-slider .item {
    position: relative;
    height: 100vh;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}

.slide-link {
    display: block;
    width: 100%;
    height: 100%;
}

.slide-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.3);
    display: flex;
    align-items: center;
    justify-content: center;
}

.slide-content {
    text-align: center;
    color: #fff;
    max-width: 1200px;
    padding: 0 40px;
}

.slide-title {
    font-size: 60px;
    font-weight: 300;
    letter-spacing: 8px;
    margin-bottom: 20px;
    text-transform: uppercase;
    animation: fadeInUp 1s ease-out;
}


/* Content Sections */
.content-section {
    padding: 100px 0;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 40px;
}

.section-header {
    text-align: center;
    margin-bottom: 60px;
}

.section-subtitle {
    font-size: 18px;
    color: #818181;
    letter-spacing: 2px;
    margin-bottom: 10px;
    font-weight: 300;
}

.section-title {
    font-size: 36px;
    color: #3e3e3e;
    font-weight: 400;
    letter-spacing: 3px;
    margin-bottom: 30px;
    text-align: center;
}

.section-divider {
    width: 100px;
    height: 1px;
    background: #000;
    margin: 0 auto 20px;
}

.section-desc {
    font-size: 16px;
    line-height: 1.8;
    color: #666;
    max-width: 800px;
    margin: 0 auto;
}

/* Company Highlights */
.company-highlights {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 40px;
    margin: 80px 0 60px;
    padding: 60px 0;
    border-top: 1px solid #e0e0e0;
    border-bottom: 1px solid #e0e0e0;
}

.highlight-item {
    text-align: center;
}

.highlight-number {
    font-size: 48px;
    font-weight: 600;
    color: #000;
    margin-bottom: 15px;
    line-height: 1;
}

.highlight-label {
    font-size: 16px;
    font-weight: 500;
    color: #3e3e3e;
    margin-bottom: 10px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.highlight-desc {
    font-size: 14px;
    color: #999;
    line-height: 1.6;
}

/* Core Values */
.core-values {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 40px;
    margin: 60px 0;
}

.value-item {
    text-align: center;
    padding: 30px 20px;
    transition: transform 0.3s;
}

.value-item:hover {
    transform: translateY(-10px);
}

.value-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 25px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #000;
    border-radius: 50%;
    transition: all 0.3s;
}

.value-item:hover .value-icon {
    background: #000;
    color: #fff;
}

.value-icon i {
    font-size: 32px;
}

.value-title {
    font-size: 18px;
    font-weight: 500;
    color: #3e3e3e;
    margin-bottom: 15px;
    letter-spacing: 0.5px;
}

.value-desc {
    font-size: 14px;
    line-height: 1.8;
    color: #666;
}

/* Why Choose Us */
.why-choose-section {
    margin-top: 80px;
    padding: 60px;
    background: #f9f9f9;
    border-radius: 8px;
}

.why-title {
    font-size: 28px;
    font-weight: 500;
    color: #3e3e3e;
    text-align: center;
    margin-bottom: 40px;
    letter-spacing: 1px;
}

.why-content {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 60px;
}

.why-list {
    list-style: none;
    padding: 0;
}

.why-list li {
    font-size: 15px;
    line-height: 2;
    color: #555;
    margin-bottom: 20px;
    display: flex;
    align-items: flex-start;
    gap: 15px;
}

.why-list li i {
    color: #4CAF50;
    font-size: 18px;
    margin-top: 3px;
    flex-shrink: 0;
}

.why-list li strong {
    color: #3e3e3e;
}

/* Products Section */
.products-section {
    padding: 100px 0;
    background: #fafafa;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 40px;
    margin-bottom: 50px;
}

.product-card {
    text-align: center;
}

.product-link {
    text-decoration: none;
    color: inherit;
}

.product-image {
    background: #fff;
    height: 280px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
    position: relative;
    overflow: hidden;
    transition: transform 0.3s;
}

.product-card:hover .product-image {
    transform: scale(1.05);
}

.product-image img {
    max-width: 80%;
    max-height: 80%;
    object-fit: contain;
}

.product-name {
    font-size: 18px;
    font-weight: 400;
    margin-bottom: 5px;
    color: #2a2a2a;
}

.product-code {
    font-size: 13px;
    color: #999;
    letter-spacing: 0.5px;
}

/* Featured Projects Section */
.projects-section {
    background: #f8f8f8;
    padding: 80px 0;
    overflow: hidden;
}

.projects-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.projects-title {
    text-align: center;
    margin-bottom: 60px;
}

.projects-title h2 {
    font-size: 2.5rem;
    color: #333;
    margin-bottom: 20px;
    font-weight: 400;
    letter-spacing: 2px;
}

.projects-title p {
    font-size: 1.1rem;
    color: #666;
}

.project-showcase {
    display: flex;
    align-items: center;
    gap: 60px;
    margin-bottom: 80px;
}

.project-showcase:nth-child(even) {
    flex-direction: row-reverse;
}

.project-info {
    flex: 1;
    opacity: 0;
    transform: translateX(-50px);
    transition: all 0.8s ease;
}

.project-info.animate {
    opacity: 1;
    transform: translateX(0);
}

.project-showcase:nth-child(even) .project-info {
    transform: translateX(50px);
}

.project-showcase:nth-child(even) .project-info.animate {
    transform: translateX(0);
}

.project-info h3 {
    font-size: 2rem;
    color: #333;
    margin-bottom: 15px;
    font-weight: 400;
}

.project-meta {
    font-size: 0.9rem;
    color: #888;
    margin-bottom: 20px;
}

.project-info p {
    font-size: 1rem;
    color: #666;
    line-height: 1.6;
    margin-bottom: 25px;
}

.project-btn {
    display: inline-block;
    padding: 12px 25px;
    background: #333;
    color: #fff;
    text-decoration: none;
    transition: background 0.3s;
    border-radius: 4px;
}

.project-btn:hover {
    background: #555;
}

.project-image {
    flex: 1;
    opacity: 0;
    transform: translateX(50px);
    transition: all 0.8s ease 0.2s;
}

.project-image.animate {
    opacity: 1;
    transform: translateX(0);
}

.project-showcase:nth-child(even) .project-image {
    transform: translateX(-50px);
}

.project-showcase:nth-child(even) .project-image.animate {
    transform: translateX(0);
}

.project-image img {
    width: 100%;
    height: 300px;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

/* Responsive Design */
@media (max-width: 768px) {
    .project-showcase,
    .project-showcase:nth-child(even) {
        flex-direction: column;
        gap: 30px;
    }
    
    .project-info,
    .project-showcase:nth-child(even) .project-info,
    .project-image,
    .project-showcase:nth-child(even) .project-image {
        transform: translateY(30px);
    }
    
    .project-info.animate,
    .project-showcase:nth-child(even) .project-info.animate,
    .project-image.animate,
    .project-showcase:nth-child(even) .project-image.animate {
        transform: translateY(0);
    }
    
    .projects-title h2 {
        font-size: 1.8rem;
    }
    
    .project-info h3 {
        font-size: 1.5rem;
    }
}

/* Featured Projects Section */
.featured-projects-section {
    padding: 100px 0;
    background: #fff;
}

.projects-slider-wrapper {
    position: relative;
    margin: 60px 0;
}

.projects-slider {
    position: relative;
}

.project-slide {
    position: relative;
}

.project-slide-container {
    position: relative;
    display: flex;
    align-items: center;
    min-height: 700px;
}

.project-slide-bg {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}

.project-slide-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to right, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.8) 50%, rgba(255,255,255,0) 100%);
}

.project-slide-content {
    position: relative;
    z-index: 2;
    max-width: 600px;
    padding: 80px;
}

.project-meta {
    margin-bottom: 20px;
}

.project-category {
    font-size: 24px;
    color: #818181;
    font-weight: 300;
    letter-spacing: 1px;
    font-family: 'Quicksand', sans-serif;
}

.project-slide-title {
    font-size: 48px;
    color: #3e3e3e;
    margin-bottom: 20px;
    font-weight: 400;
    line-height: 1.2;
    font-family: 'Quicksand', sans-serif;
}

.project-slide-desc {
    font-size: 16px;
    color: #666;
    line-height: 1.6;
    margin-bottom: 40px;
}

.project-slide-info {
    margin: 50px 0;
}

.info-row {
    display: flex;
    gap: 60px;
}

.info-item {
    flex: 1;
}

.info-divider-top,
.info-divider-bottom {
    width: 35%;
    height: 1px;
    background: #000;
    margin: 15px 0;
}

.info-content {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.info-label {
    font-size: 12px;
    color: #999;
    letter-spacing: 1px;
    text-transform: uppercase;
}

.info-value {
    font-size: 18px;
    color: #3e3e3e;
    font-weight: 400;
}

.project-slide-link {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    color: #000;
    text-decoration: none;
    font-size: 16px;
    font-weight: 500;
    transition: all 0.3s;
    margin-top: 30px;
}

.project-slide-link:hover {
    transform: translateX(10px);
}

.project-slide-link i {
    font-size: 14px;
}

/* Projects Navigation */
.projects-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    left: 40px;
    right: 40px;
    display: flex;
    justify-content: space-between;
    z-index: 10;
    pointer-events: none;
}

.projects-nav button {
    pointer-events: all;
    width: 50px;
    height: 50px;
    border: 2px solid #000;
    background: transparent;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s;
    font-size: 16px;
}

.projects-nav button:hover {
    background: #000;
    color: #fff;
}

/* Owl Carousel Custom Styles for Projects */
.projects-slider .owl-nav {
    display: none;
}

.projects-slider .owl-dots {
    text-align: center;
    margin-top: 40px;
}

.projects-slider .owl-dot {
    display: inline-block;
    width: 10px;
    height: 10px;
    background: #ddd;
    border-radius: 50%;
    margin: 0 5px;
    transition: all 0.3s;
}

.projects-slider .owl-dot.active {
    background: #000;
    width: 30px;
    border-radius: 5px;
}

/* CTA Buttons */
.products-cta,
.projects-cta {
    text-align: center;
    margin-top: 50px;
}

.btn-view-all {
    display: inline-block;
    padding: 15px 40px;
    background: #000;
    color: #fff;
    text-decoration: none;
    font-size: 14px;
    letter-spacing: 1px;
    text-transform: uppercase;
    transition: all 0.3s;
}

.btn-view-all:hover {
    background: #333;
    transform: translateY(-2px);
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Project Slide Animations */
.project-slide-content {
    opacity: 0;
    transform: translateX(-30px);
    transition: all 0.8s ease-out;
}

.project-slide-content.animated {
    opacity: 1;
    transform: translateX(0);
}

.project-slide-content.animated .project-category {
    animation: fadeInUp 0.6s ease-out;
}

.project-slide-content.animated .project-slide-title {
    animation: fadeInUp 0.6s ease-out 0.1s;
    animation-fill-mode: both;
}

.project-slide-content.animated .project-slide-desc {
    animation: fadeInUp 0.6s ease-out 0.2s;
    animation-fill-mode: both;
}

.project-slide-content.animated .project-slide-info {
    animation: fadeInUp 0.6s ease-out 0.3s;
    animation-fill-mode: both;
}

.project-slide-content.animated .project-slide-link {
    animation: fadeInUp 0.6s ease-out 0.4s;
    animation-fill-mode: both;
}

/* Responsive */
@media (max-width: 991px) {
    .products-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .categories {
        flex-direction: column;
        height: auto;
    }

    .category {
        height: 400px;
    }

    .project-slide-content {
        padding: 60px;
    }

    .project-slide-title {
        font-size: 36px;
    }

    .projects-nav {
        left: 20px;
        right: 20px;
    }

    .company-highlights {
        grid-template-columns: repeat(2, 1fr);
        gap: 30px;
        margin: 60px 0 40px;
        padding: 40px 0;
    }

    .core-values {
        grid-template-columns: repeat(2, 1fr);
        gap: 30px;
    }

    .why-content {
        grid-template-columns: 1fr;
        gap: 40px;
    }

    .why-choose-section {
        padding: 40px 30px;
    }
}

@media (max-width: 768px) {
    .slide-title {
        font-size: 40px;
        letter-spacing: 4px;
    }

    .section-title {
        font-size: 28px;
    }

    .products-grid {
        grid-template-columns: 1fr;
    }

    .project-slide-container {
        min-height: 500px;
    }

    .project-slide-content {
        padding: 40px;
        max-width: 100%;
    }

    .project-slide-title {
        font-size: 28px;
    }

    .project-slide-overlay {
        background: linear-gradient(to bottom, rgba(255,255,255,0) 0%, rgba(255,255,255,0.9) 50%, rgba(255,255,255,0.95) 100%);
    }

    .info-row {
        flex-direction: column;
        gap: 30px;
    }

    .projects-nav {
        display: none;
    }

    .category-title {
        font-size: 40px;
    }

    .company-highlights {
        grid-template-columns: 1fr;
        gap: 40px;
        margin: 40px 0 30px;
        padding: 30px 0;
    }

    .highlight-number {
        font-size: 42px;
    }

    .core-values {
        grid-template-columns: 1fr;
        gap: 30px;
        margin: 40px 0;
    }

    .why-choose-section {
        padding: 30px 20px;
        margin-top: 60px;
    }

    .why-title {
        font-size: 24px;
    }

    .why-list li {
        font-size: 14px;
    }
}

/* ========================================
   3D Featured Products Carousel Section
   ======================================== */

.featured-products-carousel-section {
    padding: 120px 0;
    background: #ffffff;
    overflow: hidden;
}

.carousel-3d-wrapper {
    position: relative;
    margin-top: 80px;
    perspective: 2000px;
    perspective-origin: 50% 50%;
}

.carousel-3d-container {
    position: relative;
    width: 100%;
    height: 600px;
    display: flex;
    align-items: center;
    justify-content: center;
    transform-style: preserve-3d;
    overflow: visible;
}

.carousel-3d-item {
    position: absolute;
    width: 350px;
    transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    transform-style: preserve-3d;
}

/* Product Card Styling */
.product-3d-card {
    background: #ffffff;
    border-radius: 12px;
    padding: 40px 30px;
    text-align: center;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
    transition: all 0.4s ease;
}

.product-3d-image {
    width: 100%;
    height: 280px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 30px;
    background: #fafafa;
    border-radius: 8px;
    overflow: hidden;
}

.product-3d-image img {
    max-width: 85%;
    max-height: 85%;
    object-fit: contain;
    filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.08));
    transition: transform 0.4s ease;
}

.product-3d-card:hover .product-3d-image img {
    transform: scale(1.05);
}

.product-3d-name {
    font-size: 20px;
    font-weight: 500;
    color: #2a2a2a;
    margin-bottom: 8px;
    letter-spacing: 0.3px;
}

.product-3d-code {
    font-size: 14px;
    color: #999;
    margin-bottom: 25px;
    letter-spacing: 0.5px;
}

.product-3d-select {
    background: #4CAF50;
    color: #ffffff;
    border: none;
    padding: 12px 40px;
    font-size: 14px;
    font-weight: 600;
    letter-spacing: 1px;
    text-transform: uppercase;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
}

.product-3d-select:hover {
    background: #45a049;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(76, 175, 80, 0.4);
}

.product-3d-select:active {
    transform: translateY(0);
}

/* Carousel Positioning - Curved Arc Effect */
.carousel-3d-item[data-index="0"] { 
    transform: translateX(-600px) rotateY(-35deg) translateZ(-150px) scale(0.75);
    opacity: 0.4;
    z-index: 1;
}

.carousel-3d-item[data-index="1"] { 
    transform: translateX(-400px) rotateY(-25deg) translateZ(-80px) scale(0.85);
    opacity: 0.6;
    z-index: 2;
}

.carousel-3d-item[data-index="2"] { 
    transform: translateX(-200px) rotateY(-12deg) translateZ(-30px) scale(0.95);
    opacity: 0.8;
    z-index: 3;
}

.carousel-3d-item[data-index="3"] { 
    transform: translateX(0) rotateY(0deg) translateZ(0px) scale(1.1);
    opacity: 1;
    z-index: 5;
}

.carousel-3d-item[data-index="4"] { 
    transform: translateX(200px) rotateY(12deg) translateZ(-30px) scale(0.95);
    opacity: 0.8;
    z-index: 3;
}

.carousel-3d-item[data-index="5"] { 
    transform: translateX(400px) rotateY(25deg) translateZ(-80px) scale(0.85);
    opacity: 0.6;
    z-index: 2;
}

.carousel-3d-item[data-index="6"] { 
    transform: translateX(600px) rotateY(35deg) translateZ(-150px) scale(0.75);
    opacity: 0.4;
    z-index: 1;
}

/* Hide items beyond visible range */
.carousel-3d-item[data-index="7"],
.carousel-3d-item[data-index="8"],
.carousel-3d-item[data-index="9"],
.carousel-3d-item[data-index="10"] {
    opacity: 0;
    pointer-events: none;
    transform: translateX(800px) translateZ(-300px) scale(0.5);
    z-index: 0;
}

/* Navigation Controls */
.carousel-3d-nav {
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    transform: translateY(-50%);
    display: flex;
    justify-content: space-between;
    padding: 0 40px;
    z-index: 10;
    pointer-events: none;
}

.carousel-3d-nav button {
    pointer-events: all;
    width: 60px;
    height: 60px;
    border: 2px solid #000;
    background: rgba(255, 255, 255, 0.95);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 18px;
    color: #000;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.carousel-3d-nav button:hover {
    background: #000;
    color: #fff;
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
}

.carousel-3d-nav button:active {
    transform: scale(0.95);
}

/* Indicators */
.carousel-3d-indicators {
    display: flex;
    justify-content: center;
    gap: 12px;
    margin-top: 60px;
}

.carousel-3d-indicators .indicator {
    width: 12px;
    height: 12px;
    background: #ddd;
    border-radius: 50%;
    cursor: pointer;
    transition: all 0.3s ease;
}

.carousel-3d-indicators .indicator:hover {
    background: #999;
    transform: scale(1.2);
}

.carousel-3d-indicators .indicator.active {
    background: #000;
    width: 40px;
    border-radius: 6px;
}

/* Mobile Responsive Design */
@media (max-width: 991px) {
    .featured-products-carousel-section {
        padding: 80px 0;
    }
    
    .carousel-3d-container {
        height: 500px;
    }
    
    .carousel-3d-item {
        width: 300px;
    }
    
    .carousel-3d-item[data-position="center"] {
        transform: translateX(0) translateZ(0) scale(1.1);
    }
    
    .carousel-3d-item[data-position="left-1"] {
        transform: translateX(-320px) translateZ(-150px) rotateY(12deg) scale(0.8);
    }
    
    .carousel-3d-item[data-position="left-2"] {
        transform: translateX(-580px) translateZ(-280px) rotateY(20deg) scale(0.65);
    }
    
    .carousel-3d-item[data-position="right-1"] {
        transform: translateX(320px) translateZ(-150px) rotateY(-12deg) scale(0.8);
    }
    
    .carousel-3d-item[data-position="right-2"] {
        transform: translateX(580px) translateZ(-280px) rotateY(-20deg) scale(0.65);
    }
    
    .carousel-3d-nav {
        padding: 0 20px;
    }
    
    .carousel-3d-nav button {
        width: 50px;
        height: 50px;
        font-size: 16px;
    }
}

@media (max-width: 768px) {
    .featured-products-carousel-section {
        padding: 60px 0;
    }
    
    .carousel-3d-wrapper {
        perspective: none;
        margin-top: 50px;
    }
    
    .carousel-3d-container {
        height: 500px;
        transform-style: flat;
    }
    
    .carousel-3d-item {
        width: 90%;
        max-width: 320px;
        left: 50%;
        transform: translateX(-50%) !important;
    }
    
    /* Mobile: Show only active item, hide all others */
    .carousel-3d-item[data-index="0"],
    .carousel-3d-item[data-index="1"],
    .carousel-3d-item[data-index="2"],
    .carousel-3d-item[data-index="4"],
    .carousel-3d-item[data-index="5"],
    .carousel-3d-item[data-index="6"],
    .carousel-3d-item[data-index="7"],
    .carousel-3d-item[data-index="8"],
    .carousel-3d-item[data-index="9"],
    .carousel-3d-item[data-index="10"] {
        opacity: 0 !important;
        pointer-events: none !important;
        transform: translateX(-50%) scale(0.8) !important;
        z-index: 0 !important;
    }
    
    /* Show only the center item */
    .carousel-3d-item[data-index="3"] {
        opacity: 1 !important;
        pointer-events: all !important;
        transform: translateX(-50%) scale(1) !important;
        z-index: 5 !important;
    }
    
    .product-3d-card {
        padding: 30px 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    }
    
    .product-3d-image {
        height: 200px;
        margin-bottom: 20px;
    }
    
    .product-3d-name {
        font-size: 18px;
    }
    
    .product-3d-code {
        font-size: 13px;
    }
    
    .product-3d-select {
        padding: 12px 30px;
        font-size: 13px;
        /* Large touch targets for mobile */
        min-height: 44px;
        min-width: 120px;
    }
    
    .carousel-3d-nav {
        padding: 0 10px;
    }
    
    .carousel-3d-nav button {
        width: 44px;
        height: 44px;
        font-size: 14px;
    }
    
    .carousel-3d-indicators {
        margin-top: 40px;
        gap: 8px;
    }
    
    .carousel-3d-indicators .indicator {
        width: 8px;
        height: 8px;
    }
    
    .carousel-3d-indicators .indicator.active {
        width: 24px;
    }
}

</style>

<!-- Owl Carousel CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

<!-- jQuery and Owl Carousel JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<script>
jQuery(document).ready(function($) {
    // Initialize Hero Slider
    $('.hero-slider').owlCarousel({
        items: 1,
        loop: true,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        nav: true,
        dots: true,
        navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        smartSpeed: 1000
    });
    
    // Initialize Projects Slider
    var projectsSlider = $('.projects-slider').owlCarousel({
        items: 1,
        loop: true,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        nav: false,
        dots: true,
        smartSpeed: 500,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        onInitialized: function() {
            // Add animation to first slide
            $('.projects-slider .owl-item.active .project-slide-content').addClass('animated');
        },
        onChanged: function() {
            // Remove animation from all slides
            $('.projects-slider .project-slide-content').removeClass('animated');
            
            // Add animation to active slide
            setTimeout(function() {
                $('.projects-slider .owl-item.active .project-slide-content').addClass('animated');
            }, 100);
        }
    });
    
    // Custom Navigation for Projects
    $('.projects-prev').click(function() {
        projectsSlider.trigger('prev.owl.carousel');
    });
    
    $('.projects-next').click(function() {
        projectsSlider.trigger('next.owl.carousel');
    });
    
    // ========================================
    // 3D Featured Products Carousel
    // ========================================
    
    const carousel3D = {
        currentIndex: 0,
        totalItems: $('.carousel-3d-item').length,
        isAnimating: false,
        autoplayInterval: null,
        autoplayDelay: 8000, // Changed from 4000ms to 8000ms (8 seconds)
        
        init: function() {
            this.updatePositions();
            this.bindEvents();
            this.startAutoplay();
        },
        
        updatePositions: function() {
            const items = $('.carousel-3d-item');
            const total = this.totalItems;
            
            console.log('Updating positions, total items:', total, 'current index:', this.currentIndex);
            
            items.each((index, item) => {
                const $item = $(item);
                // Calculate position relative to current center
                let diff = index - this.currentIndex;
                
                // Normalize diff to be between -total/2 and +total/2
                if (diff > total / 2) diff -= total;
                if (diff < -total / 2) diff += total;
                
                // Calculate curved arc position based on diff
                let x, rotateY, z, scale, opacity, zIndex;
                
                if (diff === 0) {
                    // Center item
                    x = 0;
                    rotateY = 0;
                    z = 0;
                    scale = 1.15;
                    opacity = 1;
                    zIndex = 10;
                } else {
                    // Side items - create curved arc
                    const absDiff = Math.abs(diff);
                    const direction = diff > 0 ? 1 : -1;
                    
                    // Calculate position along arc
                    x = direction * (200 + absDiff * 180);
                    rotateY = direction * (10 + absDiff * 12);
                    z = -(absDiff * 60);
                    scale = Math.max(0.7, 1 - absDiff * 0.15);
                    opacity = Math.max(0.3, 1 - absDiff * 0.25);
                    zIndex = 10 - absDiff;
                }
                
                // Apply transforms
                $item.css({
                    'transform': `translateX(${x}px) rotateY(${rotateY}deg) translateZ(${z}px) scale(${scale})`,
                    'opacity': opacity,
                    'z-index': zIndex,
                    'pointer-events': opacity > 0.2 ? 'auto' : 'none'
                });
                
                console.log(`Item ${index}: diff=${diff}, x=${x}, rotateY=${rotateY}, scale=${scale}`);
            });
            
            // Update indicators
            $('.carousel-3d-indicators .indicator').removeClass('active');
            $('.carousel-3d-indicators .indicator[data-index="' + this.currentIndex + '"]').addClass('active');
        },
        
        next: function() {
            if (this.isAnimating) return;
            this.isAnimating = true;
            
            this.currentIndex = (this.currentIndex + 1) % this.totalItems;
            this.updatePositions();
            
            setTimeout(() => {
                this.isAnimating = false;
            }, 800);
        },
        
        prev: function() {
            if (this.isAnimating) return;
            this.isAnimating = true;
            
            this.currentIndex = (this.currentIndex - 1 + this.totalItems) % this.totalItems;
            this.updatePositions();
            
            setTimeout(() => {
                this.isAnimating = false;
            }, 800);
        },
        
        goTo: function(index) {
            if (this.isAnimating || index === this.currentIndex) return;
            this.isAnimating = true;
            
            this.currentIndex = index;
            this.updatePositions();
            
            setTimeout(() => {
                this.isAnimating = false;
            }, 800);
        },
        
        bindEvents: function() {
            const self = this;
            
            // Navigation buttons
            $('.carousel-3d-prev').on('click', function() {
                self.prev();
                self.resetAutoplay();
            });
            
            $('.carousel-3d-next').on('click', function() {
                self.next();
                self.resetAutoplay();
            });
            
            // Indicators
            $('.carousel-3d-indicators .indicator').on('click', function() {
                const index = parseInt($(this).attr('data-index'));
                self.goTo(index);
                self.resetAutoplay();
            });
            
            // Touch/Swipe support
            let touchStartX = 0;
            let touchEndX = 0;
            
            $('.carousel-3d-container').on('touchstart', function(e) {
                touchStartX = e.changedTouches[0].screenX;
            });
            
            $('.carousel-3d-container').on('touchend', function(e) {
                touchEndX = e.changedTouches[0].screenX;
                self.handleSwipe();
            });
            
            this.handleSwipe = function() {
                const swipeThreshold = 50;
                const diff = touchStartX - touchEndX;
                
                if (Math.abs(diff) > swipeThreshold) {
                    if (diff > 0) {
                        self.next();
                    } else {
                        self.prev();
                    }
                    self.resetAutoplay();
                }
            };
            
            // Keyboard navigation
            $(document).on('keydown', function(e) {
                if ($('.featured-products-carousel-section').is(':visible')) {
                    if (e.keyCode === 37) { // Left arrow
                        self.prev();
                        self.resetAutoplay();
                    } else if (e.keyCode === 39) { // Right arrow
                        self.next();
                        self.resetAutoplay();
                    }
                }
            });
            
            // Pause on hover
            $('.carousel-3d-wrapper').on('mouseenter', function() {
                self.stopAutoplay();
            });
            
            $('.carousel-3d-wrapper').on('mouseleave', function() {
                self.startAutoplay();
            });
        },
        
        startAutoplay: function() {
            const self = this;
            this.autoplayInterval = setInterval(function() {
                self.next();
            }, this.autoplayDelay);
        },
        
        stopAutoplay: function() {
            if (this.autoplayInterval) {
                clearInterval(this.autoplayInterval);
                this.autoplayInterval = null;
            }
        },
        
        resetAutoplay: function() {
            this.stopAutoplay();
            this.startAutoplay();
        }
    };
    
    // Initialize 3D Carousel
    if ($('.carousel-3d-item').length > 0) {
        console.log('Initializing 3D Carousel with', $('.carousel-3d-item').length, 'items');
        carousel3D.init();
        console.log('3D Carousel initialized with curved arc effect');
    } else {
        console.log('No carousel items found');
    }
    
    // Featured Projects Scroll Animation
    function animateOnScroll() {
        const projectElements = document.querySelectorAll('.project-info, .project-image');
        
        projectElements.forEach(element => {
            const elementTop = element.getBoundingClientRect().top;
            const elementVisible = 150;
            
            if (elementTop < window.innerHeight - elementVisible) {
                element.classList.add('animate');
            }
        });
    }
    
    // Use IntersectionObserver for better performance
    if ('IntersectionObserver' in window) {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };
        
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate');
                }
            });
        }, observerOptions);
        
        // Observe all project elements
        document.querySelectorAll('.project-info, .project-image').forEach(element => {
            observer.observe(element);
        });
    } else {
        // Fallback for older browsers
        window.addEventListener('scroll', animateOnScroll);
        window.addEventListener('load', animateOnScroll);
        animateOnScroll(); // Initial check
    }
});
</script>

<?php get_footer(); ?>