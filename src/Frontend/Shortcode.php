<?php

namespace EventQuoteGenerator\Frontend;

/**
 * Handles the quote generator shortcode functionality
 */
class Shortcode {
    /**
     * @var object Loader instance
     */
    private $loader;

    /**
     * Constructor
     *
     * @param object $loader Loader instance
     */
    public function __construct($loader) {
        $this->loader = $loader;
        $this->register_shortcodes();
    }

    /**
     * Register shortcodes
     */
    private function register_shortcodes() {
        add_shortcode('event_quote_generator', array($this, 'render_quote_generator'));
    }

    /**
     * Render the quote generator form
     *
     * @param array $atts Shortcode attributes
     * @return string HTML output
     */
    public function render_quote_generator($atts = array()) {
        // Ensure scripts and styles are enqueued
        wp_enqueue_style('event-quote-generator');
        wp_enqueue_script('event-quote-generator');

        // Start output buffering
        ob_start();

        // Check if running over HTTPS
        $is_secure = is_ssl();
        if (!$is_secure) {
            echo '<div class="notice notice-warning">';
            echo esc_html__('Warning: This form should be served over HTTPS for security.', 'event-quote-generator');
            echo '</div>';
        }

        // Get the form template
        if (file_exists(EQG_PLUGIN_DIR . 'templates/frontend/quote-form.php')) {
            include EQG_PLUGIN_DIR . 'templates/frontend/quote-form.php';
        } else {
            echo '<p>' . esc_html__('Error: Quote form template not found.', 'event-quote-generator') . '</p>';
        }

        // Get the buffered content
        $output = ob_get_clean();

        // Add nonce field for security
        $output = str_replace('</form>', wp_nonce_field('event_quote_generator', 'eqg_nonce', true, false) . '</form>', $output);

        return $output;
    }

    /**
     * Process the quote form submission
     */
    public function process_form() {
        // Verify nonce
        if (!isset($_POST['eqg_nonce']) || !wp_verify_nonce($_POST['eqg_nonce'], 'event_quote_generator')) {
            wp_die(__('Security check failed', 'event-quote-generator'));
        }

        // Sanitize and validate form data
        $event_type = isset($_POST['event_type']) ? sanitize_text_field($_POST['event_type']) : '';
        $guests = isset($_POST['guests']) ? absint($_POST['guests']) : 0;
        $date = isset($_POST['date']) ? sanitize_text_field($_POST['date']) : '';

        // Process the quote calculation
        // ... Add your quote calculation logic here

        // Return the result
        wp_send_json_success(array(
            'quote' => $quote_amount,
            'message' => __('Quote generated successfully!', 'event-quote-generator')
        ));
    }
}