<?php
require_once('wp-load.php');
global $wpdb;
$table_name = $wpdb->prefix . 'virical_products';
$results = $wpdb->get_results("DESCRIBE $table_name");
echo json_encode($results);
?>