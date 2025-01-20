<?php
/**
 * Admin functionality handler
 *
 * @package EventQuoteGenerator
 */

namespace EventQuoteGenerator\Admin;

/**
 * Class Admin
 */

class Admin {
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
        add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
        add_action( 'admin_init', array( $this, 'register_settings' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
    }

    /**
     * Add menu items
     */
    public function add_admin_menu() {
        add_menu_page(
            __( 'Event Quote Generator', 'event-quote-generator' ),
            __( 'Quote Generator', 'event-quote-generator' ),
            'manage_options',
            'event-quote-generator',
            array( $this, 'render_admin_page' ),
            'dashicons-calculator',
            90
        );
    }

    /**
     * Register settings
     */
    public function register_settings() {
        register_setting(
            'eqg_options',
            'eqg_options',
            array( $this, 'sanitize_settings' )
        );
    }

    /**
     * Sanitize settings
     *
     * @param array $input The input array to sanitize.
     * @return array
     */
    public function sanitize_settings( $input ) {
        $sanitized = array();

        if ( isset( $input['wedding_base'] ) ) {
            $sanitized['wedding_base'] = absint( $input['wedding_base'] );
        }
        
        if ( isset( $input['corporate_base'] ) ) {
            $sanitized['corporate_base'] = absint( $input['corporate_base'] );
        }
        
        if ( isset( $input['birthday_base'] ) ) {
            $sanitized['birthday_base'] = absint( $input['birthday_base'] );
        }
        
        if ( isset( $input['per_guest'] ) ) {
            $sanitized['per_guest'] = absint( $input['per_guest'] );
        }
        
        if ( isset( $input['peak_multiplier'] ) ) {
            $sanitized['peak_multiplier'] = (float) $input['peak_multiplier'];
            if ( $sanitized['peak_multiplier'] < 1 ) {
                $sanitized['peak_multiplier'] = 1;
            }
            if ( $sanitized['peak_multiplier'] > 2 ) {
                $sanitized['peak_multiplier'] = 2;
            }
        }

        return $sanitized;
    }

    /**
     * Render admin page
     */
    public function render_admin_page() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        include EQG_PLUGIN_DIR . 'templates/admin/settings-page.php';
    }

    /**
     * Enqueue admin assets
     *
     * @param string $hook The current admin page.
     */
    public function enqueue_assets( $hook ) {
        if ( 'toplevel_page_event-quote-generator' !== $hook ) {
            return;
        }

        wp_enqueue_style(
            'eqg-admin',
            EQG_PLUGIN_URL . '',
            array(),
            EQG_VERSION
        );

        wp_enqueue_script(
            'eqg-admin',
            EQG_PLUGIN_URL . 'assets/js/event-quote-generator.js',
            array( 'jquery' ),
            EQG_VERSION,
            true
        );
    }
}