<?php
/**
 * Quote calculation logic
 *
 * @package EventQuoteGenerator
 */

namespace EventQuoteGenerator\Common;

use EventQuoteGenerator\Admin\Settings;

/**
 * Class Calculator
 */
class Calculator {
    /**
     * Settings instance
     *
     * @var Settings
     */
    private $settings;

    /**
     * Initialize the class
     */
    public function __construct() {
        $this->settings = new Settings();
    }

    /**
     * Calculate quote
     *
     * @param string $event_type Event type.
     * @param int    $guests     Number of guests.
     * @param string $date       Event date.
     * @return array
     * @throws \Exception If invalid parameters.
     */
    public function calculate( $event_type, $guests, $date ) {
        // Validate inputs
        if ( ! in_array( $event_type, array( 'wedding', 'corporate', 'birthday' ), true ) ) {
            throw new \Exception( __( 'Invalid event type', 'event-quote-generator' ) );
        }

        if ( $guests < 1 || $guests > 1000 ) {
            throw new \Exception( __( 'Invalid number of guests', 'event-quote-generator' ) );
        }

        if ( strtotime( $date ) < strtotime( 'tomorrow' ) ) {
            throw new \Exception( __( 'Date must be in the future', 'event-quote-generator' ) );
        }

        // Get base prices
        $base_price = $this->settings->get_base_price( $event_type );
        $per_guest = $this->settings->get_per_guest_price();

        // Calculate guest cost
        $guest_cost = $guests * $per_guest;

        // Check if peak season
        $month = date( 'n', strtotime( $date ) );
        $is_peak = in_array( $month, array( 6, 7, 8 ), true );
        $multiplier = $is_peak ? $this->settings->get_peak_multiplier() : 1;

        // Calculate subtotal and final total
        $subtotal = $base_price + $guest_cost;
        $seasonal_adjustment = $is_peak ? ( $subtotal * ( $multiplier - 1 ) ) : 0;
        $total = $subtotal + $seasonal_adjustment;

        // Return quote details
        return array(
            'event_type'          => $event_type,
            'guests'              => $guests,
            'date'               => $date,
            'base_price'         => $base_price,
            'guest_cost'         => $guest_cost,
            'is_peak_season'     => $is_peak,
            'seasonal_adjustment' => $seasonal_adjustment,
            'subtotal'           => $subtotal,
            'total'              => $total,
            'breakdown'          => array(
                'base_price'         => array(
                    'label' => __( 'Base Price', 'event-quote-generator' ),
                    'amount' => $base_price,
                ),
                'guest_cost'         => array(
                    'label' => __( 'Guest Services', 'event-quote-generator' ),
                    'amount' => $guest_cost,
                ),
                'seasonal_adjustment' => array(
                    'label' => __( 'Seasonal Adjustment', 'event-quote-generator' ),
                    'amount' => $seasonal_adjustment,
                ),
            ),
        );
    }

    /**
     * Format price
     *
     * @param float $price Price to format.
     * @return string
     */
    public function format_price( $price ) {
        return number_format( $price, 2, '.', ',' );
    }
}