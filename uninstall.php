<?php
// If uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

// Delete plugin options
delete_option('event_quote_generator_settings');

// Delete custom database tables (if any)
global $wpdb;
$table_name = $wpdb->prefix . 'event_quotes';
$wpdb->query("DROP TABLE IF EXISTS {$table_name}");
