<?php
namespace EventQuoteGenerator\Frontend;

class REST_API {
    /**
     * Register REST API routes
     */
    public function register_routes() {
        add_action('rest_api_init', function() {
            register_rest_route('eqg/v1', '/generate-quote', array(
                'methods' => 'POST',
                'callback' => array($this, 'generate_quote'),
                'permission_callback' => '__return_true',
                'args' => array(
                    'event_type' => array(
                        'required' => true,
                        'type' => 'string',
                        'sanitize_callback' => 'sanitize_text_field'
                    ),
                    'guests' => array(
                        'required' => true,
                        'type' => 'integer',
                        'sanitize_callback' => 'absint'
                    ),
                    'date' => array(
                        'required' => true,
                        'type' => 'string',
                        'sanitize_callback' => 'sanitize_text_field'
                    )
                )
            ));
        });
    }

    /**
     * Generate quote endpoint callback
     */
    public function generate_quote($request) {
        // Get parameters
        $event_type = $request->get_param('event_type');
        $guests = $request->get_param('guests');
        $date = $request->get_param('date');

        // Your quote calculation logic here
        $quote = $this->calculate_quote($event_type, $guests, $date);

        // Return response
        return rest_ensure_response(array(
            'success' => true,
            'quote' => number_format($quote, 2),
            'message' => __('Quote generated successfully!', 'event-quote-generator')
        ));
    }

    /**
     * Calculate quote based on parameters
     */
    private function calculate_quote($event_type, $guests, $date) {
        // Add your quote calculation logic here
        $base_price = 1000; // Example base price
        $per_guest = 50;    // Example per guest price

        return $base_price + ($guests * $per_guest);
    }
}