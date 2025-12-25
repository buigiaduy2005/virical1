<?php
/**
 * Template Name: Products Page
 * 
 * @package Virical
 */

get_header();

global $wpdb;

// Get all active categories
$categories = $wpdb->get_results("
    SELECT * FROM {$wpdb->prefix}virical_product_categories 
    WHERE is_active = 1 
    ORDER BY sort_order, name
");

// Get selected category from URL
$selected_category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';

// Organize categories into a tree structure for later use
$category_tree = [];
$categories_by_id = [];
$categories_by_slug = [];

foreach ($categories as $cat) {
    $cat->children = [];
    $categories_by_id[$cat->id] = $cat;
    $categories_by_slug[$cat->slug] = $cat;
}

foreach ($categories as $cat) {
    if ($cat->parent_id != 0 && isset($categories_by_id[$cat->parent_id])) {
        $categories_by_id[$cat->parent_id]->children[] = $cat;
    } else {
        $category_tree[] = $cat;
    }
}

// Build query
$query = "SELECT * FROM {$wpdb->prefix}virical_products WHERE is_active = 1";
if ($selected_category) {
    $target_categories = [$selected_category];
    
    // If the selected category is a parent, include all its children's slugs
    if (isset($categories_by_slug[$selected_category])) {
        $parent_cat = $categories_by_slug[$selected_category];
        if (!empty($parent_cat->children)) {
            foreach ($parent_cat->children as $child) {
                $target_categories[] = $child->slug;
            }
        }
    }
    
    $placeholders = array_fill(0, count($target_categories), '%s');
    $query .= " AND category IN (" . implode(',', $placeholders) . ")";
    $products = $wpdb->get_results($wpdb->prepare($query, ...$target_categories));
} else {
    $query .= " ORDER BY is_featured DESC, sort_order, id DESC";
    $products = $wpdb->get_results($query);
}

// Group products by category for the "All" view
$products_by_category = [];
foreach ($products as $product) {
    $products_by_category[$product->category][] = $product;
}
?>

<style>
    /* Version: 2.0 - No Gray Background */
    :root {
      --sidebar-width: 300px;
      --accent-color: #ff6b35;
    }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    
    .products-page-container { 
        font-family: 'Segoe UI', Roboto, Arial, sans-serif; 
        color: #333; 
        background: #fff;
        position: relative;
    }

    /* Hamburger Toggle Button */
    .sidebar-toggle {
        position: fixed;
        top: 120px;
        left: 20px;
        width: 50px;
        height: 50px;
        background: #f0f0f0;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        z-index: 1001;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .sidebar-toggle.active {
        left: calc(var(--sidebar-width) + 20px);
    }
    .sidebar-toggle span {
        display: block;
        width: 24px;
        height: 3px;
        background: #333;
        border-radius: 2px;
        transition: all 0.3s ease;
    }
    .sidebar-toggle.active span:nth-child(1) { transform: rotate(45deg) translate(7px, 7px); }
    .sidebar-toggle.active span:nth-child(2) { opacity: 0; }
    .sidebar-toggle.active span:nth-child(3) { transform: rotate(-45deg) translate(7px, -7px); }

    /* Sidebar */
    .category-sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: var(--sidebar-width);
        height: 100vh;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(15px);
        box-shadow: 2px 0 20px rgba(0,0,0,0.1);
        border-right: 1px solid #eee;
        transform: translateX(-100%);
        transition: transform 0.3s ease;
        z-index: 1000;
        overflow-y: auto;
        padding: 80px 0 20px 0;
    }
    .category-sidebar.active { transform: translateX(0); }
    
    .sidebar-header {
        padding: 15px 20px;
        border-bottom: 2px solid #f0f0f0;
        margin-bottom: 5px;
    }
    .sidebar-header h3 {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
        text-transform: uppercase;
    }

    /* Category List */
    .category-list { list-style: none; padding: 0; margin: 0; }
    .category-item { border-bottom: 1px solid #f0f0f0; }
    
    .category-link-wrapper {
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.2s ease;
    }
    
    .category-link {
        flex: 1;
        display: block;
        padding: 5px 20px;
        color: #333;
        text-decoration: none;
        font-size: 0.95rem;
        font-weight: 500;
        line-height: 1.1;
    }
    
    .category-item.active-parent > .category-link-wrapper {
        background: #f8f9fa;
    }
    
    .category-link.active {
        color: var(--accent-color);
        font-weight: 700;
    }
    
    .category-toggle {
        padding: 5px 20px;
        cursor: pointer;
        color: #999;
        transition: transform 0.3s ease;
        line-height: 1.1;
    }
    
    .category-item.expanded .category-toggle {
        transform: rotate(90deg);
    }

    /* Subcategories */
    .subcategory-list {
        list-style: none;
        padding: 0;
        margin: 0;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s ease;
        background: #fcfcfc;
    }
    .category-item.expanded .subcategory-list {
        max-height: 1000px;
    }
    .subcategory-link {
        display: block;
        padding: 2px 2px 2px 2px;
        color: #666;
        text-decoration: none;
        font-size: 0.9rem;
        border-left: 3px solid transparent;
        line-height: 1.1;
    }
    .subcategory-link:hover { background: #f0f0f0; color: #000; }
    .subcategory-link.active {
        background: #fff5f0;
        color: var(--accent-color);
        border-left-color: var(--accent-color);
        font-weight: 600;
    }

    /* Products Grid */
    .products-section { 
        padding: 60px 0; 
        background: #f8f9fa;
        transition: margin-left 0.3s ease;
    }
    .products-section.sidebar-open { margin-left: var(--sidebar-width); }
    .products-container { max-width: 1400px; margin: 0 auto; padding: 0 40px; }
    
    .product-item { 
      background: #fff; 
      display: flex;
      align-items: center;
      padding: 30px;
      margin-bottom: 30px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      border-radius: 12px;
      transition: transform 0.3s ease;
    }
    .product-item:hover { transform: translateY(-5px); }
    
    .product-image { 
      width: 400px; 
      height: 300px; 
      flex-shrink: 0;
      overflow: hidden; 
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .product-image img { 
      max-width: 100%; 
      max-height: 100%; 
      object-fit: contain; 
    }
    
    .product-info { padding: 0 40px; flex: 1; }
    .product-info h3 { font-size: 1.8rem; margin-bottom: 15px; color: #222; }
    .product-info p { color: #666; line-height: 1.6; margin-bottom: 25px; }
    
    .product-link { 
      display: inline-block;
      color: var(--accent-color); 
      text-decoration: none; 
      font-weight: 600;
      border: 2px solid var(--accent-color);
      padding: 10px 25px;
      border-radius: 50px;
      transition: all 0.3s ease;
    }
    .product-link:hover { background: var(--accent-color); color: #fff; }

    /* Responsive */
    @media (max-width: 1100px) {
        .product-item { flex-direction: column; padding: 20px; }
        .product-image { width: 100%; height: 250px; }
        .product-info { padding: 20px 0 0 0; text-align: center; }
    }
    @media (max-width: 768px) {
        .products-container { padding: 0 20px; }
        .products-section.sidebar-open { margin-left: 0; }
    }
</style>

<div class="products-page-container">
    <button class="sidebar-toggle" id="sidebarToggle">
        <span></span><span></span><span></span>
    </button>

    <aside class="category-sidebar" id="categorySidebar">
        <div class="sidebar-header"><h3>Danh Mục</h3></div>
        <ul class="category-list">
            <li class="category-item">
                <a href="<?php echo get_permalink(); ?>" class="category-link <?php echo empty($selected_category) ? 'active' : ''; ?>">TẤT CẢ SẢN PHẨM</a>
            </li>
            <?php 
            foreach ($category_tree as $category): 
                $has_children = !empty($category->children);
                $is_current = ($selected_category === $category->slug);
                
                $is_expanded = $is_current;
                if ($has_children && !$is_expanded) {
                    foreach ($category->children as $child) {
                        if ($selected_category === $child->slug) {
                            $is_expanded = true;
                            break;
                        }
                    }
                }
            ?>
                <li class="category-item <?php echo $is_expanded ? 'expanded' : ''; ?> <?php echo $is_current ? 'active-parent' : ''; ?>">
                    <div class="category-link-wrapper">
                        <a href="<?php echo add_query_arg('category', $category->slug, get_permalink()); ?>" 
                           class="category-link <?php echo $is_current ? 'active' : ''; ?>">
                            <?php echo esc_html($category->name); ?>
                        </a>
                        <?php if ($has_children): ?>
                            <span class="category-toggle">›</span>
                        <?php endif; ?>
                    </div>
                    
                    <?php if ($has_children): ?>
                        <ul class="subcategory-list">
                            <?php foreach ($category->children as $sub_cat):
                                $is_sub_active = ($selected_category === $sub_cat->slug);
                            ?>
                                <li class="subcategory-item">
                                    <a href="<?php echo add_query_arg('category', $sub_cat->slug, get_permalink()); ?>" 
                                       class="subcategory-link <?php echo $is_sub_active ? 'active' : ''; ?>">
                                        <?php echo esc_html($sub_cat->name); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </aside>
    
    <section class="products-section">
        <div class="products-container">
            <?php 
            if ($selected_category): 
                $current_cat_name = isset($categories_by_slug[$selected_category]) ? $categories_by_slug[$selected_category]->name : 'Sản phẩm';
            ?>
                <div class="section-header">
                    <h2 class="section-title"><?php echo esc_html($current_cat_name); ?></h2>
                </div>
                <div class="products-grid">
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <div class="product-item">
                                <div class="product-image">
                                    <img src="<?php echo esc_url($product->image_url); ?>" alt="<?php echo esc_attr($product->name); ?>">
                                </div>
                                <div class="product-info">
                                    <h3><?php echo esc_html($product->name); ?></h3>
                                    <p><?php echo esc_html(!empty($product->description) ? $product->description : ''); ?></p>
                                    <a href="<?php echo home_url('/san-pham/' . $product->slug . '/'); ?>" class="product-link">XEM CHI TIẾT</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Không có sản phẩm nào.</p>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <?php foreach ($category_tree as $category): ?>
                    <?php if (isset($products_by_category[$category->slug]) || !empty($category->children)): 
                        // Collect all products for this parent (direct + children)
                        $cat_products = $products_by_category[$category->slug] ?? [];
                        foreach ($category->children as $child) {
                            if (isset($products_by_category[$child->slug])) {
                                $cat_products = array_merge($cat_products, $products_by_category[$child->slug]);
                            }
                        }
                        if (empty($cat_products)) continue;
                    ?>
                        <div class="category-section">
                            <div class="section-header">
                                <h2 class="section-title"><?php echo esc_html($category->name); ?></h2>
                            </div>
                            <div class="products-grid">
                                <?php foreach (array_slice($cat_products, 0, 5) as $product): ?>
                                    <div class="product-item">
                                        <div class="product-image">
                                            <img src="<?php echo esc_url($product->image_url); ?>" alt="<?php echo esc_attr($product->name); ?>">
                                        </div>
                                        <div class="product-info">
                                            <h3><?php echo esc_html($product->name); ?></h3>
                                            <p><?php echo esc_html($product->description); ?></p>
                                            <a href="<?php echo home_url('/san-pham/' . $product->slug . '/'); ?>" class="product-link">XEM CHI TIẾT</a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>
</div>

<script>
(function() {
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('categorySidebar');
        const productsSection = document.querySelector('.products-section');
        
        toggleBtn.addEventListener('click', () => {
            toggleBtn.classList.toggle('active');
            sidebar.classList.toggle('active');
            productsSection.classList.toggle('sidebar-open');
        });

        document.querySelectorAll('.category-toggle').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                btn.closest('.category-item').classList.toggle('expanded');
            });
        });
    });
})();
</script>

<?php get_footer(); ?>