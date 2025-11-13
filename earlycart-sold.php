<?php
/**
 * Plugin Name:       EarlyCart Sold
 * Plugin URI:        https://github.com/DragoKatic/earlycart-sold
 * Description:       EarlyCart Sold is a WooCommerce plugin to display bestseller labels and adjusted units sold counts.
 * Version:           1.0.0
 * Requires at least: 6.8
 * Tested up to:      6.8
 * Requires PHP:      7.4
 * Author:            Drago Katić
 * Author URI:        https://dragokatic.github.io/
 * License:           GPLv2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       earlycart-sold
 * Domain Path:       /languages
 *
 * @package EarlyCart_Sold
 */

defined( 'ABSPATH' ) || exit;

// Prevent multiple loading.
if ( defined( 'EARLYCART_SOLD_LOADED' ) ) {
    return;
}
define( 'EARLYCART_SOLD_LOADED', true );

// Plugin constants.
define( 'EARLYCART_SOLD_PATH', plugin_dir_path( __FILE__ ) );
define( 'EARLYCART_SOLD_URL', plugin_dir_url( __FILE__ ) );
define( 'EARLYCART_SOLD_VERSION', '1.0.0' );
define( 'EARLYCART_SOLD_MINIMUM_WP_VERSION', '6.8' );

// Includes.
require_once EARLYCART_SOLD_PATH . 'includes/install.php';
require_once EARLYCART_SOLD_PATH . 'includes/db-handler.php';
require_once EARLYCART_SOLD_PATH . 'includes/assets-loader.php';
require_once EARLYCART_SOLD_PATH . 'includes/uninstall.php';

// Hooks.
register_activation_hook( __FILE__, 'earlycart_sold_create_table' );
register_uninstall_hook( __FILE__, 'earlycart_sold_delete_table' );

// Admin-only includes.
if ( is_admin() ) {
    require_once EARLYCART_SOLD_PATH . 'admin/admin-page.php';
}

/**
 * Generate fake sold quantity based on product ID and multiplier from settings.
 *
 * @param int $product_id WooCommerce product ID.
 * @return int Generated quantity based on product ID sum and multiplier.
 */
function earlycart_sold_calculate_quantity( $product_id ) {
    global $wpdb;

    $table_name = $wpdb->prefix . 'earlycart_sold';

    // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared, WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    $settings = $wpdb->get_row(
        // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
        "SELECT category_slug, multiplier FROM {$table_name} WHERE id = 1"
    );

    if ( ! $settings ) {
        return 0;
    }

    $slug       = sanitize_title( $settings->category_slug );
    $multiplier = (int) $settings->multiplier;

    $id_digits = str_split( (string) $product_id );
    $sum       = array_sum( array_map( 'intval', $id_digits ) );

    if ( has_term( $slug, 'product_cat', $product_id ) ) {
        return $sum * $multiplier;
    }

    return $sum;
}

/**
 * Check if a product is in the target category from settings.
 *
 * @param int $product_id WooCommerce product ID.
 * @return bool True if product belongs to the category, false otherwise.
 */
function earlycart_sold_is_in_target_category( $product_id ) {
    global $wpdb;

    $table_name = $wpdb->prefix . 'earlycart_sold';

    // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared, WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    $settings = $wpdb->get_row(
        // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
        "SELECT category_slug FROM {$table_name} WHERE id = 1"
    );

    if ( ! $settings ) {
        return false;
    }

    $slug = sanitize_title( $settings->category_slug );

    return has_term( $slug, 'product_cat', $product_id );
}

/**
 * Render custom product information on the single product page.
 *
 * @return void
 */
function earlycart_sold_render_single_product_info() {
    global $product;

    if ( ! is_a( $product, 'WC_Product' ) ) {
        return;
    }

    $product_id = $product->get_id();

    echo '<div class="ecs-single-container" id="ecs-single-container">';

    if ( earlycart_sold_is_in_target_category( $product_id ) ) {
        $bestseller_path = EARLYCART_SOLD_PATH . 'templates/bestseller.php';
        if ( file_exists( $bestseller_path ) ) {
            include $bestseller_path;
        }

        $quantity_path = EARLYCART_SOLD_PATH . 'templates/quantity.php';
        if ( file_exists( $quantity_path ) ) {
            include $quantity_path;
        }
    } else {
        $new_arrival_path = EARLYCART_SOLD_PATH . 'templates/new-arrival.php';
        if ( file_exists( $new_arrival_path ) ) {
            include $new_arrival_path;
        }
    }

    echo '</div>';
}
add_action( 'woocommerce_single_product_summary', 'earlycart_sold_render_single_product_info', 4 );

/**
 * Render custom product information in the shop loop.
 *
 * @return void
 */
function earlycart_sold_render_shop_loop_info() {
    global $product;

    if ( ! is_a( $product, 'WC_Product' ) ) {
        return;
    }

    $product_id = $product->get_id();

    echo '<div class="ecs-shop-container" id="ecs-shop-container">';

    if ( earlycart_sold_is_in_target_category( $product_id ) ) {
        $bestseller_path = EARLYCART_SOLD_PATH . 'templates/bestseller.php';
        if ( file_exists( $bestseller_path ) ) {
            include $bestseller_path;
        }

        $quantity_path = EARLYCART_SOLD_PATH . 'templates/quantity.php';
        if ( file_exists( $quantity_path ) ) {
            include $quantity_path;
        }
    } else {
        $new_arrival_path = EARLYCART_SOLD_PATH . 'templates/new-arrival.php';
        if ( file_exists( $new_arrival_path ) ) {
            include $new_arrival_path;
        }
    }

    echo '</div>';
}
add_action( 'woocommerce_after_shop_loop_item_title', 'earlycart_sold_render_shop_loop_info', 8 );