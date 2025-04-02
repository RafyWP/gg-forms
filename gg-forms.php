<?php
/**
 * GG Forms – Grow & Go
 *
 * @package           RafyCo\GGForms
 * @wordpress-plugin
 * Plugin Name:       GG Forms
 * Plugin URI:        https://rafy.site/projects/gg-forms
 * Description:       Grow & Go. Guided & gamified forms that move users — and your business — forward.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Rafy
 * Author URI:        https://rafy.site
 * Text Domain:       gg-forms
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Update URI:        https://rafy.site/projects/gg-forms
 */

defined( 'ABSPATH' ) || exit;

$autoload = __DIR__ . '/vendor/autoload.php';
if ( file_exists( $autoload ) ) {
	require_once $autoload;
}

function rafy_load_textdomain() {
    load_plugin_textdomain( 'gg-forms', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

add_action( 'init', 'rafy_load_textdomain' );

try {
	$plugin_class = 'RafyCo\\GGForms\\Plugin';
	if ( class_exists( $plugin_class ) ) {
		$plugin = new $plugin_class();
		$plugin->run();
	}
} catch ( \Throwable $e ) {
	if ( class_exists( 'RafyCo\\GGForms\\Debugger' ) ) {
		\RafyCo\GGForms\Debugger::log( $e->getMessage() );
	}
}

register_activation_hook( __FILE__, function () {
	$plugin_class = 'RafyCo\\GGForms\\Plugin';
	if ( class_exists( $plugin_class ) ) {
		$plugin = new $plugin_class();
		if ( method_exists( $plugin, 'register_rewrite_rule' ) ) {
			$plugin->register_rewrite_rule();
		}
		flush_rewrite_rules();
	}
} );

register_deactivation_hook( __FILE__, function () {
	flush_rewrite_rules();
} );
