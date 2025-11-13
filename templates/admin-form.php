<?php
/**
 * Admin settings form for EarlyCart Sold plugin.
 *
 * Displays the settings page in the WordPress admin area where users
 * can edit category, multiplier, and CSS/HTML templates for labels.
 *
 * @package EarlyCart_Sold
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once plugin_dir_path( __FILE__ ) . '../includes/db-handler.php';

/**
 * Renders the HTML form for plugin settings.
 */
function earlycart_render_admin_form() {
    $settings = earlycart_get_settings();

    if ( isset( $_POST['earlycart_submit'] ) && check_admin_referer( 'earlycart_sold_save_settings', 'earlycart_sold_nonce' ) ) {
        $updated = earlycart_update_settings( array(
            'category_slug'         => sanitize_text_field( wp_unslash( $_POST['category_slug'] ?? '' ) ),
            'multiplier'            => (int) sanitize_text_field( wp_unslash( $_POST['multiplier'] ?? 0 ) ),
            'bestseller_label_css'  => wp_kses_post( wp_unslash( $_POST['bestseller_label_css'] ?? '' ) ),
            'bestseller_label_html' => wp_kses_post( wp_unslash( $_POST['bestseller_label_html'] ?? '' ) ),
            'units_sold_css'        => wp_kses_post( wp_unslash( $_POST['units_sold_css'] ?? '' ) ),
            'units_sold_html'       => wp_kses_post( wp_unslash( $_POST['units_sold_html'] ?? '' ) ),
        ) );

        if ( false !== $updated ) {
            echo '<div class="updated notice is-dismissible"><p>' . esc_html__( 'Settings updated successfully.', 'earlycart-sold' ) . '</p></div>';
            $settings = earlycart_get_settings(); // Refresh settings after update
        }
    }

    $primes = array( 2, 3, 5, 7, 11, 13, 17, 19, 23, 29, 31, 37, 41, 43, 47, 53, 59, 61, 67, 71 );
    ?>
    <form method="post">
        <?php wp_nonce_field( 'earlycart_sold_save_settings', 'earlycart_sold_nonce' ); ?>

        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="category_slug"><?php esc_html_e( 'Select Product Category', 'earlycart-sold' ); ?></label>
                </th>
                <td>
                    <select name="category_slug" id="category_slug" class="regular-text">
                        <option value=""><?php esc_html_e( '-- Select a Category --', 'earlycart-sold' ); ?></option>
                        <?php
                        // Get all product categories (taxonomy: product_cat)
                        $product_categories = get_terms( array(
                            'taxonomy'   => 'product_cat',
                            'hide_empty' => false,
                        ) );

                        if ( ! is_wp_error( $product_categories ) && ! empty( $product_categories ) ) {
                            foreach ( $product_categories as $category ) {
                                printf(
                                    '<option value="%s" %s>%s</option>',
                                    esc_attr( $category->slug ),
                                    selected( $settings->category_slug ?? '', $category->slug, false ),
                                    esc_html( $category->name )
                                );
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>

            <tr>
                <th scope="row"><?php esc_html_e( 'Multiplier', 'earlycart-sold' ); ?></th>
                <td>
                    <?php
                    foreach ( $primes as $prime ) {
                        ?>
                        <label style="margin-right: 15px;">
                            <input
                                type="radio"
                                name="multiplier"
                                value="<?php echo esc_attr( $prime ); ?>"
                                <?php checked( $settings->multiplier ?? '', $prime ); ?>
                            >
                            <?php echo esc_html( $prime ); ?>
                        </label>
                        <?php
                    }
                    ?>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="bestseller_label_css"><?php esc_html_e( 'Bestseller CSS', 'earlycart-sold' ); ?></label>
                </th>
                <td>
                    <textarea
                        name="bestseller_label_css"
                        id="bestseller_label_css"
                        class="large-text code"
                        rows="4"
                    ><?php echo esc_textarea( $settings->bestseller_label_css ?? '' ); ?></textarea>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="bestseller_label_html"><?php esc_html_e( 'Bestseller HTML', 'earlycart-sold' ); ?></label>
                </th>
                <td>
                    <textarea
                        name="bestseller_label_html"
                        id="bestseller_label_html"
                        class="large-text code"
                        rows="4"
                    ><?php echo esc_textarea( $settings->bestseller_label_html ?? '' ); ?></textarea>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="units_sold_css"><?php esc_html_e( 'Units Sold CSS', 'earlycart-sold' ); ?></label>
                </th>
                <td>
                    <textarea
                        name="units_sold_css"
                        id="units_sold_css"
                        class="large-text code"
                        rows="4"
                    ><?php echo esc_textarea( $settings->units_sold_css ?? '' ); ?></textarea>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="units_sold_html"><?php esc_html_e( 'Units Sold HTML', 'earlycart-sold' ); ?></label>
                </th>
                <td>
                    <textarea
                        name="units_sold_html"
                        id="units_sold_html"
                        class="large-text code"
                        rows="4"
                    ><?php echo esc_textarea( $settings->units_sold_html ?? '' ); ?></textarea>
                </td>
            </tr>
        </table>

        <?php submit_button( __( 'Save Changes', 'earlycart-sold' ), 'primary', 'earlycart_submit' ); ?>
    </form>
    <?php
}
