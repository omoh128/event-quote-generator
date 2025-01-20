<?php
/**
 * Settings handler
 *
 * @package EventQuoteGenerator
 */

namespace EventQuoteGenerator\Admin;

/**
 * Class Settings
 */
class Settings {
    /**
     * Option name in the database
     *
     * @var string
     */
    private $option_name = 'eqg_options';

    /**
     * Default settings
     *
     * @var array
     */
    private $defaults = array(
        'wedding_base' => 1000,
        'corporate_base' => 800,
        'birthday_base' => 500,
        'per_guest' => 50,
        'peak_multiplier' => 1.5,
    );

    /**
     * Get all settings
     *
     * @return array
     */
    public function get_all_settings() {
        return wp_parse_args(
            get_option( $this->option_name, array() ),
            $this->defaults
        );
    }

    /**
     * Get single setting
     *
     * @param string $key Setting key.
     * @param mixed  $default Default value.
     * @return mixed
     */
    public function get_setting( $key, $default = null ) {
        $settings = $this->get_all_settings();
        
        if ( isset( $settings[ $key ] ) ) {
            return $settings[ $key ];
        }
        
        if ( null !== $default ) {
            return $default;
        }
        
        return isset( $this->defaults[ $key ] ) ? $this->defaults[ $key ] : null;
    }

    /**
     * Update single setting
     *
     * @param string $key Setting key.
     * @param mixed  $value Setting value.
     * @return bool
     */
    public function update_setting( $key, $value ) {
        $settings = $this->get_all_settings();
        $settings[ $key ] = $value;
        return update_option( $this->option_name, $settings );
    }

    /**
     * Update multiple settings
     *
     * @param array $new_settings Settings array.
     * @return bool
     */
    public function update_settings( $new_settings ) {
        $settings = $this->get_all_settings();
        $settings = wp_parse_args( $new_settings, $settings );
        return update_option( $this->option_name, $settings );
    }

    /**
     * Delete all settings
     *
     * @return bool
     */
    public function delete_settings() {
        return delete_option( $this->option_name );
    }

    /**
     * Get base price for event type
     *
     * @param string $event_type Event type.
     * @return int
     */
    public function get_base_price( $event_type ) {
        $key = $event_type . '_base';
        return $this->get_setting( $key );
    }

    /**
     * Get price per guest
     *
     * @return int
     */
    public function get_per_guest_price() {
        return $this->get_setting( 'per_guest' );
    }

    /**
     * Get peak season multiplier
     *
     * @return float
     */
    public function get_peak_multiplier() {
        return $this->get_setting( 'peak_multiplier' );
    }
}