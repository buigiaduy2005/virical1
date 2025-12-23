<?php
require_once('wp-load.php');
global $wpdb;
$table_name = $wpdb->prefix . 'virical_product_categories';
$results = $wpdb->get_results("DESCRIBE $table_name");
echo json_encode($results);
?>