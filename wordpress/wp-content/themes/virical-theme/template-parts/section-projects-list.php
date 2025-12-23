<?php
/**
 * Template Part: Featured Projects List (Alternating Layout)
 */

$projects_args = array(
    'post_type'      => 'aura_project', // Sử dụng CPT Projects có sẵn
    'posts_per_page' => 5,              // Hiển thị 5 dự án mới nhất
    'orderby'        => 'date',
    'order'          => 'DESC',
    'post_status'    => 'publish'
);

$projects_query = new WP_Query( $projects_args );

if ( $projects_query->have_posts() ) : ?>

<section class="projects-section">
    <div class="projects-container">
        <div class="projects-title">
            <h2>Dự Án Nổi Bật</h2>
            <p>Những công trình chiếu sáng tiêu biểu của AuraLighting</p>
        </div>
        
        <?php while ( $projects_query->have_posts() ) : $projects_query->the_post(); 
            $image_url = get_the_post_thumbnail_url( get_the_ID(), 'large' );
            if ( ! $image_url ) {
                $image_url = get_template_directory_uri() . '/assets/images/placeholder-project.jpg';
            }
            
            // Lấy danh mục dự án để hiển thị ở phần meta
            $terms = get_the_terms( get_the_ID(), 'project_category' );
            $category_name = 'Chiếu sáng';
            if ( $terms && ! is_wp_error( $terms ) ) {
                $category_name = $terms[0]->name;
            }
        ?>
        
        <div class="project-showcase">
            <div class="project-info">
                <h3><?php the_title(); ?></h3>
                <div class="project-meta">Dự án • <?php echo esc_html($category_name); ?></div>
                <p><?php echo has_excerpt() ? get_the_excerpt() : wp_trim_words( get_the_content(), 30 ); ?></p>
                <a href="<?php the_permalink(); ?>" class="project-btn">XEM CHI TIẾT</a>
            </div>
            <div class="project-image">
                <img src="<?php echo esc_url($image_url); ?>" alt="<?php the_title_attribute(); ?>">
            </div>
        </div>
        
        <?php endwhile; ?>
    </div>
</section>

<?php wp_reset_postdata(); endif; ?>

<style>
    /* Project Section Styles */
    .projects-section { background:#f8f8f8; padding:80px 0; overflow:hidden; }
    .projects-container { max-width:1200px; margin:0 auto; padding:0 20px; }
    .projects-title { text-align:center; margin-bottom:60px; }
    .projects-title h2 { font-size:2.5rem; color:#333; margin-bottom:20px; }
    .projects-title p { font-size:1.1rem; color:#666; }
    
    .project-showcase { display:flex; align-items:center; gap:60px; margin-bottom:80px; }
    .project-showcase:nth-child(even) { flex-direction:row-reverse; }
    .project-info { flex:1; opacity:0; transform:translateX(-50px); transition:all 0.8s ease; }
    .project-info.animate { opacity:1; transform:translateX(0); }
    .project-showcase:nth-child(even) .project-info { transform:translateX(50px); }
    .project-showcase:nth-child(even) .project-info.animate { transform:translateX(0); }
    
    .project-info h3 { font-size:2rem; color:#333; margin-bottom:15px; }
    .project-info .project-meta { font-size:0.9rem; color:#888; margin-bottom:20px; }
    .project-info p { font-size:1rem; color:#666; line-height:1.6; margin-bottom:25px; }
    .project-info .project-btn { display:inline-block; padding:12px 25px; background:#333; 
                                 color:#fff; text-decoration:none; transition:background 0.3s; }
    .project-info .project-btn:hover { background:#555; }
    
    .project-image { flex:1; opacity:0; transform:translateX(50px); transition:all 0.8s ease 0.2s; }
    .project-image.animate { opacity:1; transform:translateX(0); }
    .project-showcase:nth-child(even) .project-image { transform:translateX(-50px); }
    .project-showcase:nth-child(even) .project-image.animate { transform:translateX(0); }
    
    .project-image img { width:100%; height:300px; object-fit:cover; border-radius:8px; 
                         box-shadow:0 10px 30px rgba(0,0,0,0.1); }

    /* Responsive */
    @media (max-width: 991px) {
        .project-showcase { gap: 30px; }
        .project-image img { height: 300px; }
    }

    @media (max-width: 768px) {
        .project-showcase, .project-showcase:nth-child(even) { 
            flex-direction: column; gap: 30px; margin-bottom: 60px;
        }
        .project-info, .project-showcase:nth-child(even) .project-info, 
        .project-image, .project-showcase:nth-child(even) .project-image { 
            transform: translateY(30px); 
        }
        .project-info.animate, .project-showcase:nth-child(even) .project-info.animate, 
        .project-image.animate, .project-showcase:nth-child(even) .project-image.animate { 
            transform: translateY(0); 
        }
        .projects-title h2 { font-size: 1.8rem; }
        .project-info h3 { font-size: 1.5rem; }
        .project-info { text-align: center; width: 100%; }
        .project-image { width: 100%; }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Project section animations
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
    
    // Initialize scroll animations
    window.addEventListener('scroll', animateOnScroll);
    window.addEventListener('load', animateOnScroll);
    // Initial check
    animateOnScroll();
});
</script>