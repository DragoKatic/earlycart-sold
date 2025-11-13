<?php
/**
 * Template part for displaying Bestseller badge.
 *
 * @package EarlyCart_Sold
 */

if ( ! isset( $product ) || ! is_a( $product, 'WC_Product' ) ) {
    return;
}

// Calculate quantity using helper function.
$quantity = earlycart_sold_calculate_quantity( $product->get_id() );

if ( $quantity > 0 ) :
    global $wpdb;
    $table_name = $wpdb->prefix . 'earlycart_sold';

    // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared, WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- Safe static lookup
    $row = $wpdb->get_row( "SELECT bestseller_label_html, bestseller_label_css FROM {$table_name} WHERE id = 1" );

    if ( $row ) {
        // Output CSS safely.
        if ( ! empty( $row->bestseller_label_css ) ) {
            echo '<style>' . esc_textarea( $row->bestseller_label_css ) . '</style>';
        }

        // translators: Bestseller badge text shown on product.
        $label_text = __( 'Bestseller', 'earlycart-sold' );

        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Template HTML is user-defined, escaping applied to text.
        echo sprintf( $row->bestseller_label_html, esc_html( $label_text ) );
    }
endif;