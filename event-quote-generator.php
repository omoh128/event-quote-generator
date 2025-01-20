<?php
/**
 * Plugin Name: Event Quote Generator
 * Plugin URI: https://github.com/omoh128
 * Description: Custom quote generator for events and wedding party suppliers
 * Version: 1.0.0
 * Author: Omomoh Agiogu
 * Author URI: https://yourwebsite.com
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: event-quote-generator
 * Domain Path: /languages
 *
 * @package EventQuoteGenerator
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

// Define plugin constants
define('EQG_VERSION', '1.0.0');
define('EQG_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('EQG_PLUGIN_URL', plugin_dir_url(__FILE__));
define('EQG_PLUGIN_BASENAME', plugin_basename(__FILE__));
define('EQG_MIN_PHP_VERSION', '7.4');

/**
 * Class Event_Quote_Generator_Plugin
 * Main plugin container class
 */
final class Event_Quote_Generator_Plugin {
    /**
     * Plugin instance.
     *
     * @var Event_Quote_Generator_Plugin|null
     */
    private static $instance = null;

    /**
     * Plugin components.
     *
     * @var array
     */
    private $components = [];

    /**
     * Get plugin instance.
     *
     * @return Event_Quote_Generator_Plugin
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor.
     */
    private function __construct() {
        // Composer autoloader
        $this->load_composer_autoloader();

        // Register activation/deactivation hooks
        register_activation_hook(__FILE__, [$this, 'activate']);
        register_deactivation_hook(__FILE__, [$this, 'deactivate']);

        // Initialize plugin
        add_action('plugins_loaded', [$this, 'init']);
    }

    /**
     * Load Composer autoloader.
     *
     * @return bool
     */
    private function load_composer_autoloader() {
        $autoloader = dirname(__FILE__) . '/vendor/autoload.php';
        
        if (file_exists($autoloader)) {
            require_once $autoloader;
            return true;
        }

        add_action('admin_notices', function() {
            $message = sprintf(
                esc_html__('Error: Composer autoloader not found. Please run %1$s in the plugin directory.', 'event-quote-generator'),
                '<code>composer install</code>'
            );
            printf('<div class="notice notice-error"><p>%s</p></div>', $message);
        });

        return false;
    }

    /**
     * Plugin activation.
     */
    public function activate() {
        // Check PHP version
        if (version_compare(PHP_VERSION, EQG_MIN_PHP_VERSION, '<')) {
            wp_die(
                sprintf(
                    esc_html__('Event Quote Generator requires PHP version %s or higher. Please upgrade PHP.', 'event-quote-generator'),
                    EQG_MIN_PHP_VERSION
                ),
                'Plugin Activation Error',
                ['back_link' => true]
            );
        }

        try {
            // Initialize settings
            if (class_exists('EventQuoteGenerator\\Admin\\Settings')) {
                $settings = new EventQuoteGenerator\Admin\Settings();
                $settings->get_all_settings();
            }

            // Set activation flag
            add_option('eqg_activated', true);

            // Flush rewrite rules
            flush_rewrite_rules();
        } catch (Exception $e) {
            wp_die(
                esc_html($e->getMessage()),
                'Plugin Activation Error',
                ['back_link' => true]
            );
        }
    }

    /**
     * Plugin deactivation.
     */
    public function deactivate() {
        delete_option('eqg_activated');
        flush_rewrite_rules();
    }

    /**
     * Initialize plugin components.
     */
    public function init() {
        try {
            // Load text domain
            load_plugin_textdomain(
                'event-quote-generator',
                false,
                dirname(EQG_PLUGIN_BASENAME) . '/languages'
            );

            // Initialize loader
            if (class_exists('EventQuoteGenerator\\Common\\Loader')) {
                $this->components['loader'] = new EventQuoteGenerator\Common\Loader();
            }

            // Initialize admin
            if (is_admin() && class_exists('EventQuoteGenerator\\Admin\\Admin')) {
                $this->components['admin'] = new EventQuoteGenerator\Admin\Admin(
                    $this->components['loader']
                );
            }

            // Initialize frontend
            if (!is_admin() && class_exists('EventQuoteGenerator\\Frontend\\Frontend')) {
                $this->components['frontend'] = new EventQuoteGenerator\Frontend\Frontend(
                    $this->components['loader']
                );
            }

            // Initialize shortcodes (available everywhere)
            if (class_exists('EventQuoteGenerator\\Frontend\\Shortcode')) {
                $this->components['shortcode'] = new EventQuoteGenerator\Frontend\Shortcode(
                    $this->components['loader']
                );
            }

            // Run the loader
            if (isset($this->components['loader'])) {
                $this->components['loader']->run();
            }

        } catch (Exception $e) {
            // Log error and show admin notice
            error_log($e->getMessage());
            add_action('admin_notices', function() use ($e) {
                printf(
                    '<div class="notice notice-error"><p>%s</p></div>',
                    esc_html($e->getMessage())
                );
            });
        }
    }

    /**
     * Get a component instance.
     *
     * @param string $component Component name.
     * @return mixed|null Component instance or null if not found.
     */
    public function get_component($component) {
        return isset($this->components[$component]) ? $this->components[$component] : null;
    }
}

// Initialize the plugin
function eqg() {
    return Event_Quote_Generator_Plugin::get_instance();
}

// Start the plugin
eqg();