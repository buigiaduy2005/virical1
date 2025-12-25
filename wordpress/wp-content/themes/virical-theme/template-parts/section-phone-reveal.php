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
    background-color: #FFFFFF;
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
        height: 200vh;
        padding: 0;
        background-attachment: scroll;
    }
    
    .phone-reveal-sticky-wrapper {
        position: sticky;
        height: 100vh;
        top: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    
    .phone-reveal-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 100%;
        max-width: 350px;
        height: auto;
        gap: 15px;
        padding: 20px;
        perspective: none;
    }
    
    .phone-title {
        position: relative !important;
        top: auto !important;
        left: auto !important;
        transform: none !important;
        margin: 0 0 10px 0;
        text-align: center;
        width: 100%;
    }
    
    .phone-title h2 {
        font-size: 1.4rem;
    }
    
    .phone-center-logo {
        display: none;
    }
    
    .phone-center {
        position: relative !important;
        width: 120px !important;
        max-width: 120px !important;
        margin: 0 auto 15px !important;
        filter: drop-shadow(0 10px 20px rgba(0,0,0,0.15));
    }
    
    .features-group {
        position: relative !important;
        top: auto !important;
        left: auto !important;
        right: auto !important;
        transform: none !important;
        width: 100% !important;
        max-width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
        gap: 8px !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
    }
    
    .features-left,
    .features-right {
        position: relative !important;
        left: auto !important;
        right: auto !important;
        width: 100% !important;
        display: flex !important;
        flex-direction: column !important;
        gap: 8px !important;
        align-items: center !important;
        margin: 0 !important;
    }
    
    .feature-item {
        opacity: 0;
        transform: translateY(20px);
        width: 100% !important;
        max-width: 100% !important;
        justify-content: flex-start !important;
        flex-direction: row !important;
        text-align: left !important;
        gap: 10px !important;
        padding: 12px !important;
        border-radius: 10px !important;
        margin: 0 !important;
        background: rgba(255,255,255,0.95);
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    
    .features-left .feature-item,
    .features-right .feature-item {
        flex-direction: row !important;
    }
    
    .feature-link,
    .features-right .feature-link {
        flex-direction: row !important;
        gap: 10px !important;
        width: 100%;
    }
    
    .feature-icon {
        width: 40px !important;
        height: 40px !important;
        min-width: 40px !important;
        padding: 6px !important;
    }
    
    .feature-content h3 {
        font-size: 13px !important;
        margin-bottom: 2px !important;
    }
    
    .feature-content p {
        font-size: 11px !important;
        line-height: 1.3 !important;
    }
}

/* Extra small screens */
@media (max-width: 480px) {
    .phone-reveal-section {
        padding: 40px 10px;
    }
    
    .phone-title h2 {
        font-size: 1.2rem;
    }
    
    .phone-center {
        width: 150px !important;
        max-width: 150px !important;
    }
    
    .feature-item {
        padding: 12px;
        gap: 10px;
    }
    
    .feature-icon {
        width: 40px;
        height: 40px;
        min-width: 40px;
    }
    
    .feature-content h3 {
        font-size: 13px;
    }
    
    .feature-content p {
        font-size: 11px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const section = document.querySelector('.phone-reveal-section');
    const leftFeatures = document.querySelectorAll('.features-left .feature-item');
    const rightFeatures = document.querySelectorAll('.features-right .feature-item');
    const phone = document.querySelector('.phone-center');
    const title = document.querySelector('.phone-title');
    const centerLogo = document.querySelector('.phone-center-logo');

    if (!section) return;

    const isMobile = window.innerWidth <= 991;

    function handleScroll() {
        const rect = section.getBoundingClientRect();
        const viewportHeight = window.innerHeight;
        
        const start = 0; 
        const end = rect.height - viewportHeight; 
        
        if (end <= 0) return;

        const scrollY = -rect.top;
        let rawProgress = scrollY / end;
        let progress = Math.min(Math.max(rawProgress, 0), 1);

        // Title Animation
        if (title) {
            const titleProgress = Math.min(progress / 0.3, 1);
            const titleOpacity = 1 - titleProgress;
            const titleScale = 1 - (titleProgress * 0.5);
            const titleY = titleProgress * -50;
            
            title.style.opacity = titleOpacity;
            title.style.transform = `translate(-50%, calc(-50% + ${titleY}px)) scale(${titleScale})`;
            title.style.zIndex = titleProgress > 0.5 ? 15 : 25;
        }
        
        // Center Logo Animation
        if (centerLogo) {
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
            
            centerLogo.style.opacity = 0.3 + (logoProgress * 0.7);
        }
        
        // Phone Animation
        if (phone) {
            if (isMobile) {
                // Mobile: just subtle scale
                phone.style.transform = `scale(${1 + progress * 0.02})`;
            } else {
                phone.style.transform = `scale(${1 + progress * 0.05}) rotateY(${progress * 5}deg)`;
            }
        }
        
        // Features Animation
        if (isMobile) {
            // Mobile: Simple fade in with translateY
            const featuresStart = 0.15;
            const featuresEnd = 0.6;
            let featProgress = (progress - featuresStart) / (featuresEnd - featuresStart);
            featProgress = Math.min(Math.max(featProgress, 0), 1);
            
            const eased = featProgress < 0.5 ? 2 * featProgress * featProgress : 1 - Math.pow(-2 * featProgress + 2, 2) / 2;
            const opacity = eased;
            const translateY = 20 * (1 - eased); // 20px -> 0px
            
            leftFeatures.forEach(item => {
                item.style.opacity = opacity;
                item.style.transform = `translateY(${translateY}px)`;
            });
            
            rightFeatures.forEach(item => {
                item.style.opacity = opacity;
                item.style.transform = `translateY(${translateY}px)`;
            });
        } else {
            // Desktop: horizontal spread with stagger
            const spreadDistanceX = 350;
            const spreadDistanceY = 40;
            
            leftFeatures.forEach((item, index) => {
                const startP = index * 0.15;
                const endP = 0.6 + (index * 0.1); 
                
                let itemProgress = (progress - startP) / (endP - startP);
                itemProgress = Math.min(Math.max(itemProgress, 0), 1);
                
                const eased = itemProgress < 0.5 ? 2 * itemProgress * itemProgress : 1 - Math.pow(-2 * itemProgress + 2, 2) / 2;
                
                const x = -spreadDistanceX * eased;
                const y = (index - 1) * spreadDistanceY * eased;
                
                item.style.opacity = eased;
                item.style.transform = `translate3d(${x}px, ${y}px, 0) scale(${0.8 + 0.2 * eased})`;
            });
            
            rightFeatures.forEach((item, index) => {
                const startP = index * 0.15;
                const endP = 0.6 + (index * 0.1);
                
                let itemProgress = (progress - startP) / (endP - startP);
                itemProgress = Math.min(Math.max(itemProgress, 0), 1);
                
                const eased = itemProgress < 0.5 ? 2 * itemProgress * itemProgress : 1 - Math.pow(-2 * itemProgress + 2, 2) / 2;
                
                const x = spreadDistanceX * eased;
                const y = (index - 1) * spreadDistanceY * eased;
                
                item.style.opacity = eased;
                item.style.transform = `translate3d(${x}px, ${y}px, 0) scale(${0.8 + 0.2 * eased})`;
            });
        }
    }

    // Add scroll listener
    window.addEventListener('scroll', handleScroll, { passive: true });
    
    // Initial trigger
    handleScroll();
});
</script>