<?php
/**
 * Products and Categories Admin Interface
 */

// Add admin menu
add_action('admin_menu', 'virical_add_products_menu');

function virical_add_products_menu() {
    add_menu_page(
        'Quản lý Sản phẩm',
        'Sản phẩm Virical',
        'manage_options',
        'virical-products',
        'virical_products_page',
        'dashicons-cart',
        30
    );
    
    add_submenu_page(
        'virical-products',
        'Danh mục sản phẩm',
        'Danh mục',
        'manage_options',
        'virical-categories',
        'virical_categories_page'
    );
}

// Products management page
function virical_products_page() {
    global $wpdb;
    
    // Handle actions
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'add_product' && check_admin_referer('virical_add_product')) {
            virical_add_product($_POST);
        } elseif ($_POST['action'] === 'update_product' && check_admin_referer('virical_update_product')) {
            virical_update_product($_POST);
        }
    }
    
    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
        if (check_admin_referer('delete_product_' . $_GET['id'])) {
            virical_delete_product($_GET['id']);
        }
    }
    
    // Get products
    $products = $wpdb->get_results("
        SELECT p.*, c.name as category_name 
        FROM {$wpdb->prefix}virical_products p
        LEFT JOIN {$wpdb->prefix}virical_product_categories c ON p.category = c.slug
        ORDER BY p.sort_order, p.id DESC
    ");
    
    $categories = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}virical_product_categories ORDER BY parent_id, sort_order");
    
    // Edit mode
    $edit_product = null;
    if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
        $edit_product = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}virical_products WHERE id = %d",
            $_GET['id']
        ));
        
        if ($edit_product && !empty($edit_product->gallery)) {
            $gallery_data = json_decode($edit_product->gallery, true);
            if (is_array($gallery_data)) {
                $edit_product->image_url_2 = $gallery_data[0] ?? '';
                $edit_product->image_url_3 = $gallery_data[1] ?? '';
                $edit_product->image_url_4 = $gallery_data[2] ?? '';
            }
        }
        
        if ($edit_product && !empty($edit_product->applications)) {
            $apps_data = json_decode($edit_product->applications, true);
            if (is_array($apps_data)) {
                for ($i = 1; $i <= 3; $i++) {
                    $idx = $i - 1;
                    $edit_product->{"app_img_$i"} = $apps_data[$idx]['image'] ?? '';
                    $edit_product->{"app_title_$i"} = $apps_data[$idx]['title'] ?? '';
                    $edit_product->{"app_desc_$i"} = $apps_data[$idx]['desc'] ?? '';
                }
            }
        }
    }
    ?>
    
    <style>
    .virical-admin-wrap { max-width: 1400px; }
    .virical-admin-wrap .card { max-width: none; margin-top: 20px; padding: 20px 30px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
    .virical-admin-wrap .form-table th { width: 200px; font-weight: 600; }
    .virical-admin-wrap .regular-text { width: 100%; max-width: 600px; }
    .virical-product-image-preview { max-width: 200px; margin-top: 10px; border: 1px solid #ddd; padding: 5px; background: #f5f5f5; }
    .virical-product-image-preview img { max-width: 100%; height: auto; }
    </style>
    
    <div class="wrap virical-admin-wrap">
        <h1><?php echo $edit_product ? 'Sửa sản phẩm' : 'Quản lý Sản phẩm'; ?></h1>
        
        <div class="card" id="product-form">
            <h2><?php echo $edit_product ? 'Sửa sản phẩm: ' . esc_html($edit_product->name) : 'Thêm sản phẩm mới'; ?></h2>
            <form method="post" action="">
                <?php 
                if ($edit_product) {
                    wp_nonce_field('virical_update_product');
                    echo '<input type="hidden" name="action" value="update_product">';
                    echo '<input type="hidden" name="id" value="' . esc_attr($edit_product->id) . '">';
                } else {
                    wp_nonce_field('virical_add_product');
                    echo '<input type="hidden" name="action" value="add_product">';
                }
                ?>
                
                <table class="form-table">
                    <tr>
                        <th><label for="name">Tên sản phẩm</label></th>
                        <td><input type="text" id="name" name="name" class="regular-text" value="<?php echo $edit_product ? esc_attr($edit_product->name) : ''; ?>" required></td>
                    </tr>
                    <tr>
                        <th><label for="slug">Slug</label></th>
                        <td><input type="text" id="slug" name="slug" class="regular-text" value="<?php echo $edit_product ? esc_attr($edit_product->slug) : ''; ?>"></td>
                    </tr>
                    <tr>
                        <th><label for="category">Danh mục</label></th>
                        <td>
                            <select id="category" name="category" required>
                                <option value="">-- Chọn danh mục --</option>
                                <?php 
                                // Organize categories for display
                                $cat_tree = [];
                                foreach ($categories as $cat) {
                                    if ($cat->parent_id == 0) {
                                        $cat_tree[$cat->id] = ['data' => $cat, 'children' => []];
                                    } else {
                                        if (isset($cat_tree[$cat->parent_id])) {
                                            $cat_tree[$cat->parent_id]['children'][] = $cat;
                                        }
                                    }
                                }
                                
                                foreach ($cat_tree as $id => $node): ?>
                                    <option value="<?php echo esc_attr($node['data']->slug); ?>" <?php echo ($edit_product && $edit_product->category === $node['data']->slug) ? 'selected' : ''; ?>>
                                        <?php echo esc_html($node['data']->name); ?>
                                    </option>
                                    <?php foreach ($node['children'] as $child): ?>
                                        <option value="<?php echo esc_attr($child->slug); ?>" <?php echo ($edit_product && $edit_product->category === $child->slug) ? 'selected' : ''; ?>>
                                            &nbsp;&nbsp;&nbsp;— <?php echo esc_html($child->name); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="description">Mô tả ngắn</label></th>
                        <td><textarea id="description" name="description" rows="3" class="large-text"><?php echo $edit_product ? esc_textarea($edit_product->description) : ''; ?></textarea></td>
                    </tr>
                    <tr>
                        <th><label for="detailed_title">Tiêu đề phần chi tiết (SEO)</label></th>
                        <td><input type="text" id="detailed_title" name="detailed_title" class="regular-text" value="<?php echo $edit_product ? esc_attr($edit_product->detailed_title) : ''; ?>" placeholder="Ví dụ: Giải pháp chiếu sáng hiện đại"></td>
                    </tr>
                    <tr>
                        <th><label for="product_content">Nội dung chi tiết (Body SEO)</label></th>
                        <td>
                            <?php 
                            $content_value = ($edit_product && !is_null($edit_product->content)) ? $edit_product->content : '';
                            wp_editor($content_value, 'product_content', array(
                                'textarea_name' => 'content',
                                'textarea_rows' => 15,
                                'media_buttons' => true
                            ));
                            ?>
                            <p class="description">Nội dung hiển thị ở phần cuối trang chi tiết sản phẩm.</p>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="price">Giá (VNĐ)</label></th>
                        <td><input type="number" id="price" name="price" value="<?php echo $edit_product ? esc_attr($edit_product->price) : ''; ?>"></td>
                    </tr>
                    <tr>
                        <th><label for="specifications">Thông số kỹ thuật</label></th>
                        <td>
                            <textarea id="specifications" name="specifications" rows="8" class="large-text" placeholder="Công suất: 15W - 50W&#10;Điện áp: 220V - 240V AC&#10;Nhiệt độ màu: 3000K / 4000K / 6500K"><?php 
                                if ($edit_product && !empty($edit_product->specifications)) {
                                    $specs = json_decode($edit_product->specifications, true);
                                    if (is_array($specs)) {
                                        foreach ($specs as $key => $value) {
                                            echo esc_html($key . ': ' . $value . "\n");
                                        }
                                    }
                                }
                            ?></textarea>
                            <p class="description">Nhập theo định dạng <strong>Tên: Giá trị</strong> (mỗi dòng một thông số).</p>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="features">Tính năng nổi bật</label></th>
                        <td>
                            <textarea id="features" name="features" rows="5" class="large-text" placeholder="Tiết kiệm năng lượng&#10;Tuổi thọ cao&#10;Ánh sáng chất lượng"><?php 
                                if ($edit_product && !empty($edit_product->features)) {
                                    $feats = json_decode($edit_product->features, true);
                                    if (is_array($feats)) {
                                        echo esc_html(implode("\n", $feats));
                                    }
                                }
                            ?></textarea>
                            <p class="description">Mỗi tính năng một dòng (hiển thị dạng dấu tích).</p>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="image_url">Hình ảnh chính</label></th>
                        <td>
                            <input type="text" id="image_url" name="image_url" class="regular-text" value="<?php echo $edit_product ? esc_attr($edit_product->image_url) : ''; ?>">
                            <button type="button" class="button virical-media-upload" data-target="image_url">Chọn ảnh</button>
                            <div id="image_url_preview" class="virical-product-image-preview">
                                <?php if ($edit_product && $edit_product->image_url): ?>
                                    <img src="<?php echo esc_url($edit_product->image_url); ?>">
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="image_url_2">Hình ảnh 2</label></th>
                        <td>
                            <input type="text" id="image_url_2" name="image_url_2" class="regular-text" value="<?php echo $edit_product ? esc_attr($edit_product->image_url_2) : ''; ?>">
                            <button type="button" class="button virical-media-upload" data-target="image_url_2">Chọn ảnh</button>
                            <div id="image_url_2_preview" class="virical-product-image-preview">
                                <?php if ($edit_product && $edit_product->image_url_2): ?>
                                    <img src="<?php echo esc_url($edit_product->image_url_2); ?>">
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="image_url_3">Hình ảnh 3</label></th>
                        <td>
                            <input type="text" id="image_url_3" name="image_url_3" class="regular-text" value="<?php echo $edit_product ? esc_attr($edit_product->image_url_3) : ''; ?>">
                            <button type="button" class="button virical-media-upload" data-target="image_url_3">Chọn ảnh</button>
                            <div id="image_url_3_preview" class="virical-product-image-preview">
                                <?php if ($edit_product && $edit_product->image_url_3): ?>
                                    <img src="<?php echo esc_url($edit_product->image_url_3); ?>">
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="image_url_4">Hình ảnh 4</label></th>
                        <td>
                            <input type="text" id="image_url_4" name="image_url_4" class="regular-text" value="<?php echo $edit_product ? esc_attr($edit_product->image_url_4) : ''; ?>">
                            <button type="button" class="button virical-media-upload" data-target="image_url_4">Chọn ảnh</button>
                            <div id="image_url_4_preview" class="virical-product-image-preview">
                                <?php if ($edit_product && $edit_product->image_url_4): ?>
                                    <img src="<?php echo esc_url($edit_product->image_url_4); ?>">
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <th colspan="2" style="background: #f0f0f0; text-align: center;">ỨNG DỤNG - CÔNG TRÌNH (3 MỤC)</th>
                    </tr>
                    
                    <?php for ($i = 1; $i <= 3; $i++): ?>
                    <tr>
                        <th>Mục ứng dụng <?php echo $i; ?></th>
                        <td>
                            <div style="margin-bottom: 10px;">
                                <label>Hình ảnh:</label><br>
                                <input type="text" id="app_img_<?php echo $i; ?>" name="app_img_<?php echo $i; ?>" class="regular-text" value="<?php echo $edit_product ? esc_attr($edit_product->{"app_img_$i"} ?? '') : ''; ?>">
                                <button type="button" class="button virical-media-upload" data-target="app_img_<?php echo $i; ?>">Chọn ảnh</button>
                            </div>
                            <div style="margin-bottom: 10px;">
                                <label>Tiêu đề:</label><br>
                                <input type="text" name="app_title_<?php echo $i; ?>" class="regular-text" value="<?php echo $edit_product ? esc_attr($edit_product->{"app_title_$i"} ?? '') : ''; ?>">
                            </div>
                            <div>
                                <label>Mô tả:</label><br>
                                <textarea name="app_desc_<?php echo $i; ?>" rows="2" class="large-text"><?php echo $edit_product ? esc_textarea($edit_product->{"app_desc_$i"} ?? '') : ''; ?></textarea>
                            </div>
                        </td>
                    </tr>
                    <?php endfor; ?>
                    
                    <tr>
                        <th><label for="is_featured">Nổi bật</label></th>
                        <td><input type="checkbox" name="is_featured" value="1" <?php checked($edit_product && $edit_product->is_featured, 1); ?>></td>
                    </tr>
                    <tr>
                        <th><label for="sort_order">Thứ tự</label></th>
                        <td><input type="number" name="sort_order" value="<?php echo $edit_product ? esc_attr($edit_product->sort_order) : '0'; ?>"></td>
                    </tr>
                </table>
                
                <p class="submit">
                    <input type="submit" class="button-primary" value="<?php echo $edit_product ? 'Cập nhật sản phẩm' : 'Thêm sản phẩm'; ?>">
                    <?php if ($edit_product): ?>
                        <a href="?page=virical-products" class="button">Hủy</a>
                    <?php endif; ?>
                </p>
            </form>
        </div>

        <?php if (!$edit_product): ?>
        <h2>Danh sách sản phẩm</h2>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th style="width: 50px;">ID</th>
                    <th style="width: 80px;">Ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Danh mục</th>
                    <th>Giá</th>
                    <th>Nổi bật</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo $product->id; ?></td>
                    <td><img src="<?php echo esc_url($product->image_url); ?>" style="width: 50px; height: 50px; object-fit: cover;"></td>
                    <td><strong><?php echo esc_html($product->name); ?></strong></td>
                    <td><?php echo esc_html($product->category_name); ?></td>
                    <td><?php echo number_format($product->price); ?> VNĐ</td>
                    <td><?php echo $product->is_featured ? '⭐' : ''; ?></td>
                    <td>
                        <a href="?page=virical-products&action=edit&id=<?php echo $product->id; ?>" class="button button-small">Sửa</a>
                        <a href="<?php echo wp_nonce_url("?page=virical-products&action=delete&id={$product->id}", 'delete_product_' . $product->id); ?>" class="button button-small" onclick="return confirm('Xóa sản phẩm này?')">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
    <script>
    jQuery(document).ready(function($){
        $('.virical-media-upload').click(function(e) {
            e.preventDefault();
            var target = $(this).data('target');
            var frame = wp.media({ title: 'Chọn hình ảnh', multiple: false }).open()
            .on('select', function(){
                var attachment = frame.state().get('selection').first().toJSON();
                $('#' + target).val(attachment.url);
                $('#' + target + '_preview').html('<img src="'+attachment.url+'">');
            });
        });
    });
    </script>
    <?php
}

// Categories management page
function virical_categories_page() {
    global $wpdb;
    
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'add_category' && check_admin_referer('virical_add_category')) {
            virical_add_category($_POST);
        } elseif ($_POST['action'] === 'update_category' && check_admin_referer('virical_update_category')) {
            virical_update_category($_POST);
        }
    }
    
    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
        if (check_admin_referer('delete_category_' . $_GET['id'])) {
            virical_delete_category($_GET['id']);
        }
    }
    
    $edit_cat = null;
    if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
        $edit_cat = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}virical_product_categories WHERE id = %d", $_GET['id']));
    }
    
    $categories = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}virical_product_categories ORDER BY parent_id, sort_order");
    ?>
    <div class="wrap">
        <h1><?php echo $edit_cat ? 'Sửa danh mục' : 'Danh mục sản phẩm'; ?></h1>
        
        <div class="card">
            <h2><?php echo $edit_cat ? 'Sửa: ' . esc_html($edit_cat->name) : 'Thêm danh mục mới'; ?></h2>
            <form method="post" action="">
                <?php 
                if ($edit_cat) {
                    wp_nonce_field('virical_update_category');
                    echo '<input type="hidden" name="action" value="update_category">';
                    echo '<input type="hidden" name="id" value="' . esc_attr($edit_cat->id) . '">';
                } else {
                    wp_nonce_field('virical_add_category');
                    echo '<input type="hidden" name="action" value="add_category">';
                }
                ?>
                <table class="form-table">
                    <tr>
                        <th>Tên danh mục</th>
                        <td><input type="text" name="name" class="regular-text" value="<?php echo $edit_cat ? esc_attr($edit_cat->name) : ''; ?>" required></td>
                    </tr>
                    <tr>
                        <th>Slug</th>
                        <td><input type="text" name="slug" class="regular-text" value="<?php echo $edit_cat ? esc_attr($edit_cat->slug) : ''; ?>"></td>
                    </tr>
                    <tr>
                        <th>Danh mục cha</th>
                        <td>
                            <select name="parent_id">
                                <option value="0">Không có (Danh mục gốc)</option>
                                <?php foreach ($categories as $cat): 
                                    if ($edit_cat && $cat->id == $edit_cat->id) continue;
                                    if ($cat->parent_id != 0) continue; // Only show top level as parents for simplicity or implement recursion
                                ?>
                                    <option value="<?php echo $cat->id; ?>" <?php selected($edit_cat ? $edit_cat->parent_id : 0, $cat->id); ?>>
                                        <?php echo esc_html($cat->name); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>Ảnh danh mục</th>
                        <td>
                            <input type="text" id="cat_image" name="image_url" class="regular-text" value="<?php echo $edit_cat ? esc_attr($edit_cat->image_url) : ''; ?>">
                            <button type="button" class="button virical-media-upload" data-target="cat_image">Chọn ảnh</button>
                        </td>
                    </tr>
                    <tr>
                        <th>Thứ tự</th>
                        <td><input type="number" name="sort_order" value="<?php echo $edit_cat ? esc_attr($edit_cat->sort_order) : '0'; ?>"></td>
                    </tr>
                </table>
                <p class="submit">
                    <input type="submit" class="button-primary" value="<?php echo $edit_cat ? 'Cập nhật' : 'Thêm mới'; ?>">
                    <?php if ($edit_cat): ?>
                        <a href="?page=virical-categories" class="button">Hủy</a>
                    <?php endif; ?>
                </p>
            </form>
        </div>

        <?php if (!$edit_cat): ?>
        <h2>Danh sách danh mục</h2>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên danh mục</th>
                    <th>Slug</th>
                    <th>Danh mục cha</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $cat_names = [];
                foreach ($categories as $cat) $cat_names[$cat->id] = $cat->name;
                
                foreach ($categories as $cat): ?>
                <tr>
                    <td><?php echo $cat->id; ?></td>
                    <td><strong><?php echo esc_html($cat->name); ?></strong></td>
                    <td><?php echo esc_html($cat->slug); ?></td>
                    <td><?php echo $cat->parent_id ? esc_html($cat_names[$cat->parent_id] ?? 'Unknown') : '-'; ?></td>
                    <td>
                        <a href="?page=virical-categories&action=edit&id=<?php echo $cat->id; ?>" class="button button-small">Sửa</a>
                        <a href="<?php echo wp_nonce_url("?page=virical-categories&action=delete&id={$cat->id}", 'delete_category_' . $cat->id); ?>" class="button button-small" onclick="return confirm('Xóa danh mục này?')">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
    <script>
    jQuery(document).ready(function($){
        $('.virical-media-upload').click(function(e) {
            e.preventDefault();
            var target = $(this).data('target');
            var frame = wp.media({ title: 'Chọn hình ảnh', multiple: false }).open()
            .on('select', function(){
                var attachment = frame.state().get('selection').first().toJSON();
                $('#' + target).val(attachment.url);
            });
        });
    });
    </script>
    <?php
}

// Data Handling Functions
function virical_add_product($data) {
    global $wpdb;
    
    $gallery = [];
    if (!empty($data['image_url_2'])) $gallery[] = esc_url_raw($data['image_url_2']);
    if (!empty($data['image_url_3'])) $gallery[] = esc_url_raw($data['image_url_3']);
    if (!empty($data['image_url_4'])) $gallery[] = esc_url_raw($data['image_url_4']);
    
    $specs_raw = isset($data['specifications']) ? explode("\n", $data['specifications']) : [];
    $specs = [];
    foreach ($specs_raw as $line) {
        $parts = explode(':', $line, 2);
        if (count($parts) === 2) {
            $specs[trim($parts[0])] = trim($parts[1]);
        }
    }
    
    $features_raw = isset($data['features']) ? explode("\n", $data['features']) : [];
    $features = array_filter(array_map('trim', $features_raw));
    
    $applications = [];
    for ($i = 1; $i <= 3; $i++) {
        $applications[] = [
            'image' => esc_url_raw($data["app_img_$i"] ?? ''),
            'title' => sanitize_text_field($data["app_title_$i"] ?? ''),
            'desc'  => sanitize_text_field($data["app_desc_$i"] ?? '')
        ];
    }
    
    $result = $wpdb->insert($wpdb->prefix . 'virical_products', [
        'name' => sanitize_text_field($data['name']),
        'slug' => sanitize_title($data['slug'] ?: $data['name']),
        'description' => wp_kses_post($data['description']),
        'detailed_title' => sanitize_text_field($data['detailed_title']),
        'content' => wp_kses_post($data['content']),
        'category' => sanitize_text_field($data['category']),
        'price' => floatval($data['price']),
        'specifications' => json_encode($specs),
        'features' => json_encode($features),
        'applications' => json_encode($applications),
        'image_url' => esc_url_raw($data['image_url']),
        'image_url_2' => esc_url_raw($data['image_url_2'] ?? ''),
        'image_url_3' => esc_url_raw($data['image_url_3'] ?? ''),
        'image_url_4' => esc_url_raw($data['image_url_4'] ?? ''),
        'gallery' => json_encode($gallery),
        'is_featured' => isset($data['is_featured']) ? 1 : 0,
        'sort_order' => intval($data['sort_order']),
        'is_active' => 1
    ]);
    
    if ($result) {
        echo '<div class="notice notice-success is-dismissible"><p>Sản phẩm đã được thêm!</p></div>';
    } else {
        echo '<div class="notice notice-error is-dismissible"><p>Lỗi khi thêm sản phẩm: ' . $wpdb->last_error . '</p></div>';
    }
}

function virical_update_product($data) {
    global $wpdb;
    
    $gallery = [];
    if (!empty($data['image_url_2'])) $gallery[] = esc_url_raw($data['image_url_2']);
    if (!empty($data['image_url_3'])) $gallery[] = esc_url_raw($data['image_url_3']);
    if (!empty($data['image_url_4'])) $gallery[] = esc_url_raw($data['image_url_4']);
    
    $specs_raw = isset($data['specifications']) ? explode("\n", $data['specifications']) : [];
    $specs = [];
    foreach ($specs_raw as $line) {
        $parts = explode(':', $line, 2);
        if (count($parts) === 2) {
            $specs[trim($parts[0])] = trim($parts[1]);
        }
    }
    
    $features_raw = isset($data['features']) ? explode("\n", $data['features']) : [];
    $features = array_filter(array_map('trim', $features_raw));
    
    $applications = [];
    for ($i = 1; $i <= 3; $i++) {
        $applications[] = [
            'image' => esc_url_raw($data["app_img_$i"] ?? ''),
            'title' => sanitize_text_field($data["app_title_$i"] ?? ''),
            'desc'  => sanitize_text_field($data["app_desc_$i"] ?? '')
        ];
    }
    
    $result = $wpdb->update($wpdb->prefix . 'virical_products', [
        'name' => sanitize_text_field($data['name']),
        'slug' => sanitize_title($data['slug'] ?: $data['name']),
        'description' => wp_kses_post($data['description']),
        'detailed_title' => sanitize_text_field($data['detailed_title']),
        'content' => wp_kses_post($data['content']),
        'category' => sanitize_text_field($data['category']),
        'price' => floatval($data['price']),
        'specifications' => json_encode($specs),
        'features' => json_encode($features),
        'applications' => json_encode($applications),
        'image_url' => esc_url_raw($data['image_url']),
        'image_url_2' => esc_url_raw($data['image_url_2'] ?? ''),
        'image_url_3' => esc_url_raw($data['image_url_3'] ?? ''),
        'image_url_4' => esc_url_raw($data['image_url_4'] ?? ''),
        'gallery' => json_encode($gallery),
        'is_featured' => isset($data['is_featured']) ? 1 : 0,
        'sort_order' => intval($data['sort_order'])
    ], ['id' => intval($data['id'])]);
    
    if ($result !== false) {
        echo '<div class="notice notice-success is-dismissible"><p>Sản phẩm đã được cập nhật!</p></div>';
    } else {
        echo '<div class="notice notice-error is-dismissible"><p>Lỗi khi cập nhật sản phẩm: ' . $wpdb->last_error . '</p></div>';
    }
}

function virical_delete_product($id) {
    global $wpdb;
    $wpdb->delete($wpdb->prefix . 'virical_products', ['id' => intval($id)]);
}

function virical_add_category($data) {
    global $wpdb;
    $wpdb->insert($wpdb->prefix . 'virical_product_categories', [
        'name' => sanitize_text_field($data['name']),
        'slug' => sanitize_title($data['slug'] ?: $data['name']),
        'parent_id' => intval($data['parent_id']),
        'image_url' => esc_url_raw($data['image_url']),
        'sort_order' => intval($data['sort_order']),
        'is_active' => 1
    ]);
}

function virical_update_category($data) {
    global $wpdb;
    $wpdb->update($wpdb->prefix . 'virical_product_categories', [
        'name' => sanitize_text_field($data['name']),
        'slug' => sanitize_title($data['slug'] ?: $data['name']),
        'parent_id' => intval($data['parent_id']),
        'image_url' => esc_url_raw($data['image_url']),
        'sort_order' => intval($data['sort_order'])
    ], ['id' => intval($data['id'])]);
}

function virical_delete_category($id) {
    global $wpdb;
    $wpdb->delete($wpdb->prefix . 'virical_product_categories', ['id' => intval($id)]);
}

// Enqueue media uploader
add_action('admin_enqueue_scripts', function() {
    wp_enqueue_media();
});
?>