<?php
/**
 * Admin page functionality for the EarlyCart Sold plugin.
 *
 * Adds a custom admin menu and handles settings form submission.
 *
 * @package EarlyCart_Sold
 */

defined( 'ABSPATH' ) || exit;

/**
 * Add admin menu item for EarlyCart Sold plugin.
 *
 * @return void
 */
function earlycart_sold_add_admin_menu() {
    add_menu_page(
        __( 'EarlyCart Sold', 'earlycart-sold' ),
        __( 'EarlyCart Sold', 'earlycart-sold' ),
        'manage_options',
        'earlycart-sold',
        'earlycart_sold_render_admin_page',
        // Inline SVG as base64 icon.
        'data:image/svg+xml;base64,PHN2ZyB2aWV3Qm94PSIwIDAgMTAwMCAxMDAwIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxyZWN0IGZpbGw9IndoaXRlIiB4PSI1MzguNSIgeT0iNDk5LjUiIHdpZHRoPSIyNDkiIGhlaWdodD0iMjQ5Ii8+PHJlY3QgZmlsbD0id2hpdGUiIHg9IjE4Ny41IiB5PSI0NTIuNSIgd2lkdGg9IjI0OSIgaGVpZ2h0PSIyNDkiIHRyYW5zZm9ybT0idHJhbnNsYXRlKC0zNDMuNyA1NTguNykgcm90YXRlKC02MCkiLz48cmVjdCBmaWxsPSJ3aGl0ZSIgeD0iNDAyLjUiIHk9IjE3MS41IiB3aWR0aD0iMjQ5IiBoZWlnaHQ9IjI0OSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTc3LjQgMzAzLjE2KSByb3RhdGUoLTMwKSIvPjwvc3ZnPg==',
        null
    );
}
add_action( 'admin_menu', 'earlycart_sold_add_admin_menu' );

/**
 * Render the admin page and handle form submission.
 *
 * @return void
 */
function earlycart_sold_render_admin_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    require_once EARLYCART_SOLD_PATH . 'includes/db-handler.php';

    // Process form submission.
    if (
        isset( $_POST['earlycart_sold_nonce'] )
        && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['earlycart_sold_nonce'] ) ), 'earlycart_sold_save_settings' )
    ) {
        $category_slug         = isset( $_POST['category_slug'] ) ? sanitize_text_field( wp_unslash( $_POST['category_slug'] ) ) : '';
        $multiplier            = isset( $_POST['multiplier'] ) ? absint( $_POST['multiplier'] ) : 1;

        $bestseller_label_css  = isset( $_POST['bestseller_label_css'] ) ? sanitize_textarea_field( wp_unslash( $_POST['bestseller_label_css'] ) ) : '';
        $bestseller_label_html = isset( $_POST['bestseller_label_html'] ) ? wp_kses_post( wp_unslash( $_POST['bestseller_label_html'] ) ) : '';

        $units_sold_css        = isset( $_POST['units_sold_css'] ) ? sanitize_textarea_field( wp_unslash( $_POST['units_sold_css'] ) ) : '';
        $units_sold_html       = isset( $_POST['units_sold_html'] ) ? wp_kses_post( wp_unslash( $_POST['units_sold_html'] ) ) : '';

        earlycart_update_settings(
            array(
                'category_slug'         => $category_slug,
                'multiplier'            => $multiplier,
                'bestseller_label_css'  => $bestseller_label_css,
                'bestseller_label_html' => $bestseller_label_html,
                'units_sold_css'        => $units_sold_css,
                'units_sold_html'       => $units_sold_html,
            )
        );

        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Safe: esc_html__ used.
        echo '<div class="updated notice is-dismissible"><p>' . esc_html__( 'Settings saved.', 'earlycart-sold' ) . '</p></div>';
    }

    // Load admin settings form template.
    require_once EARLYCART_SOLD_PATH . 'templates/admin-form.php';
    earlycart_render_admin_form();
}