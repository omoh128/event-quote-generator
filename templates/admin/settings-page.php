<?php
/**
 * Admin settings page template
 *
 * @package EventQuoteGenerator
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}
?>

<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    
    <form method="post" action="options.php">
        <?php
        settings_fields( 'eqg_options' );
        do_settings_sections( 'eqg_options' );
        ?>
        
        <div class="eqg-settings-section">
            <h2><?php esc_html_e( 'Base Pricing', 'event-quote-generator' ); ?></h2>
            
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="eqg_wedding_base">
                            <?php esc_html_e( 'Wedding Base Price', 'event-quote-generator' ); ?>
                        </label>
                    </th>
                    <td>
                        <input type="number" 
                               id="eqg_wedding_base" 
                               name="eqg_options[wedding_base]" 
                               value="<?php echo esc_attr( get_option( 'eqg_wedding_base', '1000' ) ); ?>"
                               min="0"
                               step="100"
                        >
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label for="eqg_corporate_base">
                            <?php esc_html_e( 'Corporate Event Base Price', 'event-quote-generator' ); ?>
                        </label>
                    </th>
                    <td>
                        <input type="number" 
                               id="eqg_corporate_base" 
                               name="eqg_options[corporate_base]" 
                               value="<?php echo esc_attr( get_option( 'eqg_corporate_base', '800' ) ); ?>"
                               min="0"
                               step="100"
                        >
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label for="eqg_birthday_base">
                            <?php esc_html_e( 'Birthday Party Base Price', 'event-quote-generator' ); ?>
                        </label>
                    </th>
                    <td>
                        <input type="number" 
                               id="eqg_birthday_base" 
                               name="eqg_options[birthday_base]" 
                               value="<?php echo esc_attr( get_option( 'eqg_birthday_base', '500' ) ); ?>"
                               min="0"
                               step="100"
                        >
                    </td>
                </tr>
            </table>
        </div>
        
        <div class="eqg-settings-section">
            <h2><?php esc_html_e( 'Per Guest Pricing', 'event-quote-generator' ); ?></h2>
            
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="eqg_per_guest">
                            <?php esc_html_e( 'Price Per Guest', 'event-quote-generator' ); ?>
                        </label>
                    </th>
                    <td>
                        <input type="number" 
                               id="eqg_per_guest" 
                               name="eqg_options[per_guest]" 
                               value="<?php echo esc_attr( get_option( 'eqg_per_guest', '50' ) ); ?>"
                               min="0"
                               step="5"
                        >
                    </td>
                </tr>
            </table>
        </div>
        
        <div class="eqg-settings-section">
            <h2><?php esc_html_e( 'Seasonal Adjustments', 'event-quote-generator' ); ?></h2>
            
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="eqg_peak_season_multiplier">
                            <?php esc_html_e( 'Peak Season Multiplier', 'event-quote-generator' ); ?>
                        </label>
                    </th>
                    <td>
                        <input type="number" 
                               id="eqg_peak_season_multiplier" 
                               name="eqg_options[peak_multiplier]" 
                               value="<?php echo esc_attr( get_option( 'eqg_peak_multiplier', '1.2' ) ); ?>"
                               min="1"
                               max="2"
                               step="0.1"
                        >
                        <p class="description">
                            <?php esc_html_e( 'Multiplier for peak season (June-August). 1.2 = 20% increase', 'event-quote-generator' ); ?>
                        </p>
                    </td>
                </tr>
            </table>
        </div>
        
        <?php submit_button(); ?>
    </form>
</div>