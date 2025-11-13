<?php
/**
 * Uninstallation functions for EarlyCart Sold plugin.
 *
 * Handles cleanup tasks when the plugin is uninstalled,
 * such as removing the custom database table.
 *
 * @package EarlyCart_Sold
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Delete the plugin's custom database table upon uninstall.
 *
 * This function drops the table used to store category data
 * and HTML/CSS styling for bestseller and units sold display.
 *
 * @return void
 */
function earlycart_sold_delete_table() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'earlycart_sold';

    // Drop the table if it exists.
    // Using prepare() is not needed for table names and not recommended here.
    $wpdb->query( "DROP TABLE IF EXISTS {$table_name}" ); // @codingStandardsIgnoreLine
}