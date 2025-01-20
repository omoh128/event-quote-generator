<?php
/**
 * Frontend quote form template
 *
 * @package EventQuoteGenerator
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}
?>
<div id="eqg-quote-result" class="eqg-result" style="display: block;">
    <form id="eqg-quote-form" class="eqg-form" method="post" novalidate>
        <?php wp_nonce_field( 'eqg_quote_nonce', 'eqg_nonce' ); ?>
        
        <div class="eqg-form-group">
            <label for="event_type">
                <?php esc_html_e( 'Event Type', 'event-quote-generator' ); ?>
                <span class="required" aria-label="<?php esc_attr_e( 'Required', 'event-quote-generator' ); ?>">*</span>
            </label>
            <select name="event_type" id="event_type" required aria-required="true">
                <option value=""><?php esc_html_e( 'Select Event Type', 'event-quote-generator' ); ?></option>
                <option value="wedding"><?php esc_html_e( 'Wedding', 'event-quote-generator' ); ?></option>
                <option value="corporate"><?php esc_html_e( 'Corporate Event', 'event-quote-generator' ); ?></option>
                <option value="birthday"><?php esc_html_e( 'Birthday Party', 'event-quote-generator' ); ?></option>
            </select>
        </div>

        <div class="eqg-form-group">
            <label for="guests">
                <?php esc_html_e( 'Number of Guests', 'event-quote-generator' ); ?>
                <span class="required" aria-label="<?php esc_attr_e( 'Required', 'event-quote-generator' ); ?>">*</span>
            </label>
            <input type="number" 
                   name="guests" 
                   id="guests" 
                   min="1" 
                   max="1000" 
                   required
                   aria-required="true"
                   placeholder="<?php esc_attr_e( 'Enter number of guests', 'event-quote-generator' ); ?>"
            >
        </div>

        <div class="eqg-form-group">
            <label for="event_date">
                <?php esc_html_e( 'Event Date', 'event-quote-generator' ); ?>
                <span class="required" aria-label="<?php esc_attr_e( 'Required', 'event-quote-generator' ); ?>">*</span>
            </label>
            <input type="date" 
                   name="event_date" 
                   id="event_date" 
                   required
                   aria-required="true"
                   min="<?php echo esc_attr( date( 'Y-m-d', strtotime( '+1 day' ) ) ); ?>"
            >
        </div>

        <div class="eqg-form-group">
            <label for="event_duration">
                <?php esc_html_e( 'Event Duration (hours)', 'event-quote-generator' ); ?>
            </label>
            <input type="number" 
                   name="event_duration" 
                   id="event_duration" 
                   min="1" 
                   max="24" 
                   value="4"
                   step="0.5"
                   aria-describedby="duration-help"
            >
            <small id="duration-help" class="form-text">
                <?php esc_html_e( 'Enter the duration of the event in hours.', 'event-quote-generator' ); ?>
            </small>
        </div>

        <div class="eqg-form-actions">
            <button type="submit" class="eqg-submit button button-primary">
                <?php esc_html_e( 'Generate Quote', 'event-quote-generator' ); ?>
            </button>
            <div class="eqg-loading" style="display: none;" aria-hidden="true" role="alert">
                <?php esc_html_e( 'Calculating quote...', 'event-quote-generator' ); ?>
            </div>
        </div>
    </form>

    <div id="eqg-quote-error" class="eqg-error" style="display: none;" role="alert">
        <p><?php esc_html_e( 'An error occurred while generating the quote. Please try again.', 'event-quote-generator' ); ?></p>
    </div>
</div>
