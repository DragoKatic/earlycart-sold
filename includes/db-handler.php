<?php
/**
 * Database handler functions for EarlyCart Sold plugin.
 *
 * Provides functions to retrieve and update plugin settings
 * stored in the custom database table.
 *
 * @package EarlyCart_Sold
 */

defined( 'ABSPATH' ) || exit;

/**
 * Fetch the current plugin settings from the database.
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 * @return object|null The settings row object or null if not found.
 */
function earlycart_get_settings() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'earlycart_sold';

    // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared, WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- Safe: static ID lookup only.
    return $wpdb->get_row( "SELECT * FROM {$table_name} WHERE id = 1" );
}

/**
 * Update the plugin settings in the database.
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 *
 * @param array $data Associative array of updated values.
 * @return bool|int False on failure, number of rows updated on success.
 */
function earlycart_update_settings( $data ) {
    global $wpdb;

    $table_name = $wpdb->prefix . 'earlycart_sold';

    // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- Safe: controlled update on static ID.
    return $wpdb->update(
        $table_name,
        $data,
        array( 'id' => 1 ),
        array( '%s', '%d', '%s', '%s', '%s', '%s' ),
        array( '%d' )
    );
}