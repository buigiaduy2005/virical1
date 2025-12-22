<?php
/**
 * Equipment Post Type
 * Handles the registration and meta boxes for Equipment Items
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Check if class exists to prevent redeclaration
if ( ! class_exists( 'Virical_Equipment_Post_Type' ) ) {

    class Virical_Equipment_Post_Type {

        /**
         * Constructor
         */
        public function __construct() {
            add_action( 'init', array( $this, 'register_post_type' ), 0 ); // Priority 0 to register early
            add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
            add_action( 'save_post', array( $this, 'save_meta_boxes' ) );
        }

        /**
         * Register Post Type
         */
        public function register_post_type() {
            $labels = array(
                'name'                  => 'Equipment Items',
                'singular_name'         => 'Equipment Item',
                'menu_name'             => 'Equipment',
                'name_admin_bar'        => 'Equipment Item',
                'add_new'               => 'Add New',
                'add_new_item'          => 'Add New Equipment Item',
                'new_item'              => 'New Equipment Item',
                'edit_item'             => 'Edit Equipment Item',
                'view_item'             => 'View Equipment Item',
                'all_items'             => 'All Equipment',
                'search_items'          => 'Search Equipment',
                'parent_item_colon'     => 'Parent Equipment:',
                'not_found'             => 'No equipment found.',
                'not_found_in_trash'    => 'No equipment found in Trash.',
            );

            $args = array(
                'labels'             => $labels,
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'show_in_menu'       => true,
                'query_var'          => true,
                'rewrite'            => array( 'slug' => 'equipment' ),
                'capability_type'    => 'post',
                'has_archive'        => false,
                'hierarchical'       => false,
                'menu_position'      => 5, // Moved up to position 5 (below Posts)
                'menu_icon'          => 'dashicons-hammer',
                'supports'           => array( 'title', 'thumbnail', 'page-attributes' ),
            );

            register_post_type( 'equipment_item', $args );
        }

        /**
         * Add Meta Boxes
         */
        public function add_meta_boxes() {
            add_meta_box(
                'equipment_details',
                'Equipment Details',
                array( $this, 'render_meta_box' ),
                'equipment_item',
                'normal',
                'high'
            );
        }

        /**
         * Render Meta Box
         */
        public function render_meta_box( $post ) {
            // Retrieve current values
            $code = get_post_meta( $post->ID, '_equipment_code', true );
            $link = get_post_meta( $post->ID, '_equipment_link', true );
            
            // Nonce field
            wp_nonce_field( 'virical_equipment_save', 'virical_equipment_nonce' );
            ?>
            <p>
                <label for="equipment_code"><strong>Product Code:</strong></label><br>
                <input type="text" id="equipment_code" name="equipment_code" value="<?php echo esc_attr( $code ); ?>" class="widefat" placeholder="e.g., AWB-2024">
            </p>
            <p>
                <label for="equipment_link"><strong>Product Link:</strong></label><br>
                <input type="url" id="equipment_link" name="equipment_link" value="<?php echo esc_attr( $link ); ?>" class="widefat" placeholder="https://...">
            </p>
            <?php
        }

        /**
         * Save Meta Boxes
         */
        public function save_meta_boxes( $post_id ) {
            // Check nonce
            if ( ! isset( $_POST['virical_equipment_nonce'] ) || ! wp_verify_nonce( $_POST['virical_equipment_nonce'], 'virical_equipment_save' ) ) {
                return;
            }

            // Check autosave
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
                return;
            }

            // Check permissions
            if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return;
            }

            // Save Code
            if ( isset( $_POST['equipment_code'] ) ) {
                update_post_meta( $post_id, '_equipment_code', sanitize_text_field( $_POST['equipment_code'] ) );
            }

            // Save Link
            if ( isset( $_POST['equipment_link'] ) ) {
                update_post_meta( $post_id, '_equipment_link', esc_url_raw( $_POST['equipment_link'] ) );
            }
        }
    }

    // Initialize the class immediately
    new Virical_Equipment_Post_Type();
}
