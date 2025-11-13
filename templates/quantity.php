<?php
/**
 * Template part for displaying fake units sold.
 *
 * @package EarlyCart_Sold
 */

if ( ! isset( $product ) || ! is_a( $product, 'WC_Product' ) ) {
    return;
}

// Calculate quantity using plugin's function.
$quantity = earlycart_sold_calculate_quantity( $product->get_id() );

if ( $quantity > 0 ) :
    global $wpdb;
    $table_name = $wpdb->prefix . 'earlycart_sold';

    // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared, WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- Safe: static ID lookup only.
    $row = $wpdb->get_row( "SELECT units_sold_html, units_sold_css FROM {$table_name} WHERE id = 1" );

    if ( $row ) {
        // Output CSS safely.
        if ( ! empty( $row->units_sold_css ) ) {
            echo '<style>' . esc_textarea( $row->units_sold_css ) . '</style>';
        }

        // translators: %s is the number of units sold.
        $text = sprintf( __( 'Units Sold: %s', 'earlycart-sold' ), $quantity );

        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- HTML template is user-configurable, escaping applied to text.
        echo sprintf( $row->units_sold_html, esc_html( $text ) );
    }
endif;