<?php
/**
 * Template part for displaying "New arrival" label and fake units sold.
 *
 * @package EarlyCart_Sold
 */

if ( ! isset( $product ) || ! is_a( $product, 'WC_Product' ) ) {
    return;
}

$quantity = earlycart_sold_calculate_quantity( $product->get_id() );

if ( $quantity > 0 ) :
    echo '<div class="ecs-simple-info">';
    echo '<div class="ecs-label">' . esc_html__( 'New arrival', 'earlycart-sold' ) . '</div>';

    // translators: %d is the number of units sold (fake number for display).
    echo '<div class="ecs-units">' . sprintf( esc_html__( 'Units Sold: %d', 'earlycart-sold' ), esc_html( $quantity ) ) . '</div>';

    echo '</div>';
endif;
