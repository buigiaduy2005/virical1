<?php
/**
 * Global Admin Search
 * Adds a search bar to the WP Admin Bar to search for posts, pages, and custom post types.
 * 
 * @package Virical
 */

// 1. Add Search Input to Admin Bar
function virical_admin_bar_search_node($wp_admin_bar) {
    if (!is_admin()) return; // Only show in backend

    $wp_admin_bar->add_node(array(
        'id'    => 'virical-global-search',
        'title' => '
            <div class="virical-search-container">
                <span class="dashicons dashicons-search search-icon"></span>
                <input type="text" id="virical-global-search-input" placeholder="Tìm kiếm nhanh (Bài viết, Trang, Sản phẩm...)" autocomplete="off">
                <div id="virical-search-spinner" class="spinner"></div>
                <div id="virical-search-results"></div>
            </div>
        ',
        'meta'  => array(
            'class' => 'virical-search-toolbar-item',
            'title' => 'Tìm kiếm nội dung'
        )
    ));
}
add_action('admin_bar_menu', 'virical_admin_bar_search_node', 100);

// 2. Add CSS
function virical_admin_search_css() {
    ?>
    <style>
        /* Admin Bar Item Styling */
        #wpadminbar .virical-search-toolbar-item .ab-item {
            padding: 0 10px !important;
            height: 32px;
            display: flex;
            align-items: center;
            background: transparent !important;
        }

        .virical-search-container {
            position: relative;
            display: flex;
            align-items: center;
        }

        #virical-global-search-input {
            background-color: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 4px;
            color: #fff;
            height: 24px;
            line-height: 24px;
            padding: 0 8px 0 28px; /* space for icon */
            width: 250px;
            transition: all 0.2s;
            font-size: 13px;
        }

        #virical-global-search-input:focus {
            background-color: #fff;
            color: #333;
            width: 400px;
            outline: none;
            box-shadow: 0 0 5px rgba(0,0,0,0.2);
        }

        #virical-global-search-input::placeholder {
            color: rgba(255,255,255,0.6);
        }
        #virical-global-search-input:focus::placeholder {
            color: #999;
        }

        .search-icon {
            position: absolute;
            left: 5px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.7);
            font-size: 16px;
            pointer-events: none;
            z-index: 10;
        }
        
        #virical-global-search-input:focus ~ .search-icon {
            color: #555;
        }

        /* Spinner */
        #virical-search-spinner {
            position: absolute;
            right: 8px;
            top: 50%;
            margin-top: -10px;
            display: none;
            z-index: 11;
        }
        #virical-search-spinner.is-active {
            display: block;
        }

        /* Results Dropdown */
        #virical-search-results {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 0 0 4px 4px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            display: none;
            max-height: 400px;
            overflow-y: auto;
            z-index: 99999;
        }

        .virical-result-group {
            border-bottom: 1px solid #eee;
        }
        .virical-result-group:last-child {
            border-bottom: none;
        }

        .virical-group-title {
            padding: 8px 12px;
            background: #f7f7f7;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            color: #888;
            letter-spacing: 0.5px;
        }

        .virical-result-item {
            display: block;
            padding: 10px 12px;
            color: #333;
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: all 0.2s;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .virical-result-item:hover {
            background: #f0f6fc;
            border-left-color: #2271b1;
            color: #2271b1;
        }

        .virical-result-item .item-title {
            font-weight: 500;
            font-size: 14px;
        }

        .virical-result-item .item-status {
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 3px;
            background: #eee;
            color: #666;
            margin-left: 10px;
        }
        
        .virical-no-results {
            padding: 15px;
            text-align: center;
            color: #777;
            font-style: italic;
        }
    </style>
    <?php
}
add_action('admin_head', 'virical_admin_search_css');

// 3. Add JS
function virical_admin_search_js() {
    ?>
    <script>
    jQuery(document).ready(function($) {
        var searchInput = $('#virical-global-search-input');
        var resultsContainer = $('#virical-search-results');
        var spinner = $('#virical-search-spinner');
        var searchTimer;

        searchInput.on('keyup', function() {
            var term = $(this).val();
            
            clearTimeout(searchTimer);

            if (term.length < 2) {
                resultsContainer.hide().empty();
                return;
            }

            spinner.addClass('is-active');

            searchTimer = setTimeout(function() {
                $.ajax({
                    url: virical_ajax.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'virical_global_search',
                        term: term,
                        nonce: virical_ajax.nonce
                    },
                    success: function(response) {
                        spinner.removeClass('is-active');
                        if (response.success) {
                            renderResults(response.data);
                        } else {
                            resultsContainer.html('<div class="virical-no-results">Lỗi tìm kiếm</div>').show();
                        }
                    },
                    error: function() {
                        spinner.removeClass('is-active');
                    }
                });
            }, 500); // 500ms debounce
        });

        // Click outside to close
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.virical-search-container').length) {
                resultsContainer.hide();
            }
        });

        // Focus back shows results
        searchInput.on('focus', function() {
            if ($(this).val().length >= 2 && resultsContainer.children().length > 0) {
                resultsContainer.show();
            }
        });

        function renderResults(data) {
            resultsContainer.empty();

            if (data.length === 0) {
                resultsContainer.html('<div class="virical-no-results">Không tìm thấy kết quả nào.</div>').show();
                return;
            }

            // Group results by type
            var grouped = {};
            $.each(data, function(i, item) {
                if (!grouped[item.type]) grouped[item.type] = [];
                grouped[item.type].push(item);
            });

            // Render groups
            $.each(grouped, function(type, items) {
                var groupHtml = '<div class="virical-result-group">';
                groupHtml += '<div class="virical-group-title">' + type + '</div>';
                
                $.each(items, function(i, item) {
                    groupHtml += '<a href="' + item.edit_link + '" class="virical-result-item">';
                    groupHtml += '<span class="item-title">' + item.title + '</span>';
                    groupHtml += '<span class="item-status">' + item.status + '</span>';
                    groupHtml += '</a>';
                });
                
                groupHtml += '</div>';
                resultsContainer.append(groupHtml);
            });

            resultsContainer.show();
        }
    });
    </script>
    <?php
}
add_action('admin_footer', 'virical_admin_search_js');

// 4. AJAX Handler
function virical_ajax_global_search_handler() {
    check_ajax_referer('virical_menu_nonce', 'nonce');

    $term = sanitize_text_field($_POST['term']);
    
    // Search args
    $args = array(
        's'              => $term,
        'post_type'      => 'any', // Search all types (post, page, product, project...)
        'post_status'    => array('publish', 'draft', 'pending', 'future', 'private'),
        'posts_per_page' => 10,
        'orderby'        => 'relevance'
    );

    $query = new WP_Query($args);
    $results = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            
            $post_type_obj = get_post_type_object(get_post_type());
            $post_type_label = $post_type_obj ? $post_type_obj->labels->singular_name : get_post_type();
            
            // Edit link
            $edit_link = get_edit_post_link();

            $results[] = array(
                'id'        => get_the_ID(),
                'title'     => get_the_title(),
                'type'      => $post_type_label,
                'status'    => get_post_status(),
                'edit_link' => html_entity_decode($edit_link)
            );
        }
        wp_reset_postdata();
    }

    wp_send_json_success($results);
}
add_action('wp_ajax_virical_global_search', 'virical_ajax_global_search_handler');
