<?php
/**
 * Frontend functionality handler
 *
 * @package EventQuoteGenerator
 */

namespace EventQuoteGenerator\Frontend;

/**
 * Class Frontend
 */
class Frontend {

    /**
     * Initialize the class
     */
    public function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
        add_action('wp_ajax_eqg_process_form', [$this, 'handle_ajax_quote']); // For logged-in users
        add_action('wp_ajax_nopriv_eqg_process_form', [$this, 'handle_ajax_quote']); // For non-logged-in users
        add_action('wp_ajax_generate_quote', [$this, 'handle_quote_generation']);
        add_action('wp_ajax_nopriv_generate_quote', [$this, 'handle_quote_generation']);
        add_action('rest_api_init', [$this, 'register_rest_routes']);
    }

    /**
     * Enqueue frontend assets
     */
    public function enqueue_assets() {
        wp_enqueue_style(
            'eqg-frontend',
            EQG_PLUGIN_URL . '/assets/css/event-quote-generator.css',
            [],
            EQG_VERSION
        );

        wp_enqueue_script(
            'eqg-frontend',
            EQG_PLUGIN_URL . '/assets/js/event-quote-generator.js',
            ['jquery'],
            EQG_VERSION,
            true
        );

        // Localize script to pass AJAX URL and nonce
        wp_localize_script('eqg-frontend', 'eqg_data', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('eqg_quote_nonce'),
            'contact_url' => get_permalink(get_option('eqg_contact_page_id')),
        ]);
    }

    /**
     * Handle AJAX quote generation
     */
    /**
 * Handle AJAX quote generation
 */
public function handle_quote_generation() {
    check_ajax_referer('eqg_quote_nonce', 'security');

    // Sanitize input
    $event_type = sanitize_text_field($_POST['event_type'] ?? '');
    $guests = absint($_POST['guests'] ?? 0);
    $date = sanitize_text_field($_POST['date'] ?? '');

    // Validate input
    if (empty($event_type) || empty($guests) || empty($date)) {
        wp_send_json_error(['message' => __('Please fill in all required fields.', 'event-quote-generator')]);
    }

    try {
        // Calculate quote
        $quote = $this->calculate_quote($event_type, $guests, $date);
        
        // Calculate breakdown items
        $breakdown = [
            [
                'name' => __('Base Price', 'event-quote-generator'),
                'cost' => 100.00
            ],
            [
                'name' => sprintf(__('Guest Fee (%d guests)', 'event-quote-generator'), $guests),
                'cost' => $guests * 10.00
            ]
        ];

        // Success response with all necessary data
        wp_send_json_success([
            'event_type' => $event_type,
            'guests' => $guests,
            'date' => $date,
            'quote' => $quote,
            'breakdown' => $breakdown,
            'message' => __('Quote generated successfully!', 'event-quote-generator')
        ]);
    } catch (\Exception $e) {
        wp_send_json_error(['message' => $e->getMessage()]);
    }
}
    /**
     * Calculate the quote
     */
    private function calculate_quote($event_type, $guests, $date) {
        // Dummy logic; replace with actual calculation
        $base_price = 100;
        $guest_factor = 10;

        return $base_price + ($guests * $guest_factor);
    }

    /**
     * Register REST API routes
     */
    public function register_rest_routes() {
        register_rest_route('event-quote-generator/v1', '/generate-quote', [
            'methods' => 'POST',
            'callback' => [$this, 'generate_quote_rest_callback'],
            'permission_callback' => '__return_true',
        ]);
    }

    /**
     * REST API callback for generating quotes
     */
    public function generate_quote_rest_callback($request) {
        try {
            $event_type = $request->get_param('event_type');
            $guests = $request->get_param('guests');
            $date = $request->get_param('event_date');

            // Calculate quote
            $quote = $this->calculate_quote($event_type, $guests, $date);

            return rest_ensure_response([
                'success' => true,
                'quote' => number_format($quote, 2),
            ]);
        } catch (\Exception $e) {
            return new \WP_Error('quote_generation_failed', $e->getMessage(), ['status' => 400]);
        }
    }
}
