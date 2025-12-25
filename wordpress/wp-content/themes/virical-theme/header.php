<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <!-- Google Font - Quicksand & Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <?php
    wp_head();

    // Load custom menu renderer
    require_once get_template_directory() . '/includes/virical-menu-render.php';
    ?>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            font-family: 'Quicksand', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            padding-top: 70px; 
        }

        /* Header */
        .site-header { 
            position: fixed; 
            top: 0; 
            left: 0; 
            right: 0; 
            z-index: 1000; 
            background: transparent; 
            border-bottom: none; 
            box-shadow: none; 
            transform: translateY(0); 
            transition: all 0.3s ease-in-out; 
        }
        .site-header.scrolled {
            background: rgba(248, 248, 248, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #e0e0e0; 
            box-shadow: 0 1px 3px rgba(0,0,0,0.1); 
        }
        
        .nav-container { 
            max-width: 1280px; 
            margin: 0 auto; 
            padding: 15px 20px; 
            display: flex; 
            align-items: center; 
            justify-content: center; /* Center the navigation */
            position: relative;
            min-height: 70px;
        }
        
        .brand { 
            display: flex; 
            flex-direction: column;
            align-items: center; 
            color: #333; /* Always black */
            text-decoration: none; 
            position: absolute; 
            left: 20px; 
            transition: all 0.3s ease;
        }
        
        .logo-text {
            font-size: 20px;
            letter-spacing: 2px;
            color: inherit;
            font-weight: 700;
            line-height: 1.2;
            text-shadow: 0 0 10px rgba(255,255,255,0.9), 0 0 20px rgba(255,255,255,0.7);
        }
        
        .logo-tagline {
            font-size: 9px;
            letter-spacing: 1px;
            color: inherit;
            margin-top: 1px;
            text-transform: uppercase;
            text-shadow: 0 0 8px rgba(255,255,255,0.9);
        }

        .nav { 
            display: flex; 
            align-items: center; 
            gap: 5px; 
            background: #f0f0f0; 
            border-radius: 30px; 
            padding: 8px 12px; 
        }
        
        /* WordPress Menu Support */
        .nav ul {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
            gap: 5px;
        }
        
        .nav a { 
            color: #333; 
            text-decoration: none; 
            font-size: 14px; 
            font-weight: 500; 
            padding: 8px 16px; 
            border-radius: 20px; 
            transition: all 0.2s ease; 
            white-space: nowrap; 
            display: block;
            background: transparent;
        }
        
        .nav a:hover { 
            color: #000; 
            background: rgba(255, 255, 255, 0.1); 
        }
        
        /* Active menu item styling */
        .nav .current-menu-item > a,
        .nav .current_page_item > a { 
            color: #fff !important; 
            background: #333 !important; 
            border-radius: 25px !important;
        }

        /* Dropdown Submenu Styles */
        .nav .menu-item {
            position: relative;
        }

        .nav .sub-menu {
            position: absolute;
            top: 100%;
            left: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            min-width: 200px;
            padding: 10px 0;
            display: none;
            flex-direction: column;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            border-radius: 10px;
            z-index: 1000;
            margin-top: 5px;
        }

        .nav .menu-item:hover > .sub-menu {
            display: flex;
        }

        .nav .sub-menu a {
            padding: 10px 20px;
            font-size: 13px;
            border-radius: 0;
            background: transparent;
            color: #333;
        }

        .nav .sub-menu a:hover {
            background: rgba(0, 0, 0, 0.05);
            color: #000;
        }

        /* MEGA MENU Styles - Grid Layout with Icons */
        .mega-menu {
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            min-width: 700px;
            max-width: 900px;
            padding: 30px 20px;
            display: none;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            border-radius: 12px;
            z-index: 1000;
            margin-top: 5px;
            opacity: 0;
            transition: opacity 0.3s ease, visibility 0s linear 0.5s;
            visibility: hidden;
        }

        .menu-item-has-children:hover .mega-menu {
            display: block;
            opacity: 1;
            visibility: visible;
            transition: opacity 0.3s ease, visibility 0s linear 0s;
        }
        
        /* Keep mega menu visible when hovering over it */
        .mega-menu:hover {
            opacity: 1;
            visibility: visible;
            transition: opacity 0.3s ease, visibility 0s linear 0s;
        }

        .mega-menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(100px, 120px));
            gap: 20px;
            align-items: start;
            justify-content: center;
        }

        .mega-menu-item {
            text-align: center;
        }

        .mega-menu-item-link {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .mega-menu-item-link:hover .mega-menu-item-icon {
            transform: translateY(-5px);
        }

        .mega-menu-item-icon {
            width: 60px;
            height: 60px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: transparent;
            border-radius: 50%;
            padding: 12px;
            transition: all 0.3s ease;
        }

        .mega-menu-item-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .mega-menu-item-name {
            font-size: 12px;
            color: #666;
            font-weight: 400;
            line-height: 1.4;
            transition: color 0.3s ease;
            max-width: 100px;
        }

        .mega-menu-item-link:hover .mega-menu-item-name {
            color: #ff6b00;
        }

        /* Mobile */
        .menu-toggle { 
            display: none; 
            width: 36px; 
            height: 36px; 
            border: 1px solid #333; 
            border-radius: 8px; 
            background: transparent; 
            color: #333; 
            align-items: center; 
            justify-content: center; 
            cursor: pointer;
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
        }
        
        @media (max-width: 820px) {
            .nav { 
                display: none; 
                position: absolute; 
                top: 65px; 
                right: 20px; 
                background: #fff; 
                border: 1px solid #e0e0e0; 
                border-radius: 10px; 
                padding: 12px 14px; 
                flex-direction: column; 
                min-width: 200px; 
                box-shadow: 0 10px 30px rgba(0,0,0,.1); 
            }
            
            .nav ul {
                flex-direction: column;
                width: 100%;
                gap: 5px;
            }
            
            .nav.show { 
                display: flex; 
            }
            
            .menu-toggle { 
                display: inline-flex; 
            }
            
            .nav .sub-menu {
                position: static;
                box-shadow: none;
                padding-left: 15px;
                display: block; /* Show submenus on mobile */
            }
        }
    </style>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header" id="site-header">
    <div class="nav-container">
        <a href="<?php echo home_url('/'); ?>" class="brand" aria-label="Virical Home">
            <div style="width: 200px !important; height: 60px !important; overflow: hidden !important; position: relative; display: block;">
                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/virical-logo.svg' ); ?>" 
                     style="position: absolute !important; top: -589px !important; left: -282px !important; width: 497px !important; height: auto !important; max-width: none !important;"
                     alt="Virical Logo">
            </div>
        </a>
        
        <nav class="nav" id="siteNav" aria-label="Main Navigation">
            <?php
            // Render custom Virical navigation menu
            virical_render_navigation_menu('primary', 'main-nav');
            ?>
        </nav>
        
        <button class="menu-toggle" id="menuBtn" aria-label="Toggle menu">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3 6h18M3 12h18M3 18h18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </button>
    </div>
</header>

<script>
    // Mobile menu toggle
    const nav = document.getElementById('siteNav');
    const btn = document.getElementById('menuBtn');
    btn?.addEventListener('click', () => nav.classList.toggle('show'));
    
    // Header scroll background effect (removed auto-hide)
    const header = document.getElementById('site-header');
    
    window.addEventListener('scroll', function() {
        let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        // Toggle scrolled class for transparency
        if (scrollTop > 20) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });
</script>