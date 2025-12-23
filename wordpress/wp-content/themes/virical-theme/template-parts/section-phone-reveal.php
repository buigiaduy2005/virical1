<?php
// Get options
$is_active = get_option('virical_phone_reveal_active', '1'); // Default to active for demo
$phone_img = get_option('virical_phone_center_image');
$bg_img = get_option('virical_phone_bg_image');
$center_logo = get_option('virical_phone_center_logo'); // Center logo option

// Use placeholder if no image set, so the user sees something immediately
if (empty($phone_img)) {
    // You can replace this with a local placeholder if you have one
    $phone_img = 'https://i.ibb.co/5xbz063/iphone-frame.png'; 
}

// Default smart home icon if no logo set
if (empty($center_logo)) {
    $center_logo = 'https://cdn-icons-png.flaticon.com/512/1670/1670028.png'; // Smart home icon
}

// Dummy data for features if empty, to show the effect
$features_left = [];
$features_right = [];

for ($i = 1; $i <= 3; $i++) {
    $features_left[] = [
        'icon' => get_option('virical_phone_feat_' . $i . '_icon') ?: 'https://cdn-icons-png.flaticon.com/512/2983/2983814.png',
        'title' => get_option('virical_phone_feat_' . $i . '_title') ?: 'Smart Feature ' . $i,
        'desc' => get_option('virical_phone_feat_' . $i . '_desc') ?: 'Control your lights intelligently with our advanced system.',
        'link' => get_option('virical_phone_feat_' . $i . '_link')
    ];
}

for ($i = 4; $i <= 6; $i++) {
    $features_right[] = [
        'icon' => get_option('virical_phone_feat_' . $i . '_icon') ?: 'https://cdn-icons-png.flaticon.com/512/639/639394.png',
        'title' => get_option('virical_phone_feat_' . $i . '_title') ?: 'Advanced Mode ' . ($i-3),
        'desc' => get_option('virical_phone_feat_' . $i . '_desc') ?: 'Customize scenes and schedules for perfect ambiance.',
        'link' => get_option('virical_phone_feat_' . $i . '_link')
    ];
}
?>

<section class="phone-reveal-section" id="phone-reveal-trigger" style="<?php echo $bg_img ? 'background-image: url(' . esc_url($bg_img) . ');' : ''; ?>">
    <div class="phone-reveal-sticky-wrapper">
        <div class="phone-reveal-container">
            <!-- Title Text (appears above phone, shrinks when scrolling) -->
            <div class="phone-title">
                <h2>APP THÔNG MINH</h2>
            </div>
            
            <!-- Center Logo (fades in when features spread) -->
            <div class="phone-center-logo">
                <img src="<?php echo esc_url($center_logo); ?>" alt="Smart Home Logo">
            </div>
            
            <!-- Center Phone -->
            <div class="phone-center">
                <img src="<?php echo esc_url($phone_img); ?>" alt="Smart Control">
            </div>

            <!-- Left Features -->
            <div class="features-group features-left">
                <?php foreach ($features_left as $index => $feat) : ?>
                    <div class="feature-item feature-item-left-<?php echo $index; ?>">
                        <?php if($feat['link']): ?><a href="<?php echo esc_url($feat['link']); ?>" class="feature-link"><?php endif; ?>
                        
                        <div class="feature-icon">
                            <img src="<?php echo esc_url($feat['icon']); ?>" alt="<?php echo esc_attr($feat['title']); ?>">
                        </div>
                        <div class="feature-content">
                            <h3><?php echo esc_html($feat['title']); ?></h3>
                            <p><?php echo esc_html($feat['desc']); ?></p>
                        </div>

                        <?php if($feat['link']): ?></a><?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Right Features -->
            <div class="features-group features-right">
                <?php foreach ($features_right as $index => $feat) : ?>
                    <div class="feature-item feature-item-right-<?php echo $index; ?>">
                        <?php if($feat['link']): ?><a href="<?php echo esc_url($feat['link']); ?>" class="feature-link"><?php endif; ?>
                        
                        <div class="feature-content">
                            <h3><?php echo esc_html($feat['title']); ?></h3>
                            <p><?php echo esc_html($feat['desc']); ?></p>
                        </div>
                        <div class="feature-icon">
                            <img src="<?php echo esc_url($feat['icon']); ?>" alt="<?php echo esc_attr($feat['title']); ?>">
                        </div>

                        <?php if($feat['link']): ?></a><?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<style>
.phone-reveal-section {
    position: relative;
    width: 100%;
    /* Create scroll space */
    height: 300vh; 
    background-color: #f8f9fa;
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    z-index: 10;
    overflow: visible; /* Ensure content isn't clipped */
}

.phone-reveal-sticky-wrapper {
    position: sticky;
    top: 0;
    height: 100vh;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.phone-reveal-container {
    position: relative;
    width: 100%;
    max-width: 1400px;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    perspective: 1000px;
}

.phone-title {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 25;
    text-align: center;
    transition: all 0.3s ease-out;
    opacity: 1;
}

.phone-title h2 {
    font-size: 3.5rem;
    font-weight: 700;
    color: #333;
    letter-spacing: 3px;
    margin: 0;
    text-transform: uppercase;
    font-family: 'Montserrat', sans-serif;
}

.phone-center-logo {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 25; /* Above phone for testing */
    opacity: 1.0; /* Fully visible for testing */
    transition: opacity 0.5s ease-out;
    width: 150px; /* Increased from 120px */
    height: 150px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 0, 0, 0.1); /* Red tint for debugging */
}

.phone-center-logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    filter: drop-shadow(0 10px 40px rgba(0,0,0,0.3));
}

.phone-center {
    position: relative;
    z-index: 20;
    transition: transform 0.1s ease-out;
    width: 700px; /* Optimized size for best visibility */
    height: auto;
    filter: drop-shadow(0 30px 60px rgba(0,0,0,0.3));
}

.phone-center img {
    width: 100%;
    height: auto;
    display: block;
}

.features-group {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 450px; /* Increased from 380px */
    display: flex;
    flex-direction: column;
    gap: 60px; /* Reduced from 80px for tighter spacing */
    z-index: 10;
}

.features-left {
    left: 50%; /* Start at center behind phone */
    align-items: flex-end;
    text-align: right;
    margin-left: -350px; /* Offset to center */
}

.features-right {
    right: 50%; /* Start at center behind phone */
    align-items: flex-start;
    text-align: left;
    margin-right: -350px; /* Offset to center */
}

.feature-item {
    opacity: 0;
    display: flex;
    align-items: center;
    gap: 25px; /* Increased from 20px */
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    padding: 25px 30px; /* Increased from 20px 25px */
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    transition: all 0.5s ease-out;
    /* Initial state: hidden behind phone */
    transform: scale(0.5) translateZ(-100px); 
    border: 1px solid rgba(255,255,255,0.5);
    width: 100%;
}

.features-left .feature-item {
    flex-direction: row; /* Icon Right, Text Left */
    transform-origin: right center;
}

.features-right .feature-item {
    flex-direction: row-reverse; /* Icon Left, Text Right */
    transform-origin: left center;
}

.feature-link {
    display: flex;
    align-items: center;
    gap: 20px;
    text-decoration: none;
    color: inherit;
    width: 100%;
}

.features-right .feature-link {
    flex-direction: row-reverse;
}

.feature-icon {
    width: 60px; /* Increased from 50px */
    height: 60px; /* Increased from 50px */
    /* background: #000; */
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    padding: 10px; /* Increased from 8px */
    background: #f0f0f0;
}

.feature-icon img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.feature-content h3 {
    font-size: 18px; /* Increased from 16px */
    font-weight: 700;
    margin: 0 0 8px; /* Increased margin */
    color: #222;
    font-family: 'Montserrat', sans-serif;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.feature-content p {
    font-size: 14px; /* Increased from 13px */
    color: #666;
    margin: 0;
    line-height: 1.6; /* Increased from 1.5 */
    font-weight: 400;
}

/* Mobile Adjustments */
@media (max-width: 991px) {
    .phone-reveal-section {
        height: auto; /* Remove scroll effect on mobile if too complex */
        padding: 80px 0;
        background-attachment: scroll;
    }
    
    .phone-reveal-sticky-wrapper {
        position: relative;
        height: auto;
        flex-direction: column;
        top: auto;
    }
    
    .phone-title {
        position: relative;
        top: auto;
        margin-bottom: 30px;
        opacity: 1 !important;
        transform: none !important;
    }
    
    .phone-title h2 {
        font-size: 2rem;
    }
    
    .phone-center {
        margin-bottom: 60px;
        width: 220px;
    }
    
    .features-group {
        position: relative;
        top: auto;
        left: auto;
        right: auto;
        transform: none;
        width: 100%;
        max-width: 500px;
        padding: 0 20px;
        margin: 0 auto;
        gap: 30px;
    }
    
    .features-left {
        margin-bottom: 30px;
    }
    
    .features-left, .features-right {
        align-items: center;
        text-align: center;
        margin-left: 0;
        margin-right: 0;
    }
    
    .feature-item {
        opacity: 1;
        transform: none;
        width: 100%;
        justify-content: center;
        flex-direction: column !important;
        text-align: center;
        gap: 15px;
    }
    
    .feature-link, .features-right .feature-link {
        flex-direction: column !important;
        gap: 15px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Only run on desktop/tablet > 991px
    if (window.innerWidth <= 991) return;

    const section = document.querySelector('.phone-reveal-section');
    const container = document.querySelector('.phone-reveal-container');
    const leftFeatures = document.querySelectorAll('.features-left .feature-item');
    const rightFeatures = document.querySelectorAll('.features-right .feature-item');
    const phone = document.querySelector('.phone-center');

    if (!section) return;

    // Use IntersectionObserver for smoother activation
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                window.addEventListener('scroll', handleScroll, { passive: true });
            } else {
                window.removeEventListener('scroll', handleScroll);
            }
        });
    }, { threshold: 0 });

    observer.observe(section);

    function handleScroll() {
        const rect = section.getBoundingClientRect();
        const viewportHeight = window.innerHeight;
        
        // Ensure calculations are safe
        const start = 0; 
        const end = rect.height - viewportHeight; 
        
        if (end <= 0) return;

        // Current scroll position relative to the section start
        const scrollY = -rect.top;
        
        // Calculate raw progress
        let rawProgress = scrollY / end;
        
        // Clamp progress between 0 and 1
        let progress = Math.min(Math.max(rawProgress, 0), 1);
        
        // Debugging
        // console.log('Scroll:', scrollY, 'End:', end, 'Progress:', progress);

        // Apply animations
        
        // 0. Title Animation (Fade out and shrink as features appear)
        const title = document.querySelector('.phone-title');
        if (title) {
            // Title disappears in first 30% of scroll
            const titleProgress = Math.min(progress / 0.3, 1);
            const titleOpacity = 1 - titleProgress;
            const titleScale = 1 - (titleProgress * 0.5); // Shrink to 50%
            const titleY = titleProgress * -50; // Move up 50px
            
            title.style.opacity = titleOpacity;
            // Keep translate(-50%, -50%) for centering, add scale and translateY
            title.style.transform = `translate(-50%, calc(-50% + ${titleY}px)) scale(${titleScale})`;
            title.style.zIndex = titleProgress > 0.5 ? 15 : 25; // Move behind phone halfway
        }
        
        // 0.5. Center Logo Animation (Fade in as features spread)
        const centerLogo = document.querySelector('.phone-center-logo');
        if (centerLogo) {
            // Logo appears between 10% and 40% of scroll (earlier than before)
            const logoStart = 0.1;
            const logoEnd = 0.4;
            let logoProgress = 0;
            
            if (progress < logoStart) {
                logoProgress = 0;
            } else if (progress > logoEnd) {
                logoProgress = 1;
            } else {
                logoProgress = (progress - logoStart) / (logoEnd - logoStart);
            }
            
            // Fade from 0.3 to 1.0
            centerLogo.style.opacity = 0.3 + (logoProgress * 0.7);
        }
        
        // 1. Phone Animation (Subtle Scale & Rotate)
        if (phone) {
            phone.style.transform = `scale(${1 + progress * 0.05}) rotateY(${progress * 5}deg)`;
        }
        
        // 2. Features Reveal Animation
        // Spread distance in pixels (reduced to bring cards closer)
        const spreadDistanceX = 350; // Reduced from 450px
        const spreadDistanceY = 40; // Reduced from 50px
        
        leftFeatures.forEach((item, index) => {
            // Stagger delay based on index (0, 1, 2)
            // Normalized range for this item's animation
            const startP = index * 0.15;
            const endP = 0.6 + (index * 0.1); 
            
            let itemProgress = (progress - startP) / (endP - startP);
            itemProgress = Math.min(Math.max(itemProgress, 0), 1);
            
            // Easing
            const eased = itemProgress < 0.5 ? 2 * itemProgress * itemProgress : 1 - Math.pow(-2 * itemProgress + 2, 2) / 2;
            
            const x = -spreadDistanceX * eased;
            const y = (index - 1) * spreadDistanceY * eased; // -Y, 0, +Y
            
            item.style.opacity = eased;
            item.style.transform = `translate3d(${x}px, ${y}px, 0) scale(${0.8 + 0.2 * eased})`;
        });
        
        rightFeatures.forEach((item, index) => {
            const startP = index * 0.15;
            const endP = 0.6 + (index * 0.1);
            
            let itemProgress = (progress - startP) / (endP - startP);
            itemProgress = Math.min(Math.max(itemProgress, 0), 1);
            
            // Easing
            const eased = itemProgress < 0.5 ? 2 * itemProgress * itemProgress : 1 - Math.pow(-2 * itemProgress + 2, 2) / 2;
            
            const x = spreadDistanceX * eased;
            const y = (index - 1) * spreadDistanceY * eased;
            
            item.style.opacity = eased;
            item.style.transform = `translate3d(${x}px, ${y}px, 0) scale(${0.8 + 0.2 * eased})`;
        });
    }
    
    // Initial trigger to set positions if loaded mid-page
    handleScroll();
});
</script>