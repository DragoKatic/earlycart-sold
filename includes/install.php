<?php
/**
 * Handles installation procedures for the EarlyCart Sold plugin.
 *
 * Creates the database table and inserts default style and content settings.
 *
 * @package EarlyCart_Sold
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Creates the custom database table and inserts the initial row if it doesn't exist.
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 * @return void
 */
function earlycart_sold_create_table() {
    global $wpdb;

    $table_name      = $wpdb->prefix . 'earlycart_sold';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE {$table_name} (
        id INT(11) NOT NULL AUTO_INCREMENT,
        category_slug VARCHAR(191) NOT NULL,
        multiplier INT NOT NULL DEFAULT 1,
        bestseller_label_css TEXT DEFAULT NULL,
        bestseller_label_html TEXT DEFAULT NULL,
        units_sold_css TEXT DEFAULT NULL,
        units_sold_html TEXT DEFAULT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta( $sql );

    // Cache key for checking existence.
    $cache_key = 'earlycart_sold_default_row';

    // Try to get from cache first.
    $existing = wp_cache_get( $cache_key );

    if ( false === $existing ) {
        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.PreparedSQL.InterpolatedNotPrepared -- Safe: only checks static ID.
        $existing = $wpdb->get_var( "SELECT id FROM {$table_name} WHERE id = 1" );
        wp_cache_set( $cache_key, $existing );
    }

    if ( ! $existing ) {
        // Default CSS for "Bestseller" badge.
        $bestseller_label_css = '.ecs-badge {
            background-color:#ff911c;
            color:#0d1321;
            font-weight:bold;
            font-size:14px;
            padding:4px 8px;
            display:inline-block;
            border-radius:4px;
            margin-bottom:8px;
        }';

        // Placeholder HTML for "Bestseller" label.
        $bestseller_label_html = '<div class="ecs-badge">%s</div>';

        // Default CSS for "Units Sold" label.
        $units_sold_css = '.ecs-units {
            font-size:14px;
            color:#0d1321;
            margin-left:auto;
        }';

        // Placeholder HTML for "Units Sold" label.
        $units_sold_html = '<div class="ecs-units">%s</div>';

        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
        $wpdb->insert(
            $table_name,
            array(
                'id'                    => 1,
                'category_slug'         => 'uncategorized',
                'multiplier'            => 2,
                'bestseller_label_css'  => $bestseller_label_css,
                'bestseller_label_html' => $bestseller_label_html,
                'units_sold_css'        => $units_sold_css,
                'units_sold_html'       => $units_sold_html,
            ),
            array(
                '%d',
                '%s',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
            )
        );
    }
}