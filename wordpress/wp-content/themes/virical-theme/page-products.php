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

// Build query
$query = "SELECT * FROM {$wpdb->prefix}virical_products WHERE is_active = 1";
if ($selected_category) {
    $query .= $wpdb->prepare(" AND category = %s", $selected_category);
}
$query .= " ORDER BY is_featured DESC, sort_order, id DESC";

$products = $wpdb->get_results($query);

// Group products by category if no filter
$products_by_category = [];
if (!$selected_category) {
    foreach ($products as $product) {
        $products_by_category[$product->category][] = $product;
    }
}
?>

<style>
    /* Reset & Base */
    :root {
      --bg: #0b0b0b;
      --text: #eaeaea;
      --muted: #a9a9a9;
      --accent: #ffd36a;
      --border: #1f1f1f;
    }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    
    .products-page-container { 
        font-family: 'Segoe UI', Roboto, Arial, sans-serif; 
        color: #333; 
        background: #fff;
    }

    /* Products Section */
    .products-section { padding: 60px 0; background: #f8f9fa; }
    .products-container { max-width: 1700px; margin: 0 auto; padding: 0 40px; }
    .products-grid { display: flex; flex-direction: column; gap: 0; }
    
    .product-item { 
      background: #fff; 
      border-radius: 0;
      overflow: hidden; 
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      border: none;
      border-bottom: 2px solid black;
      display: flex;
      align-items: center;
      padding: 30px 0;
      margin-bottom: 0;
      position: relative;
    }
    .product-item:last-child {
      border-bottom: none;
    }
    .product-item:hover { 
      transform: none; 
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .product-image { 
      width: 600px; 
      height: 400px; 
      flex-shrink: 0;
      overflow: hidden; 
      background: #f5f5f5;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .product-image img { 
      width: 100%; 
      height: 100%; 
      object-fit: cover; 
      transition: transform 0.3s ease;
    }
    .product-item:hover .product-image img { transform: scale(1.02); }
    
    .product-info { 
      padding: 40px 60px; 
      text-align: left;
      flex: 1;
    }
    .product-info h3 { 
      color: #333; 
      font-size: 1.5rem; 
      font-weight: 600; 
      margin-bottom: 12px;
      letter-spacing: 0.5px;
    }
    .product-info p { 
      color: #666; 
      font-size: 1rem; 
      line-height: 1.6; 
      margin-bottom: 20px;
    }
    .product-link { 
      display: inline-block;
      color: #ff6b35; 
      text-decoration: none; 
      font-size: 0.9rem; 
      font-weight: 600;
      letter-spacing: 1px;
      border: 1px solid #ff6b35;
      padding: 8px 16px;
      border-radius: 4px;
      transition: all 0.2s ease;
    }
    .product-link:hover { 
      background: #ff6b35;
      color: #fff;
    }

    /* Category Section Header */
    .section-header {
        margin-bottom: 30px;
        padding-bottom: 10px;
        border-bottom: 1px solid #e0e0e0;
    }
    .section-title {
        font-size: 2rem;
        font-weight: 700;
        color: #333;
        text-transform: uppercase;
    }

    /* Responsive */
    @media (max-width: 991px) {
        .product-item {
            flex-direction: column;
            align-items: flex-start;
        }
        .product-image {
            width: 100%;
            height: 300px;
        }
        .product-info {
            padding: 30px;
            width: 100%;
        }
    }

    @media (max-width: 768px) {
      .products-section { padding: 40px 16px; }
      .products-container { padding: 0 20px; }
      .product-image { height: 250px; }
      .section-title { font-size: 1.5rem; }
    }
</style>

<div class="products-page-container">
    
    <!-- Products Section -->
    <section class="products-section">
        <div class="products-container">
            <?php if ($selected_category): ?>
                <!-- Single Category View -->
                <div class="products-grid">
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <div class="product-item">
                                <div class="product-image">
                                    <img src="<?php echo esc_url($product->image_url); ?>" alt="<?php echo esc_attr($product->name); ?>">
                                </div>
                                <div class="product-info">
                                    <h3><?php echo esc_html($product->name); ?></h3>
                                    <p><?php echo esc_html(!empty($product->short_description) ? $product->short_description : $product->description); ?></p>
                                    <a href="<?php echo home_url('/san-pham/' . $product->slug . '/'); ?>" class="product-link">XEM CHI TIẾT</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="no-products">
                            <p>Không có sản phẩm nào trong danh mục này.</p>
                        </div>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <!-- All Categories View -->
                <?php foreach ($categories as $category): ?>
                    <?php if (isset($products_by_category[$category->slug]) && !empty($products_by_category[$category->slug])): ?>
                        <div class="category-section">
                            <div class="section-header">
                                <h2 class="section-title"><?php echo esc_html($category->name); ?></h2>
                            </div>
                            <div class="products-grid">
                                <?php foreach ($products_by_category[$category->slug] as $product): ?>
                                    <div class="product-item">
                                        <div class="product-image">
                                            <img src="<?php echo esc_url($product->image_url); ?>" alt="<?php echo esc_attr($product->name); ?>">
                                        </div>
                                        <div class="product-info">
                                            <h3><?php echo esc_html($product->name); ?></h3>
                                            <p><?php echo esc_html(!empty($product->short_description) ? $product->short_description : $product->description); ?></p>
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

<?php get_footer(); ?>