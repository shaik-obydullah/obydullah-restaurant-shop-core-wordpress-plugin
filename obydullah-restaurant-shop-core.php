<?php
/**
 * Plugin Name: Obydullah Restaurant Shop Core
 * Plugin URI: https://obydullah.com/project/obydullah-restaurant-shop-core
 * Description: Core functionality for Obydullah Restaurant theme with WooCommerce integration for menu items and chef's specials.
 * Version:     1.0.1
 * Author:      Shaik Obydullah
 * Author URI:  https://obydullah.com
 * License:     GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: obydullah-restaurant-shop-core
 * Domain Path: /languages
 *
 * ================================================================
 *                         INDEX
 * ================================================================
 * 1. Security & Constants
 * 2. Hero Slider CPT + Meta Boxes
 * 3. Chef's Special CPT + Meta Boxes (Single Instance) + WooCommerce
 * 4. Menu Items CPT + Category Taxonomy + Meta Boxes + WooCommerce
 * 5. Menu Area (Single Instance) + Meta Boxes
 * 6. Testimonials CPT + Meta Boxes
 * 7. Testimonial Area (Single Instance)
 * 8. Opening Hours CPT (Single Instance) + Repeater Hours
 * 9. Table Reservations (Custom DB Table, AJAX Handler, Admin List)
 * 10. Footer Settings (Single Instance) + Meta Boxes
 * 11. About Page (Single Instance) + Meta Boxes (Story, Philosophy, Slider)
 * 12. Contact Page
 * 13. Contact Form 7 Support
 * 14. WooCommerce Integration - Display Functions
 * ================================================================
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'OBIRSC_VERSION', '1.0.0' );
define( 'OBIRSC_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'OBIRSC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once OBIRSC_PLUGIN_DIR . 'includes/obirsc-booking-list-table.php';

function obirsc_add_admin_menu() {
    add_menu_page(
        'Restaurant Shop Core',
        'Restaurant Shop Core',
        'manage_options',
        'obirsc-restaurant-core',
        'obirsc_restaurant_core_page',
        'dashicons-editor-kitchensink',
        59
    );
}
add_action( 'admin_menu', 'obirsc_add_admin_menu', 9 );

function obirsc_enqueue_dashboard_assets( $hook ) {
    if ( 'toplevel_page_obirsc-restaurant-core' === $hook ) {
        wp_enqueue_style( 'obirsc-dashboard-css', OBIRSC_PLUGIN_URL . 'assets/css/admin-dashboard.css', array(), OBIRSC_VERSION );
    }
}
add_action( 'admin_enqueue_scripts', 'obirsc_enqueue_dashboard_assets' );

function obirsc_restaurant_core_page() {
    $sections = array(
        'hero_slides' => array(
            'title' => __( 'Hero Slides', 'obydullah-restaurant-shop-core' ),
            'url'   => admin_url( 'edit.php?post_type=obirsc_hero_slide' ),
            'icon'  => 'dashicons-images-alt2',
        ),
        'chef_specials' => array(
            'title' => __( 'Chef\'s Specials', 'obydullah-restaurant-shop-core' ),
            'url'   => admin_url( 'edit.php?post_type=obirsc_chef_special' ),
            'icon'  => 'dashicons-media-text',
        ),
        'menu_items' => array(
            'title' => __( 'Menu Items', 'obydullah-restaurant-shop-core' ),
            'url'   => admin_url( 'edit.php?post_type=obirsc_menu_item' ),
            'icon'  => 'dashicons-food',
        ),
        'menu_area' => array(
            'title' => __( 'Menu Area', 'obydullah-restaurant-shop-core' ),
            'url'   => admin_url( 'edit.php?post_type=obirsc_menu_area' ),
            'icon'  => 'dashicons-menu',
        ),
        'testimonials' => array(
            'title' => __( 'Testimonials', 'obydullah-restaurant-shop-core' ),
            'url'   => admin_url( 'edit.php?post_type=obirsc_testimonial' ),
            'icon'  => 'dashicons-format-quote',
        ),
        'testimonial_area' => array(
            'title' => __( 'Testimonial Area', 'obydullah-restaurant-shop-core' ),
            'url'   => admin_url( 'edit.php?post_type=obirsc_testi_area' ),
            'icon'  => 'dashicons-menu',
        ),
        'opening_hours' => array(
            'title' => __( 'Opening Hours', 'obydullah-restaurant-shop-core' ),
            'url'   => admin_url( 'edit.php?post_type=obirsc_opening_hours' ),
            'icon'  => 'dashicons-clock',
        ),
        'bookings' => array(
            'title' => __( 'Table Bookings', 'obydullah-restaurant-shop-core' ),
            'url'   => admin_url( 'admin.php?page=obirsc-bookings' ),
            'icon'  => 'dashicons-calendar-alt',
        ),
        'footer_settings' => array(
            'title' => __( 'Footer Settings', 'obydullah-restaurant-shop-core' ),
            'url'   => admin_url( 'edit.php?post_type=obirsc_footer' ),
            'icon'  => 'dashicons-layout',
        ),
        'about_page' => array(
            'title' => __( 'About Page', 'obydullah-restaurant-shop-core' ),
            'url'   => admin_url( 'edit.php?post_type=obirsc_about_page' ),
            'icon'  => 'dashicons-info',
        ),
        'contact_page' => array(
            'title' => __( 'Contact Page', 'obydullah-restaurant-shop-core' ),
            'url'   => admin_url( 'edit.php?post_type=obirsc_contact_page' ),
            'icon'  => 'dashicons-email',
        ),
    );
    ?>
<div class="wrap obirsc-dashboard">
    <h1><?php esc_html_e( 'Restaurant Shop Core', 'obydullah-restaurant-shop-core' ); ?></h1>
    <p class="obirsc-dashboard-description">
        <?php esc_html_e( 'Welcome to the Restaurant Shop Core plugin. Use the links below to manage your restaurant content.', 'obydullah-restaurant-shop-core' ); ?>
    </p>

    <div class="obirsc-dashboard-grid">
        <?php foreach ( $sections as $section ) : ?>
        <div class="obirsc-dashboard-card">
            <div class="dashicons <?php echo esc_attr( $section['icon'] ); ?>"></div>
            <h2><?php echo esc_html( $section['title'] ); ?></h2>
            <a href="<?php echo esc_url( $section['url'] ); ?>"
                class="button button-primary"><?php esc_html_e( 'Manage', 'obydullah-restaurant-shop-core' ); ?></a>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php
}

/* ======================================================
   2. Hero Slider CPT + Meta Boxes
====================================================== */

function obirsc_register_hero_slide_cpt() {
    register_post_type( 'obirsc_hero_slide', array(
        'labels' => array(
            'name'          => __( 'Hero Slides', 'obydullah-restaurant-shop-core' ),
            'singular_name' => __( 'Hero Slide', 'obydullah-restaurant-shop-core' ),
            'add_new_item'  => __( 'Add New Hero Slide', 'obydullah-restaurant-shop-core' ),
            'edit_item'     => __( 'Edit Hero Slide', 'obydullah-restaurant-shop-core' ),
        ),
        'public'        => true,
        'show_in_menu'  => 'obirsc-restaurant-core',
        'menu_icon'     => 'dashicons-images-alt2',
        'supports'      => array( 'title', 'thumbnail', 'page-attributes' ),
        'show_in_rest'  => true,
        'has_archive'   => false,
        'rewrite'       => array( 'slug' => 'obirsc-hero-slide' ),
    ) );
}
add_action( 'init', 'obirsc_register_hero_slide_cpt' );

function obirsc_add_hero_slide_meta_box() {
    add_meta_box(
        'obirsc_hero_slide_meta',
        __( 'Hero Slide Settings', 'obydullah-restaurant-shop-core' ),
        'obirsc_render_hero_slide_meta_box',
        'obirsc_hero_slide',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'obirsc_add_hero_slide_meta_box' );


function obirsc_render_hero_slide_meta_box( $post ) {
    $subtitle = get_post_meta( $post->ID, 'obirsc_subtitle', true );
    wp_nonce_field( 'obirsc_save_hero_slide_meta', 'obirsc_hero_slide_nonce' );
    ?>
<p>
    <label
        for="obirsc_subtitle"><strong><?php esc_html_e( 'Subtitle', 'obydullah-restaurant-shop-core' ); ?></strong></label><br>
    <input type="text" id="obirsc_subtitle" name="obirsc_subtitle" value="<?php echo esc_attr( $subtitle ); ?>"
        class="widefat">
</p>
<?php
}

function obirsc_save_hero_slide_meta( $post_id ) {
    if ( ! isset( $_POST['obirsc_hero_slide_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['obirsc_hero_slide_nonce'] ) ), 'obirsc_save_hero_slide_meta' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( 'obirsc_hero_slide' !== get_post_type( $post_id ) ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['obirsc_subtitle'] ) ) {
        update_post_meta( $post_id, 'obirsc_subtitle', sanitize_text_field( wp_unslash( $_POST['obirsc_subtitle'] ) ) );
    }
}
add_action( 'save_post_obirsc_hero_slide', 'obirsc_save_hero_slide_meta' );


/* ====================================================================
   3. Chef's Special CPT + Meta Boxes (Single Instance) + WooCommerce
======================================================================= */

function obirsc_register_chef_special_cpt() {
    register_post_type( 'obirsc_chef_special', array(
        'labels' => array(
            'name'          => __( 'Chef\'s Special', 'obydullah-restaurant-shop-core' ),
            'singular_name' => __( 'Chef\'s Special', 'obydullah-restaurant-shop-core' ),
            'add_new_item'  => __( 'Edit Chef\'s Special', 'obydullah-restaurant-shop-core' ),
            'edit_item'     => __( 'Edit Chef\'s Special', 'obydullah-restaurant-shop-core' ),
            'new_item'      => __( 'Edit Chef\'s Special', 'obydullah-restaurant-shop-core' ),
        ),
        'public'          => false,
        'show_ui'         => true,
        'show_in_menu'    => 'obirsc-restaurant-core',
        'menu_icon'       => 'dashicons-media-text',
        'supports'        => array( 'title', 'thumbnail' ),
        'show_in_rest'    => true,
        'capability_type' => 'post',
        'map_meta_cap'    => true,
    ) );
}
add_action( 'init', 'obirsc_register_chef_special_cpt' );

function obirsc_limit_chef_special() {
    global $pagenow;
    if ( $pagenow === 'post-new.php' && isset( $_GET['post_type'] ) && $_GET['post_type'] === 'obirsc_chef_special' ) {
        $existing = get_posts( array(
            'post_type'      => 'obirsc_chef_special',
            'posts_per_page' => 1,
            'post_status'    => 'publish',
            'fields'         => 'ids',
        ) );
        if ( ! empty( $existing ) ) {
            $post_id = $existing[0];
            if ( current_user_can( 'edit_post', $post_id ) ) {
                wp_redirect( admin_url( 'post.php?post=' . $post_id . '&action=edit' ) );
                exit;
            }
        }
    }
}
add_action( 'admin_init', 'obirsc_limit_chef_special' );

function obirsc_add_chef_special_meta_box() {
    add_meta_box(
        'obirsc_chef_special_meta',
        __( 'Chef\'s Special Settings', 'obydullah-restaurant-shop-core' ),
        'obirsc_render_chef_special_meta_box',
        'obirsc_chef_special',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'obirsc_add_chef_special_meta_box' );

function obirsc_render_chef_special_meta_box( $post ) {
    $subtitle = get_post_meta( $post->ID, 'obirsc_subtitle', true );
    $body     = get_post_meta( $post->ID, 'obirsc_body', true );
    $woo_product_id = get_post_meta( $post->ID, '_obirsc_woo_product_id', true );

    wp_nonce_field( 'obirsc_save_chef_special_meta', 'obirsc_chef_special_nonce' );

    // Build product list for WooCommerce dropdown
    $products = array();
    if ( class_exists( 'WooCommerce' ) ) {
        $product_query = get_posts( array(
            'post_type'      => 'product',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'orderby'        => 'title',
            'order'          => 'ASC',
        ) );

        foreach ( $product_query as $product_post ) {
            $product = wc_get_product( $product_post->ID );
            if ( $product ) {
                $clean_price = wp_strip_all_tags( wc_price( $product->get_price() ) );
                $products[ $product_post->ID ] = $product_post->post_title . ' (' . $clean_price . ')';
            }
        }
    }
    ?>

<!-- Subtitle Field -->
<p>
    <label for="obirsc_subtitle">
        <strong><?php esc_html_e( 'Subtitle', 'obydullah-restaurant-shop-core' ); ?></strong>
    </label><br>
    <input type="text" id="obirsc_subtitle" name="obirsc_subtitle" value="<?php echo esc_attr( $subtitle ); ?>"
        class="widefat">
</p>

<!-- Body Field -->
<p>
    <label for="obirsc_body">
        <strong><?php esc_html_e( 'Body', 'obydullah-restaurant-shop-core' ); ?></strong>
    </label><br>
    <textarea id="obirsc_body" name="obirsc_body" rows="5"
        class="large-text"><?php echo esc_textarea( $body ); ?></textarea>
</p>

<?php if ( class_exists( 'WooCommerce' ) && ! empty( $products ) ) : ?>
<hr>
<h3><?php esc_html_e( 'WooCommerce Product Link', 'obydullah-restaurant-shop-core' ); ?></h3>
<p>
    <label for="obirsc_woo_product_id">
        <strong><?php esc_html_e( 'Link to WooCommerce Product', 'obydullah-restaurant-shop-core' ); ?></strong>
    </label><br>
    <select name="obirsc_woo_product_id" id="obirsc_woo_product_id" class="widefat">
        <option value="">
            <?php esc_html_e( '— No Product Linked —', 'obydullah-restaurant-shop-core' ); ?>
        </option>
        <?php foreach ( $products as $id => $title ) : ?>
        <option value="<?php echo esc_attr( $id ); ?>" <?php selected( $woo_product_id, $id ); ?>>
            <?php echo esc_html( $title ); ?>
        </option>
        <?php endforeach; ?>
    </select>
    <span class="description">
        <?php esc_html_e( 'Select a WooCommerce product to link this Chef\'s Special item.', 'obydullah-restaurant-shop-core' ); ?>
    </span>
</p>
<?php else : ?>
<p class="description">
    <?php esc_html_e( 'WooCommerce is not active or no products found.', 'obydullah-restaurant-shop-core' ); ?>
</p>
<?php endif; ?>

<?php
}

function obirsc_save_chef_special_meta( $post_id ) {
    if ( ! isset( $_POST['obirsc_chef_special_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['obirsc_chef_special_nonce'] ) ), 'obirsc_save_chef_special_meta' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( 'obirsc_chef_special' !== get_post_type( $post_id ) ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['obirsc_subtitle'] ) ) {
        update_post_meta( $post_id, 'obirsc_subtitle', sanitize_text_field( wp_unslash( $_POST['obirsc_subtitle'] ) ) );
    }

    if ( isset( $_POST['obirsc_body'] ) ) {
        update_post_meta( $post_id, 'obirsc_body', sanitize_textarea_field( wp_unslash( $_POST['obirsc_body'] ) ) );
    }

    if ( isset( $_POST['obirsc_woo_product_id'] ) ) {
        update_post_meta( $post_id, '_obirsc_woo_product_id', intval( $_POST['obirsc_woo_product_id'] ) );
    }
}
add_action( 'save_post_obirsc_chef_special', 'obirsc_save_chef_special_meta' );

/* ====================================================================
   4. Menu Items CPT + Category Taxonomy + Meta Boxes + WooCommerce
======================================================================= */

function obirsc_register_menu_item() {
    register_post_type( 'obirsc_menu_item', array(
          'labels'      => array(
            'name'          => __( 'Menu Items', 'obydullah-restaurant-shop-core' ),
            'singular_name' => __( 'Menu Item', 'obydullah-restaurant-shop-core' ),
            'add_new_item'  => __( 'Add New Menu Item', 'obydullah-restaurant-shop-core' ),
            'edit_item'     => __( 'Edit Menu Item', 'obydullah-restaurant-shop-core' ),
        ),
        'public'      => true,
        'show_in_menu'        => 'obirsc-restaurant-core',
        'menu_icon'   => 'dashicons-food',
        'supports'    => array( 'title', 'thumbnail' ),
        'show_in_rest'=> true,
    ) );
}
add_action( 'init', 'obirsc_register_menu_item' );

function obirsc_register_menu_category() {
    register_taxonomy( 'obirsc_menu_category', 'obirsc_menu_item', array(
        'labels' => array(
            'name'              => __( 'Categories', 'obydullah-restaurant-shop-core' ),
            'singular_name'     => __( 'Category', 'obydullah-restaurant-shop-core' ),
            'add_new_item'      => __( 'Add New Category', 'obydullah-restaurant-shop-core' ),
            'new_item_name'     => __( 'New Category Name', 'obydullah-restaurant-shop-core' ),
        ),
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
    ) );
}
add_action( 'init', 'obirsc_register_menu_category' );

function obirsc_add_menu_item_subtitle_meta_box() {
    add_meta_box( 'obirsc_menu_item_subtitle', __( 'Subtitle', 'obydullah-restaurant-shop-core' ), 'obirsc_subtitle_callback', 'obirsc_menu_item', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'obirsc_add_menu_item_subtitle_meta_box' );

function obirsc_subtitle_callback( $post ) {
    wp_nonce_field( 'obirsc_menu_item_meta', 'obirsc_menu_item_nonce' );
    $subtitle = get_post_meta( $post->ID, 'obirsc_menu_subtitle', true );
    echo '<textarea name="obirsc_menu_subtitle" rows="2" class="large-text">' . esc_textarea( $subtitle ) . '</textarea>';
}

function obirsc_add_price_meta_box() {
    add_meta_box( 'obirsc_menu_price', __( 'Price & WooCommerce', 'obydullah-restaurant-shop-core' ), 'obirsc_price_callback', 'obirsc_menu_item', 'side', 'default' );
}
add_action( 'add_meta_boxes', 'obirsc_add_price_meta_box' );


function obirsc_price_callback( $post ) {
    wp_nonce_field( 'obirsc_menu_item_meta', 'obirsc_menu_item_nonce' );

    $price          = get_post_meta( $post->ID, 'obirsc_menu_price', true );
    $woo_product_id = get_post_meta( $post->ID, '_obirsc_woo_product_id', true );

    // Build product list for WooCommerce dropdown
    $products = array();
    if ( class_exists( 'WooCommerce' ) ) {
        $product_query = get_posts( array(
            'post_type'      => 'product',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'orderby'        => 'title',
            'order'          => 'ASC',
        ) );

        foreach ( $product_query as $product_post ) {
            $product = wc_get_product( $product_post->ID );
            if ( $product ) {
                 $clean_price = wp_strip_all_tags( wc_price( $product->get_price() ) );
                $products[ $product_post->ID ] = $product_post->post_title . ' (' . $clean_price . ')';
            }
        }
    }
    ?>

<!-- Price Field -->
<p>
    <label for="obirsc_menu_price">
        <strong><?php esc_html_e( 'Price', 'obydullah-restaurant-shop-core' ); ?></strong>
    </label><br>
    <input type="text" name="obirsc_menu_price" id="obirsc_menu_price" value="<?php echo esc_attr( $price ); ?>"
        class="widefat" placeholder="<?php esc_attr_e( '$48', 'obydullah-restaurant-shop-core' ); ?>">
</p>

<?php if ( class_exists( 'WooCommerce' ) && ! empty( $products ) ) : ?>
<hr>
<h3><?php esc_html_e( 'WooCommerce Product Link', 'obydullah-restaurant-shop-core' ); ?></h3>
<p>
    <label for="obirsc_woo_product_id">
        <strong><?php esc_html_e( 'Link to WooCommerce Product', 'obydullah-restaurant-shop-core' ); ?></strong>
    </label><br>
    <select name="obirsc_woo_product_id" id="obirsc_woo_product_id" class="widefat">
        <option value="">
            <?php esc_html_e( '— No Product Linked —', 'obydullah-restaurant-shop-core' ); ?>
        </option>
        <?php foreach ( $products as $id => $title ) : ?>
        <option value="<?php echo esc_attr( $id ); ?>" <?php selected( $woo_product_id, $id ); ?>>
            <?php echo esc_html( $title ); ?>
        </option>
        <?php endforeach; ?>
    </select>
    <span class="description">
        <?php esc_html_e( 'Select a WooCommerce product to link this menu item.', 'obydullah-restaurant-shop-core' ); ?>
    </span>
</p>
<?php else : ?>
<p class="description">
    <?php esc_html_e( 'WooCommerce is not active or no products found.', 'obydullah-restaurant-shop-core' ); ?>
</p>
<?php endif; ?>

<?php
}

function obirsc_save_menu_item_meta( $post_id ) {
    if ( ! isset( $_POST['obirsc_menu_item_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['obirsc_menu_item_nonce'] ) ), 'obirsc_menu_item_meta' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    if ( 'obirsc_menu_item' !== get_post_type( $post_id ) ) {
        return;
    }
    if ( isset( $_POST['obirsc_menu_subtitle'] ) ) {
        update_post_meta( $post_id, 'obirsc_menu_subtitle', sanitize_textarea_field( wp_unslash( $_POST['obirsc_menu_subtitle'] ) ) );
    }
    if ( isset( $_POST['obirsc_menu_price'] ) ) {
        update_post_meta( $post_id, 'obirsc_menu_price', sanitize_text_field( wp_unslash( $_POST['obirsc_menu_price'] ) ) );
    }
    // Save WooCommerce product link
    if ( isset( $_POST['obirsc_woo_product_id'] ) ) {
        update_post_meta( $post_id, '_obirsc_woo_product_id', intval( $_POST['obirsc_woo_product_id'] ) );
    }
}
add_action( 'save_post_obirsc_menu_item', 'obirsc_save_menu_item_meta' );


/* ======================================================
   5. Menu Area (Single Instance) + Meta Boxes
====================================================== */

function obirsc_register_menu_area() {
    register_post_type( 'obirsc_menu_area', array(
        'labels'        => array(
            'name'          => __( 'Menu Area', 'obydullah-restaurant-shop-core' ),
            'singular_name' => __( 'Menu Area', 'obydullah-restaurant-shop-core' ),
            'add_new_item'  => __( 'Edit Menu Area', 'obydullah-restaurant-shop-core' ),
            'edit_item'     => __( 'Edit Menu Area', 'obydullah-restaurant-shop-core' ),
        ),
        'public'           => false,
        'show_ui'          => true,
        'show_in_menu'     => 'obirsc-restaurant-core',
        'menu_icon'        => 'dashicons-menu',
        'supports'         => array( 'title', 'thumbnail' ),
        'show_in_rest'     => true,
        'capability_type'  => 'post',
        'map_meta_cap'     => true,
    ) );
}
add_action( 'init', 'obirsc_register_menu_area' );

function obirsc_limit_menu_area() {
    global $pagenow;
if ( $pagenow === 'post-new.php' && isset( $_GET['post_type'] ) && $_GET['post_type'] === 'obirsc_menu_area' ) {
        $existing = get_posts( array(
            'post_type'      => 'obirsc_menu_area',
            'posts_per_page' => 1,
            'post_status'    => 'publish',
            'fields'         => 'ids',
        ) );
        if ( ! empty( $existing ) ) {
            $post_id = $existing[0];
            if ( current_user_can( 'edit_post', $post_id ) ) {
                wp_redirect( admin_url( 'post.php?post=' . $post_id . '&action=edit' ) );
                exit;
            }
        }
    }
}
add_action( 'admin_init', 'obirsc_limit_menu_area' );

function obirsc_add_menu_area_subtitle_meta() {
    add_meta_box(
        'menu_area_subtitle',
        __( 'Subtitle', 'obydullah-restaurant-shop-core' ),
        'obirsc_menu_area_subtitle_callback',
        'obirsc_menu_area',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'obirsc_add_menu_area_subtitle_meta' );

function obirsc_menu_area_subtitle_callback( $post ) {
    wp_nonce_field( 'obirsc_menu_area_meta', 'obirsc_menu_area_nonce' );
    $subtitle = get_post_meta( $post->ID, 'obirsc_menu_area_subtitle', true );
    echo '<textarea name="obirsc_menu_area_subtitle" rows="2" class="large-text">' . esc_textarea( $subtitle ) . '</textarea>';
}

function obirsc_save_menu_area_meta( $post_id ) {
    if ( ! isset( $_POST['obirsc_menu_area_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['obirsc_menu_area_nonce'] ) ), 'obirsc_menu_area_meta' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    if ( get_post_type( $post_id ) !== 'obirsc_menu_area' ) {
        return;
    }
    if ( isset( $_POST['obirsc_menu_area_subtitle'] ) ) {
        update_post_meta( $post_id, 'obirsc_menu_area_subtitle', sanitize_textarea_field( wp_unslash( $_POST['obirsc_menu_area_subtitle'] ) ) );
    }
}
add_action( 'save_post_obirsc_menu_area', 'obirsc_save_menu_area_meta' );

/* ======================================================
   6. Testimonials CPT + Meta Boxes
====================================================== */

function obirsc_register_testimonial() {
    register_post_type( 'obirsc_testimonial', array(
        'labels' => array(
            'name'          => __( 'Testimonials', 'obydullah-restaurant-shop-core' ),
            'singular_name' => __( 'Testimonial', 'obydullah-restaurant-shop-core' ),
            'add_new_item'  => __( 'Add New Testimonial', 'obydullah-restaurant-shop-core' ),
            'edit_item'     => __( 'Edit Testimonial', 'obydullah-restaurant-shop-core' ),
        ),
        'public'          => true,
        'show_in_menu'    => 'obirsc-restaurant-core',
        'menu_icon'       => 'dashicons-format-quote',
        'supports'        => array( 'title' ),
        'show_in_rest'    => true,
        'has_archive'     => false,
        'publicly_queryable' => true,
    ) );
}
add_action( 'init', 'obirsc_register_testimonial' );

function obirsc_add_testimonial_meta_boxes() {
    add_meta_box(
        'obirsc_testimonial_quote',
        __( 'Quote', 'obydullah-restaurant-shop-core' ),
        'obirsc_testimonial_quote_callback',
        'obirsc_testimonial',
        'normal',
        'high'
    );
    add_meta_box(
        'obirsc_testimonial_role',
        __( 'Role / Title', 'obydullah-restaurant-shop-core' ),
        'obirsc_testimonial_role_callback',
        'obirsc_testimonial',
        'side',
        'default'
    );
}
add_action( 'add_meta_boxes', 'obirsc_add_testimonial_meta_boxes' );

function obirsc_testimonial_quote_callback( $post ) {
    wp_nonce_field( 'obirsc_testimonial_meta', 'obirsc_testimonial_nonce' );
    $quote = get_post_meta( $post->ID, 'obirsc_testimonial_quote', true );
    echo '<textarea name="obirsc_testimonial_quote" rows="4" class="large-text">' . esc_textarea( $quote ) . '</textarea>';
}

function obirsc_testimonial_role_callback( $post ) {
    $role = get_post_meta( $post->ID, 'obirsc_testimonial_role', true );
    echo '<input type="text" name="obirsc_testimonial_role" value="' . esc_attr( $role ) . '" class="widefat" placeholder="' . esc_attr__( 'e.g., Food Critic', 'obydullah-restaurant-shop-core' ) . '">';
}

function obirsc_save_testimonial_meta( $post_id ) {
    if ( ! isset( $_POST['obirsc_testimonial_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['obirsc_testimonial_nonce'] ) ), 'obirsc_testimonial_meta' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( get_post_type( $post_id ) !== 'obirsc_testimonial' ) {
        return;
    }

    if ( isset( $_POST['obirsc_testimonial_quote'] ) ) {
        update_post_meta( $post_id, 'obirsc_testimonial_quote', sanitize_textarea_field( wp_unslash( $_POST['obirsc_testimonial_quote'] ) ) );
    }

    if ( isset( $_POST['obirsc_testimonial_role'] ) ) {
        update_post_meta( $post_id, 'obirsc_testimonial_role', sanitize_text_field( wp_unslash( $_POST['obirsc_testimonial_role'] ) ) );
    }
}
add_action( 'save_post_obirsc_testimonial', 'obirsc_save_testimonial_meta' );


/* ======================================================
   7. Testimonial Area (Single Instance)
====================================================== */

function obirsc_register_testimonial_area() {
    register_post_type( 'obirsc_testi_area', array(
        'labels'        => array(
            'name'          => __( 'Testimonial Area', 'obydullah-restaurant-shop-core' ),
            'singular_name' => __( 'Testimonial Area', 'obydullah-restaurant-shop-core' ),
            'add_new_item'  => __( 'Edit Testimonial Area', 'obydullah-restaurant-shop-core' ),
            'edit_item'     => __( 'Edit Testimonial Area', 'obydullah-restaurant-shop-core' ),
        ),
        'public'           => false,
        'show_ui'          => true,
        'show_in_menu'     => 'obirsc-restaurant-core',
        'menu_icon'        => 'dashicons-menu',
        'supports'         => array( 'title', 'thumbnail' ),
        'show_in_rest'     => true,
        'capability_type'  => 'post',
        'map_meta_cap'     => true,
    ) );
}
add_action( 'init', 'obirsc_register_testimonial_area' );

function obirsc_limit_testimonial_area() {
    global $pagenow;
if ( $pagenow === 'post-new.php' && isset( $_GET['post_type'] ) && $_GET['post_type'] === 'obirsc_testi_area' ) {
        $existing = get_posts( array(
            'post_type'      => 'obirsc_testi_area',
            'posts_per_page' => 1,
            'post_status'    => 'publish',
            'fields'         => 'ids',
        ) );
        if ( ! empty( $existing ) ) {
            $post_id = $existing[0];
            if ( current_user_can( 'edit_post', $post_id ) ) {
                wp_redirect( admin_url( 'post.php?post=' . $post_id . '&action=edit' ) );
                exit;
            }
        }
    }
}
add_action( 'admin_init', 'obirsc_limit_testimonial_area' );

/* ======================================================
   8. Opening Hours (Single Instance) + Repeater Hours
====================================================== */

function obirsc_register_opening_hours_cpt() {
    register_post_type( 'obirsc_opening_hours', array(
        'labels' => array(
            'name'          => __( 'Opening Hours', 'obydullah-restaurant-shop-core' ),
            'singular_name' => __( 'Opening Hours', 'obydullah-restaurant-shop-core' ),
            'add_new_item'  => __( 'Edit Opening Hours', 'obydullah-restaurant-shop-core' ),
            'edit_item'     => __( 'Edit Opening Hours', 'obydullah-restaurant-shop-core' ),
        ),
        'public'           => false,
        'show_ui'          => true,
        'show_in_menu'     => 'obirsc-restaurant-core',
        'menu_icon'        => 'dashicons-clock',
        'supports'         => array( 'title' ),
        'show_in_rest'     => true,
        'capability_type'  => 'post',
        'map_meta_cap'     => true,
    ) );
}
add_action( 'init', 'obirsc_register_opening_hours_cpt' );

function obirsc_limit_opening_hours() {
    global $pagenow;
    if ( $pagenow === 'post-new.php' && isset( $_GET['post_type'] ) && $_GET['post_type'] === 'obirsc_opening_hours' ) {
        $existing = get_posts( array(
            'post_type'      => 'obirsc_opening_hours',
            'posts_per_page' => 1,
            'post_status'    => 'publish',
            'fields'         => 'ids',
        ) );
        if ( ! empty( $existing ) ) {
            $post_id = $existing[0];
            if ( current_user_can( 'edit_post', $post_id ) ) {
                wp_redirect( admin_url( 'post.php?post=' . $post_id . '&action=edit' ) );
                exit;
            }
        }
    }
}
add_action( 'admin_init', 'obirsc_limit_opening_hours' );

function obirsc_enqueue_opening_hours_assets( $hook ) {
    global $post_type;
    if ( 'obirsc_opening_hours' === $post_type && in_array( $hook, array( 'post.php', 'post-new.php' ) ) ) {
        wp_enqueue_style(
            'obirsc-admin-css',
            OBIRSC_PLUGIN_URL . 'assets/css/opening-hours.css',
            array(),
            OBIRSC_VERSION
        );
        wp_enqueue_script(
            'obirsc-admin-js',
            OBIRSC_PLUGIN_URL . 'assets/js/opening-hours.js',
            array( 'jquery' ),
            OBIRSC_VERSION,
            true
        );
        wp_localize_script( 'obirsc-admin-js', 'obirsc_opening_hours', array(
            'dayPlaceholder' => __( 'Day(s)', 'obydullah-restaurant-shop-core' ),
            'timePlaceholder' => __( 'Time', 'obydullah-restaurant-shop-core' ),
            'removeText'      => __( 'Remove', 'obydullah-restaurant-shop-core' ),
        ) );
    }
}
add_action( 'admin_enqueue_scripts', 'obirsc_enqueue_opening_hours_assets' );

function obirsc_add_opening_hours_meta_boxes() {
    add_meta_box(
        'obirsc_opening_hours_repeater',
        __( 'Opening Hours', 'obydullah-restaurant-shop-core' ),
        'obirsc_render_opening_hours_repeater',
        'obirsc_opening_hours',
        'normal',
        'high'
    );
    add_meta_box(
        'obirsc_opening_hours_note',
        __( 'Note', 'obydullah-restaurant-shop-core' ),
        'obirsc_render_opening_hours_note',
        'obirsc_opening_hours',
        'side',
        'default'
    );
}
add_action( 'add_meta_boxes', 'obirsc_add_opening_hours_meta_boxes' );

function obirsc_render_opening_hours_repeater( $post ) {
    $hours = get_post_meta( $post->ID, 'obirsc_opening_hours', true );
    if ( ! is_array( $hours ) ) {
        $hours = array(
            array( 'day' => __( 'Monday – Thursday', 'obydullah-restaurant-shop-core' ), 'time' => __( '5 PM – 10 PM', 'obydullah-restaurant-shop-core' ) ),
            array( 'day' => __( 'Friday', 'obydullah-restaurant-shop-core' ), 'time' => __( '5 PM – 11 PM', 'obydullah-restaurant-shop-core' ) ),
            array( 'day' => __( 'Saturday', 'obydullah-restaurant-shop-core' ), 'time' => __( '12 PM – 11 PM', 'obydullah-restaurant-shop-core' ) ),
            array( 'day' => __( 'Sunday', 'obydullah-restaurant-shop-core' ), 'time' => __( '12 PM – 9 PM', 'obydullah-restaurant-shop-core' ) ),
        );
    }
    wp_nonce_field( 'obirsc_save_opening_hours', 'obirsc_opening_hours_nonce' );
    ?>
<div id="obirsc-hours-repeater">
    <?php foreach ( $hours as $item ) : ?>
    <div class="obirsc-hours-row">
        <input type="text" name="obirsc_hours_day[]" class="obirsc-hours-day"
            value="<?php echo esc_attr( $item['day'] ); ?>"
            placeholder="<?php esc_attr_e( 'Day(s)', 'obydullah-restaurant-shop-core' ); ?>">
        <input type="text" name="obirsc_hours_time[]" class="obirsc-hours-time"
            value="<?php echo esc_attr( $item['time'] ); ?>"
            placeholder="<?php esc_attr_e( 'Time', 'obydullah-restaurant-shop-core' ); ?>">
        <button type="button"
            class="button obirsc-remove-row"><?php esc_html_e( 'Remove', 'obydullah-restaurant-shop-core' ); ?></button>
    </div>
    <?php endforeach; ?>
</div>
<button type="button" id="obirsc-add-hours-row"
    class="button"><?php esc_html_e( 'Add new row', 'obydullah-restaurant-shop-core' ); ?></button>
<?php
}

function obirsc_render_opening_hours_note( $post ) {
    $note = get_post_meta( $post->ID, 'obirsc_opening_hours_note', true );

    wp_nonce_field( 'obirsc_save_opening_hours', 'obirsc_opening_hours_nonce' );
    ?>
<textarea name="obirsc_opening_hours_note" class="obirsc-hours-note-textarea"
    rows="3"><?php echo esc_textarea( $note ); ?></textarea>
<p class="description">
    <?php esc_html_e( 'E.g., “Last reservation 30 minutes before closing”', 'obydullah-restaurant-shop-core' ); ?></p>
<?php
}

function obirsc_save_opening_hours_meta( $post_id ) {
    if ( ! isset( $_POST['obirsc_opening_hours_nonce'] ) ||
         ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['obirsc_opening_hours_nonce'] ) ), 'obirsc_save_opening_hours' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( get_post_type( $post_id ) !== 'obirsc_opening_hours' ) {
        return;
    }

    if ( isset( $_POST['obirsc_hours_day'] ) && isset( $_POST['obirsc_hours_time'] ) ) {
        $days  = array_map( 'sanitize_text_field', wp_unslash( $_POST['obirsc_hours_day'] ) );
        $times = array_map( 'sanitize_text_field', wp_unslash( $_POST['obirsc_hours_time'] ) );
        $hours = array();
        $count = count( $days );
        for ( $i = 0; $i < $count; $i++ ) {
            if ( ! empty( $days[ $i ] ) && ! empty( $times[ $i ] ) ) {
                $hours[] = array( 'day' => $days[ $i ], 'time' => $times[ $i ] );
            }
        }
        update_post_meta( $post_id, 'obirsc_opening_hours', $hours );
    } else {
        update_post_meta( $post_id, 'obirsc_opening_hours', array() );
    }

    if ( isset( $_POST['obirsc_opening_hours_note'] ) ) {
        update_post_meta( $post_id, 'obirsc_opening_hours_note', sanitize_textarea_field( wp_unslash( $_POST['obirsc_opening_hours_note'] ) ) );
    }
}
add_action( 'save_post_obirsc_opening_hours', 'obirsc_save_opening_hours_meta' );


/* ===================================================================
   9. Table Reservations (Custom DB table, AJAX handler, Admin List)
======================================================================= */

function obirsc_create_booking_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'obirsc_restaurant_booking';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name varchar(100) NOT NULL,
        email varchar(100) NOT NULL,
        phone varchar(50) NOT NULL,
        party tinyint(2) NOT NULL,
        booking_date date NOT NULL,
        booking_time time NOT NULL,
        notes text,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta( $sql );
}
register_activation_hook( __FILE__, 'obirsc_create_booking_table' );

function obirsc_drop_booking_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'obirsc_restaurant_booking';
    $wpdb->query( "DROP TABLE IF EXISTS $table_name" );
}
register_uninstall_hook( __FILE__, 'obirsc_drop_booking_table' );

function obirsc_handle_booking_submission() {
    if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'obirsc_booking_nonce' ) ) {
        wp_send_json_error( array( 'error' => __( 'Security check failed.', 'obydullah-restaurant-shop-core' ) ), 403 );
    }

    $name    = sanitize_text_field( wp_unslash( $_POST['name'] ?? '' ) );
    $email   = sanitize_email( wp_unslash( $_POST['email'] ?? '' ) );
    $phone   = sanitize_text_field( wp_unslash( $_POST['phone'] ?? '' ) );
    $party   = intval( $_POST['party'] ?? 0 );
    $date    = sanitize_text_field( wp_unslash( $_POST['date'] ?? '' ) );
    $time    = sanitize_text_field( wp_unslash( $_POST['time'] ?? '' ) );
    $notes   = sanitize_textarea_field( wp_unslash( $_POST['notes'] ?? '' ) );

    $errors = array();
    if ( empty( $name ) ) {
        $errors[] = __( 'Name is required.', 'obydullah-restaurant-shop-core' );
    }
    if ( ! is_email( $email ) ) {
        $errors[] = __( 'Valid email is required.', 'obydullah-restaurant-shop-core' );
    }
    if ( empty( $phone ) ) {
        $errors[] = __( 'Phone number is required.', 'obydullah-restaurant-shop-core' );
    }
    if ( $party < 1 ) {
        $errors[] = __( 'Party size must be at least 1.', 'obydullah-restaurant-shop-core' );
    }
    if ( ! preg_match( '/^\d{4}-\d{2}-\d{2}$/', $date ) ) {
        $errors[] = __( 'Invalid date format.', 'obydullah-restaurant-shop-core' );
    }
    if ( ! preg_match( '/^\d{2}:\d{2}$/', $time ) ) {
        $errors[] = __( 'Invalid time format.', 'obydullah-restaurant-shop-core' );
    }

    if ( ! empty( $errors ) ) {
        wp_send_json_error( array( 'errors' => $errors ) );
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'obirsc_restaurant_booking';

    $result = $wpdb->insert(
        $table_name,
        array(
            'name'         => $name,
            'email'        => $email,
            'phone'        => $phone,
            'party'        => $party,
            'booking_date' => $date,
            'booking_time' => $time,
            'notes'        => $notes,
        ),
        array( '%s', '%s', '%s', '%d', '%s', '%s', '%s' )
    );

    if ( false === $result ) {
        wp_send_json_error( array( 'error' => __( 'Database error. Please try again.', 'obydullah-restaurant-shop-core' ) ) );
    }

    wp_send_json_success( array( 'message' => __( 'Your reservation has been submitted. We’ll contact you shortly.', 'obydullah-restaurant-shop-core' ) ) );
}
add_action( 'wp_ajax_obirsc_booking', 'obirsc_handle_booking_submission' );
add_action( 'wp_ajax_nopriv_obirsc_booking', 'obirsc_handle_booking_submission' );

function obirsc_bookings_admin_menu() {
    add_submenu_page(
        'obirsc-restaurant-core',
        __( 'Table Bookings', 'obydullah-restaurant-shop-core' ),
        __( 'Table Bookings', 'obydullah-restaurant-shop-core' ),
        'manage_options',
        'obirsc-bookings',
        'obirsc_render_bookings_page'
    );
}
add_action( 'admin_menu', 'obirsc_bookings_admin_menu' );

function obirsc_render_bookings_page() {
    if ( isset( $_POST['action'] ) && 'delete' === $_POST['action'] && isset( $_POST['booking_ids'] ) ) {
        check_admin_referer( 'bulk-bookings' );
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_html__( 'Unauthorized.', 'obydullah-restaurant-shop-core' ) );
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'obirsc_restaurant_booking';
        $ids = array_map( 'intval', $_POST['booking_ids'] );
        if ( ! empty( $ids ) ) {
            $placeholders = implode( ',', array_fill( 0, count( $ids ), '%d' ) );
            $wpdb->query( $wpdb->prepare( "DELETE FROM $table_name WHERE id IN ($placeholders)", $ids ) );
            echo '<div class="notice notice-success"><p>' . esc_html__( 'Bookings deleted.', 'obydullah-restaurant-shop-core' ) . '</p></div>';
        }
    }

    if ( ! class_exists( 'OBIRSC_Booking_List_Table' ) ) {
        require_once OBIRSC_PLUGIN_DIR . 'includes/obirsc-booking-list-table.php';
    }

    $bookings_table = new OBIRSC_Booking_List_Table();
    $bookings_table->prepare_items();
    ?>
<div class="wrap">
    <h1><?php esc_html_e( 'Table Reservations', 'obydullah-restaurant-shop-core' ); ?></h1>
    <form method="post">
        <?php $bookings_table->display(); ?>
        <?php wp_nonce_field( 'bulk-bookings' ); ?>
    </form>
</div>
<?php
}

/* ======================================================
   10. Footer Settings (Single Instance) + Meta Boxes
====================================================== */

function obirsc_register_footer_settings() {
    register_post_type( 'obirsc_footer', array(
        'labels' => array(
            'name'          => __( 'Footer Settings', 'obydullah-restaurant-shop-core' ),
            'singular_name' => __( 'Footer Settings', 'obydullah-restaurant-shop-core' ),
            'add_new_item'  => __( 'Edit Footer Settings', 'obydullah-restaurant-shop-core' ),
            'edit_item'     => __( 'Edit Footer Settings', 'obydullah-restaurant-shop-core' ),
        ),
        'public'           => false,
        'show_ui'          => true,
        'show_in_menu'     => 'obirsc-restaurant-core',
        'menu_icon'        => 'dashicons-layout',
        'supports'         => array( 'title' ),
        'show_in_rest'     => true,
        'capability_type'  => 'post',
        'map_meta_cap'     => true,
    ) );
}
add_action( 'init', 'obirsc_register_footer_settings' );

function obirsc_limit_footer_settings() {
    global $pagenow;
    if ( $pagenow === 'post-new.php' && isset( $_GET['post_type'] ) && $_GET['post_type'] === 'obirsc_footer' ) {
        $existing = get_posts( array(
            'post_type'      => 'obirsc_footer',
            'posts_per_page' => 1,
            'post_status'    => 'publish',
            'fields'         => 'ids',
        ) );
        if ( ! empty( $existing ) ) {
            $post_id = $existing[0];
            if ( current_user_can( 'edit_post', $post_id ) ) {
                wp_redirect( admin_url( 'post.php?post=' . $post_id . '&action=edit' ) );
                exit;
            }
        }
    }
}
add_action( 'admin_init', 'obirsc_limit_footer_settings' );

function obirsc_add_footer_meta_boxes() {
    add_meta_box( 'obirsc_footer_logo', __( 'Logo & Tagline', 'obydullah-restaurant-shop-core' ), 'obirsc_footer_logo_callback', 'obirsc_footer', 'normal', 'high' );
    add_meta_box( 'obirsc_footer_social', __( 'Social Media URLs', 'obydullah-restaurant-shop-core' ), 'obirsc_footer_social_callback', 'obirsc_footer', 'normal', 'high' );
    add_meta_box( 'obirsc_footer_quick_links', __( 'Quick Links (repeater)', 'obydullah-restaurant-shop-core' ), 'obirsc_footer_links_callback', 'obirsc_footer', 'normal', 'high' );
    add_meta_box( 'obirsc_footer_contact', __( 'Contact Information', 'obydullah-restaurant-shop-core' ), 'obirsc_footer_contact_callback', 'obirsc_footer', 'normal', 'high' );
    add_meta_box( 'obirsc_footer_copyright', __( 'Copyright Text', 'obydullah-restaurant-shop-core' ), 'obirsc_footer_copyright_callback', 'obirsc_footer', 'side', 'default' );
}
add_action( 'add_meta_boxes', 'obirsc_add_footer_meta_boxes' );

function obirsc_footer_logo_callback( $post ) {
    wp_nonce_field( 'obirsc_footer_meta', 'obirsc_footer_nonce' );
    $logo_text   = get_post_meta( $post->ID, 'obirsc_footer_logo_text', true );
    $logo_accent = get_post_meta( $post->ID, 'obirsc_footer_logo_accent', true );
    $tagline     = get_post_meta( $post->ID, 'obirsc_footer_tagline', true );
    ?>
<p>
    <label
        for="obirsc_footer_logo_text"><?php esc_html_e( 'Logo Base Text', 'obydullah-restaurant-shop-core' ); ?></label><br>
    <input type="text" name="obirsc_footer_logo_text" id="obirsc_footer_logo_text"
        value="<?php echo esc_attr( $logo_text ); ?>" class="widefat">
</p>
<p>
    <label
        for="obirsc_footer_logo_accent"><?php esc_html_e( 'Logo Accent Text (highlighted)', 'obydullah-restaurant-shop-core' ); ?></label><br>
    <input type="text" name="obirsc_footer_logo_accent" id="obirsc_footer_logo_accent"
        value="<?php echo esc_attr( $logo_accent ); ?>" class="widefat">
</p>
<p>
    <label
        for="obirsc_footer_tagline"><?php esc_html_e( 'Tagline / Description', 'obydullah-restaurant-shop-core' ); ?></label><br>
    <textarea name="obirsc_footer_tagline" id="obirsc_footer_tagline" rows="3"
        class="large-text"><?php echo esc_textarea( $tagline ); ?></textarea>
</p>
<?php
}

function obirsc_footer_social_callback( $post ) {
    wp_nonce_field( 'obirsc_footer_meta', 'obirsc_footer_nonce' );
    $social = get_post_meta( $post->ID, 'obirsc_footer_social', true );
    if ( ! is_array( $social ) ) $social = array();
    ?>
<p>
    <label
        for="obirsc_footer_social_instagram"><?php esc_html_e( 'Instagram URL', 'obydullah-restaurant-shop-core' ); ?></label><br>
    <input type="text" name="obirsc_footer_social[instagram]" id="obirsc_footer_social_instagram"
        value="<?php echo esc_attr( $social['instagram'] ?? '' ); ?>" class="widefat">
</p>
<p>
    <label
        for="obirsc_footer_social_facebook"><?php esc_html_e( 'Facebook URL', 'obydullah-restaurant-shop-core' ); ?></label><br>
    <input type="text" name="obirsc_footer_social[facebook]" id="obirsc_footer_social_facebook"
        value="<?php echo esc_attr( $social['facebook'] ?? '' ); ?>" class="widefat">
</p>
<p>
    <label
        for="obirsc_footer_social_x"><?php esc_html_e( 'X (Twitter) URL', 'obydullah-restaurant-shop-core' ); ?></label><br>
    <input type="text" name="obirsc_footer_social[x]" id="obirsc_footer_social_x"
        value="<?php echo esc_attr( $social['x'] ?? '' ); ?>" class="widefat">
</p>
<?php
}

function obirsc_footer_links_callback( $post ) {
    wp_nonce_field( 'obirsc_footer_meta', 'obirsc_footer_nonce' );
    $links = get_post_meta( $post->ID, 'obirsc_footer_links', true );
    if ( ! is_array( $links ) ) $links = array();
    $next_index = count( $links );
    ?>
<div id="obirsc-footer-links-repeater" class="obirsc-repeater">
    <input type="hidden" id="obirsc-footer-link-count" name="obirsc_footer_link_count"
        value="<?php echo esc_attr( $next_index ); ?>">
    <?php foreach ( $links as $index => $link ) : ?>
    <div class="obirsc-footer-link-row obirsc-repeater-row" data-index="<?php echo esc_attr( $index ); ?>">
        <input type="text" name="obirsc_footer_links[<?php echo esc_attr( $index ); ?>][text]" class="obirsc-link-text"
            value="<?php echo esc_attr( $link['text'] ); ?>"
            placeholder="<?php esc_attr_e( 'Link text', 'obydullah-restaurant-shop-core' ); ?>">
        <input type="text" name="obirsc_footer_links[<?php echo esc_attr( $index ); ?>][url]" class="obirsc-link-url"
            value="<?php echo esc_attr( $link['url'] ); ?>"
            placeholder="<?php esc_attr_e( 'URL', 'obydullah-restaurant-shop-core' ); ?>">
        <button type="button"
            class="button obirsc-remove-row"><?php esc_html_e( 'Remove', 'obydullah-restaurant-shop-core' ); ?></button>
    </div>
    <?php endforeach; ?>
</div>
<button type="button" id="obirsc-add-footer-link"
    class="button"><?php esc_html_e( 'Add Link', 'obydullah-restaurant-shop-core' ); ?></button>
<?php
}

function obirsc_footer_contact_callback( $post ) {
    wp_nonce_field( 'obirsc_footer_meta', 'obirsc_footer_nonce' );
    $address = get_post_meta( $post->ID, 'obirsc_footer_address', true );
    $phone   = get_post_meta( $post->ID, 'obirsc_footer_phone', true );
    $email   = get_post_meta( $post->ID, 'obirsc_footer_email', true );
    ?>
<p>
    <label for="obirsc_footer_address"><?php esc_html_e( 'Address', 'obydullah-restaurant-shop-core' ); ?></label><br>
    <textarea name="obirsc_footer_address" id="obirsc_footer_address" rows="3"
        class="large-text"><?php echo esc_textarea( $address ); ?></textarea>
</p>
<p>
    <label for="obirsc_footer_phone"><?php esc_html_e( 'Phone', 'obydullah-restaurant-shop-core' ); ?></label><br>
    <input type="tel" name="obirsc_footer_phone" id="obirsc_footer_phone" value="<?php echo esc_attr( $phone ); ?>"
        class="widefat">
</p>
<p>
    <label for="obirsc_footer_email"><?php esc_html_e( 'Email', 'obydullah-restaurant-shop-core' ); ?></label><br>
    <input type="email" name="obirsc_footer_email" id="obirsc_footer_email" value="<?php echo esc_attr( $email ); ?>"
        class="widefat">
</p>
<?php
}

function obirsc_footer_copyright_callback( $post ) {
    wp_nonce_field( 'obirsc_footer_meta', 'obirsc_footer_nonce' );
    $copyright = get_post_meta( $post->ID, 'obirsc_footer_copyright', true );
    ?>
<p>
    <label
        for="obirsc_footer_copyright"><?php esc_html_e( 'Copyright text', 'obydullah-restaurant-shop-core' ); ?></label><br>
    <input type="text" name="obirsc_footer_copyright" id="obirsc_footer_copyright"
        value="<?php echo esc_attr( $copyright ); ?>" class="widefat">
</p>
<?php
}

function obirsc_enqueue_footer_assets( $hook ) {
    global $post_type;
    if ( 'obirsc_footer' === $post_type && in_array( $hook, array( 'post.php', 'post-new.php' ) ) ) {
        wp_enqueue_style( 'obirsc-footer-css', OBIRSC_PLUGIN_URL . 'assets/css/footer-admin.css', array(), OBIRSC_VERSION );
        wp_enqueue_script( 'obirsc-footer-js', OBIRSC_PLUGIN_URL . 'assets/js/footer-admin.js', array( 'jquery' ), OBIRSC_VERSION, true );
        wp_localize_script( 'obirsc-footer-js', 'obirscFooterL10n', array(
            'linkTextPlaceholder' => __( 'Link text', 'obydullah-restaurant-shop-core' ),
            'urlPlaceholder'      => __( 'URL', 'obydullah-restaurant-shop-core' ),
            'removeText'          => __( 'Remove', 'obydullah-restaurant-shop-core' ),
        ) );
    }
}
add_action( 'admin_enqueue_scripts', 'obirsc_enqueue_footer_assets' );

function obirsc_save_footer_meta( $post_id ) {
    if ( ! isset( $_POST['obirsc_footer_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['obirsc_footer_nonce'] ) ), 'obirsc_footer_meta' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( get_post_type( $post_id ) !== 'obirsc_footer' ) {
        return;
    }

    $logo_fields = array( 'obirsc_footer_logo_text', 'obirsc_footer_logo_accent', 'obirsc_footer_tagline' );
    foreach ( $logo_fields as $field ) {
        if ( isset( $_POST[ $field ] ) ) {
            update_post_meta( $post_id, $field, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
        }
    }

    if ( isset( $_POST['obirsc_footer_social'] ) && is_array( $_POST['obirsc_footer_social'] ) ) {
        $social = array();
        foreach ( $_POST['obirsc_footer_social'] as $key => $url ) {
            $social[ $key ] = sanitize_text_field( wp_unslash( $url ) );
        }
        update_post_meta( $post_id, 'obirsc_footer_social', $social );
    }

    if ( isset( $_POST['obirsc_footer_links'] ) && is_array( $_POST['obirsc_footer_links'] ) ) {
        $links = array();
        foreach ( $_POST['obirsc_footer_links'] as $link ) {
            $text = isset( $link['text'] ) ? sanitize_text_field( wp_unslash( $link['text'] ) ) : '';
            $url  = isset( $link['url'] )  ? sanitize_text_field( wp_unslash( $link['url'] ) ) : '';
            if ( ! empty( $text ) && ! empty( $url ) ) {
                $links[] = array( 'text' => $text, 'url' => $url );
            }
        }
        update_post_meta( $post_id, 'obirsc_footer_links', $links );
    } else {

        update_post_meta( $post_id, 'obirsc_footer_links', array() );
    }

    $contact_fields = array( 'obirsc_footer_address', 'obirsc_footer_phone', 'obirsc_footer_email', 'obirsc_footer_copyright' );
    foreach ( $contact_fields as $field ) {
        if ( isset( $_POST[ $field ] ) ) {
            update_post_meta( $post_id, $field, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
        }
    }
}
add_action( 'save_post_obirsc_footer', 'obirsc_save_footer_meta' );

/* ======================================================
   11. About Page (Single Instance) + Meta Boxes
====================================================== */

function obirsc_register_about_page_cpt() {
    register_post_type( 'obirsc_about_page', array(
        'labels' => array(
            'name'          => __( 'About Page', 'obydullah-restaurant-shop-core' ),
            'singular_name' => __( 'About Page', 'obydullah-restaurant-shop-core' ),
            'add_new_item'  => __( 'Edit About Page', 'obydullah-restaurant-shop-core' ),
            'edit_item'     => __( 'Edit About Page', 'obydullah-restaurant-shop-core' ),
        ),
        'public'           => false,
        'show_ui'          => true,
        'show_in_menu'     => 'obirsc-restaurant-core',
        'menu_icon'        => 'dashicons-info',
        'menu_position'    => 65,
        'supports'         => array( 'title' ),
        'show_in_rest'     => true,
    ) );
}
add_action( 'init', 'obirsc_register_about_page_cpt' );

function obirsc_limit_about_page() {
    global $pagenow;

    if ( $pagenow === 'post-new.php' && isset( $_GET['post_type'] ) && $_GET['post_type'] === 'obirsc_about_page' ) {

        $existing = get_posts( array(
            'post_type'      => 'obirsc_about_page',
            'posts_per_page' => 1,
            'post_status'    => 'publish',
            'fields'         => 'ids',
        ) );

        if ( ! empty( $existing ) ) {
            wp_redirect( admin_url( 'post.php?post=' . $existing[0] . '&action=edit' ) );
            exit;
        }
    }
}
add_action( 'admin_init', 'obirsc_limit_about_page' );

function obirsc_add_about_page_meta_boxes() {

    add_meta_box(
        'obirsc_about_header',
        __( 'Header', 'obydullah-restaurant-shop-core' ),
        'obirsc_about_header_callback',
        'obirsc_about_page'
    );

    add_meta_box(
        'obirsc_about_text',
        __( 'Content', 'obydullah-restaurant-shop-core' ),
        'obirsc_about_text_callback',
        'obirsc_about_page'
    );

    add_meta_box(
        'obirsc_about_slider',
        __( 'Slider (repeatable)', 'obydullah-restaurant-shop-core' ),
        'obirsc_about_slider_callback',
        'obirsc_about_page'
    );
}
add_action( 'add_meta_boxes', 'obirsc_add_about_page_meta_boxes' );

function obirsc_about_header_callback( $post ) {
    wp_nonce_field( 'obirsc_about_page_meta', 'obirsc_about_page_nonce' );

    $kicker = get_post_meta( $post->ID, 'obirsc_about_kicker', true );
    $title  = get_post_meta( $post->ID, 'obirsc_about_title', true );
    ?>
<p>
    <label for="obirsc_about_kicker"><?php esc_html_e( 'Kicker', 'obydullah-restaurant-shop-core' ); ?></label><br>
    <input type="text" name="obirsc_about_kicker" id="obirsc_about_kicker" value="<?php echo esc_attr( $kicker ); ?>"
        class="widefat">
</p>
<p>
    <label for="obirsc_about_title"><?php esc_html_e( 'Main Title', 'obydullah-restaurant-shop-core' ); ?></label><br>
    <input type="text" name="obirsc_about_title" id="obirsc_about_title" value="<?php echo esc_attr( $title ); ?>"
        class="widefat">
</p>
<?php
}

function obirsc_about_text_callback( $post ) {

    $chef = get_post_meta( $post->ID, 'obirsc_about_chef_story', true );
    $phil = get_post_meta( $post->ID, 'obirsc_about_philosophy', true );
    ?>
<p>
    <label
        for="obirsc_about_chef_story"><?php esc_html_e( 'Chef Story', 'obydullah-restaurant-shop-core' ); ?></label><br>
    <textarea name="obirsc_about_chef_story" id="obirsc_about_chef_story" rows="6"
        class="large-text"><?php echo esc_textarea( $chef ); ?></textarea>
</p>
<p>
    <label
        for="obirsc_about_philosophy"><?php esc_html_e( 'Philosophy', 'obydullah-restaurant-shop-core' ); ?></label><br>
    <textarea name="obirsc_about_philosophy" id="obirsc_about_philosophy" rows="6"
        class="large-text"><?php echo esc_textarea( $phil ); ?></textarea>
</p>
<?php
}


function obirsc_about_slider_callback( $post ) {

    $slides = get_post_meta( $post->ID, 'obirsc_about_slides', true );
    if ( ! is_array( $slides ) ) {
        $slides = array();
    }
    $next_index = count( $slides );
    ?>
<div id="obirsc-about-slides-repeater" class="obirsc-slides-repeater">
    <input type="hidden" id="obirsc-about-slide-count" name="obirsc_about_slide_count"
        value="<?php echo esc_attr( $next_index ); ?>">
    <?php foreach ( $slides as $index => $slide ) : ?>
    <div class="obirsc-slide-row" data-index="<?php echo esc_attr( $index ); ?>">
        <p>
            <label><?php esc_html_e( 'Title', 'obydullah-restaurant-shop-core' ); ?></label><br>
            <input type="text" name="obirsc_about_slides[<?php echo esc_attr( $index ); ?>][title]"
                value="<?php echo esc_attr( $slide['title'] ); ?>" class="widefat">
        </p>
        <p>
            <label><?php esc_html_e( 'Subtitle', 'obydullah-restaurant-shop-core' ); ?></label><br>
            <input type="text" name="obirsc_about_slides[<?php echo esc_attr( $index ); ?>][subtitle]"
                value="<?php echo esc_attr( $slide['subtitle'] ); ?>" class="widefat">
        </p>
        <div class="slide-image-wrapper">
            <label><?php esc_html_e( 'Background Image', 'obydullah-restaurant-shop-core' ); ?></label><br>
            <input type="hidden" name="obirsc_about_slides[<?php echo esc_attr( $index ); ?>][image]"
                class="slide-image-url" value="<?php echo esc_url( $slide['image'] ); ?>">
            <div class="image-preview">
                <?php if ( ! empty( $slide['image'] ) ) : ?>
                <img src="<?php echo esc_url( $slide['image'] ); ?>" class="preview-thumb">
                <?php endif; ?>
            </div>
            <button type="button"
                class="button select-slide-image"><?php esc_html_e( 'Select Image', 'obydullah-restaurant-shop-core' ); ?></button>
            <button type="button"
                class="button remove-slide-image <?php echo empty( $slide['image'] ) ? 'hidden' : ''; ?>"><?php esc_html_e( 'Remove Image', 'obydullah-restaurant-shop-core' ); ?></button>
        </div>
        <button type="button"
            class="button obirsc-remove-slide-row mt-1"><?php esc_html_e( 'Remove Slide', 'obydullah-restaurant-shop-core' ); ?></button>
    </div>
    <?php endforeach; ?>
</div>
<button type="button" id="obirsc-add-about-slide"
    class="button"><?php esc_html_e( 'Add Slide', 'obydullah-restaurant-shop-core' ); ?></button>
<?php
}

function obirsc_enqueue_about_assets( $hook ) {
    global $post_type;
    if ( 'obirsc_about_page' === $post_type && in_array( $hook, array( 'post.php', 'post-new.php' ) ) ) {
        wp_enqueue_media();
        wp_enqueue_style( 'obirsc-about-css', OBIRSC_PLUGIN_URL . 'assets/css/about-admin.css', array(), OBIRSC_VERSION );
        wp_enqueue_script( 'obirsc-about-js', OBIRSC_PLUGIN_URL . 'assets/js/about-admin.js', array( 'jquery' ), OBIRSC_VERSION, true );
        wp_localize_script( 'obirsc-about-js', 'obirscAboutL10n', array(
            'titlePlaceholder'    => __( 'Title', 'obydullah-restaurant-shop-core' ),
            'subtitlePlaceholder' => __( 'Subtitle', 'obydullah-restaurant-shop-core' ),
            'imagePlaceholder'    => __( 'Background Image', 'obydullah-restaurant-shop-core' ),
            'selectImage'         => __( 'Select Image', 'obydullah-restaurant-shop-core' ),
            'removeImage'         => __( 'Remove Image', 'obydullah-restaurant-shop-core' ),
            'removeText'          => __( 'Remove Slide', 'obydullah-restaurant-shop-core' ),
        ) );
    }
}
add_action( 'admin_enqueue_scripts', 'obirsc_enqueue_about_assets' );

function obirsc_save_about_page_meta( $post_id ) {

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

    if ( ! isset( $_POST['obirsc_about_page_nonce'] ) ) return;

    $nonce = sanitize_text_field( wp_unslash( $_POST['obirsc_about_page_nonce'] ) );

    if ( ! wp_verify_nonce( $nonce, 'obirsc_about_page_meta' ) ) return;

    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    if ( get_post_type( $post_id ) !== 'obirsc_about_page' ) return;


    if ( isset( $_POST['obirsc_about_kicker'] ) ) {
        update_post_meta( $post_id, 'obirsc_about_kicker',
            sanitize_text_field( wp_unslash( $_POST['obirsc_about_kicker'] ) )
        );
    }

    if ( isset( $_POST['obirsc_about_title'] ) ) {
        update_post_meta( $post_id, 'obirsc_about_title',
            sanitize_text_field( wp_unslash( $_POST['obirsc_about_title'] ) )
        );
    }

    if ( isset( $_POST['obirsc_about_chef_story'] ) ) {
        update_post_meta( $post_id, 'obirsc_about_chef_story',
            sanitize_textarea_field( wp_unslash( $_POST['obirsc_about_chef_story'] ) )
        );
    }

    if ( isset( $_POST['obirsc_about_philosophy'] ) ) {
        update_post_meta( $post_id, 'obirsc_about_philosophy',
            sanitize_textarea_field( wp_unslash( $_POST['obirsc_about_philosophy'] ) )
        );
    }

    if ( isset( $_POST['obirsc_about_slides'] ) && is_array( $_POST['obirsc_about_slides'] ) ) {

        $slides = array();

        foreach ( $_POST['obirsc_about_slides'] as $slide ) {

            $title    = isset( $slide['title'] ) ? sanitize_text_field( wp_unslash( $slide['title'] ) ) : '';
            $subtitle = isset( $slide['subtitle'] ) ? sanitize_text_field( wp_unslash( $slide['subtitle'] ) ) : '';
            $image    = isset( $slide['image'] ) ? esc_url_raw( wp_unslash( $slide['image'] ) ) : '';

            if ( empty( $title ) && empty( $subtitle ) && empty( $image ) ) {
                continue;
            }

            $slides[] = array(
                'title'    => $title,
                'subtitle' => $subtitle,
                'image'    => $image,
            );
        }

        update_post_meta( $post_id, 'obirsc_about_slides', $slides );

    } else {
        update_post_meta( $post_id, 'obirsc_about_slides', array() );
    }
}
add_action( 'save_post_obirsc_about_page', 'obirsc_save_about_page_meta' );

/* ======================================================
   12. Contact Page
====================================================== */

function obirsc_register_contact_page_cpt() {
    register_post_type( 'obirsc_contact_page', array(
        'labels' => array(
            'name'          => __( 'Contact Page', 'obydullah-restaurant-shop-core' ),
            'singular_name' => __( 'Contact Page', 'obydullah-restaurant-shop-core' ),
            'add_new_item'  => __( 'Edit Contact Page', 'obydullah-restaurant-shop-core' ),
            'edit_item'     => __( 'Edit Contact Page', 'obydullah-restaurant-shop-core' ),
        ),
        'public'           => false,
        'show_ui'          => true,
        'show_in_menu'     => 'obirsc-restaurant-core',
        'menu_icon'        => 'dashicons-email',
        'menu_position'    => 66,
        'supports'         => array( 'title' ),
        'show_in_rest'     => true,
        'capability_type'  => 'post',
        'map_meta_cap'     => true,
    ) );
}
add_action( 'init', 'obirsc_register_contact_page_cpt' );

function obirsc_limit_contact_page() {
    global $pagenow;
    if ( $pagenow === 'post-new.php' && isset( $_GET['post_type'] ) && $_GET['post_type'] === 'obirsc_contact_page' ) {
        $existing = get_posts( array(
            'post_type'      => 'obirsc_contact_page',
            'posts_per_page' => 1,
            'post_status'    => 'publish',
            'fields'         => 'ids',
        ) );
        if ( ! empty( $existing ) ) {
            $post_id = $existing[0];
            if ( current_user_can( 'edit_post', $post_id ) ) {
                wp_redirect( admin_url( 'post.php?post=' . $post_id . '&action=edit' ) );
                exit;
            }
        }
    }
}
add_action( 'admin_init', 'obirsc_limit_contact_page' );

function obirsc_add_contact_page_meta_boxes() {
    add_meta_box(
        'obirsc_contact_page_settings',
        __( 'Contact Page Content', 'obydullah-restaurant-shop-core' ),
        'obirsc_contact_page_meta_callback',
        'obirsc_contact_page',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'obirsc_add_contact_page_meta_boxes' );

function obirsc_contact_page_meta_callback( $post ) {
    wp_nonce_field( 'obirsc_contact_page_meta', 'obirsc_contact_page_nonce' );

    $address   = get_post_meta( $post->ID, 'obirsc_contact_address', true );
    $phone     = get_post_meta( $post->ID, 'obirsc_contact_phone', true );
    $email     = get_post_meta( $post->ID, 'obirsc_contact_email', true );
    $map_embed = get_post_meta( $post->ID, 'obirsc_contact_map_embed', true );
    $form_shortcode = get_post_meta( $post->ID, 'obirsc_contact_form_shortcode', true );
    ?>
<p>
    <label for="obirsc_contact_address"><?php esc_html_e( 'Address', 'obydullah-restaurant-shop-core' ); ?></label><br>
    <textarea name="obirsc_contact_address" id="obirsc_contact_address" rows="3"
        class="large-text"><?php echo esc_textarea( $address ); ?></textarea>
    <span
        class="description"><?php esc_html_e( 'Full restaurant address.', 'obydullah-restaurant-shop-core' ); ?></span>
</p>
<p>
    <label
        for="obirsc_contact_phone"><?php esc_html_e( 'Phone Number', 'obydullah-restaurant-shop-core' ); ?></label><br>
    <input type="tel" name="obirsc_contact_phone" id="obirsc_contact_phone" value="<?php echo esc_attr( $phone ); ?>"
        class="widefat">
</p>
<p>
    <label
        for="obirsc_contact_email"><?php esc_html_e( 'Email Address', 'obydullah-restaurant-shop-core' ); ?></label><br>
    <input type="email" name="obirsc_contact_email" id="obirsc_contact_email" value="<?php echo esc_attr( $email ); ?>"
        class="widefat">
</p>
<p>
    <label
        for="obirsc_contact_map_embed"><?php esc_html_e( 'Google Maps Embed URL', 'obydullah-restaurant-shop-core' ); ?></label><br>
    <input type="url" name="obirsc_contact_map_embed" id="obirsc_contact_map_embed"
        value="<?php echo esc_url( $map_embed ); ?>" class="widefat"
        placeholder="https://www.google.com/maps/embed?...">
    <span
        class="description"><?php esc_html_e( 'Paste the embed URL from Google Maps.', 'obydullah-restaurant-shop-core' ); ?></span>
</p>
<p>
    <label
        for="obirsc_contact_form_shortcode"><?php esc_html_e( 'Contact Form Shortcode', 'obydullah-restaurant-shop-core' ); ?></label><br>
    <input type="text" name="obirsc_contact_form_shortcode" id="obirsc_contact_form_shortcode"
        value="<?php echo esc_attr( $form_shortcode ); ?>" class="widefat" placeholder="[contact-form-7 id=...]">
    <span
        class="description"><?php esc_html_e( 'If using a plugin like Contact Form 7, paste the shortcode here.', 'obydullah-restaurant-shop-core' ); ?></span>
</p>
<?php
}

function obirsc_save_contact_page_meta( $post_id ) {
    if ( ! isset( $_POST['obirsc_contact_page_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['obirsc_contact_page_nonce'] ) ), 'obirsc_contact_page_meta' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( get_post_type( $post_id ) !== 'obirsc_contact_page' ) {
        return;
    }

    if ( isset( $_POST['obirsc_contact_address'] ) ) {
        update_post_meta( $post_id, 'obirsc_contact_address', sanitize_textarea_field( wp_unslash( $_POST['obirsc_contact_address'] ) ) );
    }

    if ( isset( $_POST['obirsc_contact_phone'] ) ) {
        update_post_meta( $post_id, 'obirsc_contact_phone', sanitize_text_field( wp_unslash( $_POST['obirsc_contact_phone'] ) ) );
    }

    if ( isset( $_POST['obirsc_contact_email'] ) ) {
        update_post_meta( $post_id, 'obirsc_contact_email', sanitize_email( wp_unslash( $_POST['obirsc_contact_email'] ) ) );
    }

    if ( isset( $_POST['obirsc_contact_map_embed'] ) ) {
        update_post_meta( $post_id, 'obirsc_contact_map_embed', esc_url_raw( wp_unslash( $_POST['obirsc_contact_map_embed'] ) ) );
    }

    if ( isset( $_POST['obirsc_contact_form_shortcode'] ) ) {
        update_post_meta( $post_id, 'obirsc_contact_form_shortcode', sanitize_text_field( wp_unslash( $_POST['obirsc_contact_form_shortcode'] ) ) );
    }
}
add_action( 'save_post_obirsc_contact_page', 'obirsc_save_contact_page_meta' );

/* ======================================================
   13. Contact Form 7 Support
====================================================== */

function obirsc_get_first_cf7_shortcode() {
    if ( ! defined( 'WPCF7_VERSION' ) ) {
        return '';
    }

    $forms = get_posts( array(
        'post_type'      => 'wpcf7_contact_form',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
    ) );

    if ( empty( $forms ) ) {
        return '';
    }

    $form = $forms[0];
    return '[contact-form-7 id="' . (int) $form->ID . '" title="' . esc_attr( $form->post_title ) . '"]';
}


/* ===========================================================
   14. WOOCOMMERCE INTEGRATION - Get Product Data for Display
============================================================== */

function obirsc_get_woo_product_data( $post_id ) {
    $woo_product_id = get_post_meta( $post_id, '_obirsc_woo_product_id', true );

    if ( ! $woo_product_id || ! class_exists( 'WooCommerce' ) ) {
        return null;
    }

    $product = wc_get_product( $woo_product_id );
    if ( ! $product ) {
        return null;
    }

    return array(
        'id'          => $woo_product_id,
        'name'        => $product->get_name(),
        'price'       => $product->get_price(),
        'price_html'  => $product->get_price_html(),
        'add_to_cart' => $product->add_to_cart_url(),
        'product_url' => get_permalink( $woo_product_id ),
        'is_in_stock' => $product->is_in_stock(),
        'button_text' => $product->is_type( 'simple' ) && $product->is_in_stock() ? __( 'Add to Cart', 'obydullah-restaurant-shop-core' ) : __( 'View Product', 'obydullah-restaurant-shop-core' ),
    );
}

function obirsc_display_add_to_cart_button( $post_id, $class = 'btn btn--primary' ) {
    $data = obirsc_get_woo_product_data( $post_id );

    if ( ! $data ) {
        return;
    }

    if ( $data['is_in_stock'] && $data['add_to_cart'] ) {
        ?>
<a href="<?php echo esc_url( $data['add_to_cart'] ); ?>" class="<?php echo esc_attr( $class ); ?> add-to-cart-button">
    <?php esc_html_e( 'Add to Cart', 'obydullah-restaurant-shop-core' ); ?>
    <span class="price"><?php echo wp_kses_post( $data['price_html'] ); ?></span>
</a>
<?php
    } else {
        ?>
<a href="<?php echo esc_url( $data['product_url'] ); ?>" class="<?php echo esc_attr( $class ); ?>">
    <?php esc_html_e( 'View Product', 'obydullah-restaurant-shop-core' ); ?>
</a>
<?php
    }
}