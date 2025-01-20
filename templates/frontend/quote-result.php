<?php
/**
 * Frontend quote result template
 *
 * @package EventQuoteGenerator
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}
?>

<div id="eqg-quote-result" class="eqg-result" style="display: none;">
    <div class="eqg-result-header">
        <h3><?php esc_html_e( 'Your Custom Quote', 'event-quote-generator' ); ?></h3>
        <p class="eqg-event-summary"></p>
    </div>

    <div class="eqg-result-body">
        <div class="eqg-quote-breakdown"></div>
        
        <div class="eqg-quote-total">
            <div class="eqg-total-label">
                <?php esc_html_e( 'Total Estimated Cost', 'event-quote-generator' ); ?>
            </div>
            <div class="eqg-total-amount"></div>
        </div>

        <div class="eqg-quote-notes">
            <p class="eqg-note">
                <?php esc_html_e( 'This quote is valid for 30 days and includes:', 'event-quote-generator' ); ?>
            </p>
            <ul>
                <li><?php esc_html_e( 'Full event planning and coordination', 'event-quote-generator' ); ?></li>
                <li><?php esc_html_e( 'Setup and cleanup', 'event-quote-generator' ); ?></li>
                <li><?php esc_html_e( 'Basic decorations and equipment', 'event-quote-generator' ); ?></li>
                <li><?php esc_html_e( 'Staff for the duration of the event', 'event-quote-generator' ); ?></li>
            </ul>
        </div>
    </div>

    <div class="eqg-result-actions">
        <button type="button" class="eqg-save-quote button button-secondary">
            <?php esc_html_e( 'Save Quote', 'event-quote-generator' ); ?>
        </button>
        
        <button type="button" class="eqg-contact-us button button-primary">
            <?php esc_html_e( 'Contact Us', 'event-quote-generator' ); ?>
        </button>
        
        <button type="button" class="eqg-modify-quote button button-link">
            <?php esc_html_e( 'Modify Quote', 'event-quote-generator' ); ?>
        </button>
    </div>

    <div class="eqg-disclaimer">
        <p>
            <?php esc_html_e( 'This is an estimated quote. Final pricing may vary based on specific requirements and availability.', 'event-quote-generator' ); ?>
        </p>
    </div>
</div>