<?php
/**
 * Enqueues the frontend CSS and JS assets for EarlyCart Sold.
 *
 * This function ensures that styles and scripts needed for the
 * plugin's visual and interactive features are properly loaded.
 *
 * @package EarlyCart_Sold
 */

// Exit if accessed directly to preserve system integrity.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Load plugin textdomain for translations.
 *
 * @return void
 */
function earlycart_sold_load_textdomain() {
	// phpcs:ignore PluginCheck.CodeAnalysis.DiscouragedFunctions.load_plugin_textdomainFound
    load_plugin_textdomain(
        'earlycart-sold',
        false,
        dirname( plugin_basename( __FILE__ ) ) . '/../languages'
    );
}
add_action( 'plugins_loaded', 'earlycart_sold_load_textdomain' );

/**
 * Enqueue plugin styles and scripts for the frontend.
 *
 * This function attaches plugin-specific assets like custom CSS and JS,
 * ensuring they are only loaded when needed and versioned for cache control.
 *
 * @return void
 */
function earlycart_sold_engine_enqueue_assets() {
    wp_enqueue_style(
        'earlycart-sold-style',
        EARLYCART_SOLD_URL . 'assets/css/style.css',
        array(),
        EARLYCART_SOLD_VERSION
    );

    wp_enqueue_script(
        'earlycart-sold-script',
        EARLYCART_SOLD_URL . 'assets/js/script.js',
        array( 'jquery' ),
        EARLYCART_SOLD_VERSION,
        true
    );
}
add_action( 'wp_enqueue_scripts', 'earlycart_sold_engine_enqueue_assets' );
