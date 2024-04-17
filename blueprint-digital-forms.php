<?php

/**
 * Plugin Name:       BluePrint Digital Forms
 * Plugin URI:        https://blueprintdigital.org/
 * Description:       Plugin to accompany form creation from API response.
 * Version:           1.0
 * Requires at least: 5.2
 * Requires PHP:      7.0
 * Author:            BluePrint Digital
 * Author URI:        https://blueprintdigital.org/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       blueprint-digital-forms
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

define('BLUEPRINT_PATH', plugin_dir_path(__FILE__));
define('BLUEPRINT_URL', plugin_dir_url(__FILE__));
define('BLUEPRINT_API_BASE_URL', 'https://31ed8713468d.ngrok.io');

if (!version_compare(PHP_VERSION, '7.0', '>=')) {
    add_action('admin_notices', 'blueprint_fail_php_version');
} elseif (!version_compare(get_bloginfo('version'), '5.2', '>=')) {
    add_action('admin_notices', 'blueprint_fail_wp_version');
} else {
    require BLUEPRINT_PATH . 'includes/plugin.php';
}

/**
 * Blueprint admin notice for minimum PHP version.
 *
 * Warning when the site doesn't have the minimum required PHP version.
 *
 * @return void
 */
function blueprint_fail_php_version() {
	$message = sprintf( esc_html__( 'BluePrint Digital Forms requires PHP version %s+, plugin is currently NOT RUNNING.', 'blueprint-digital-forms' ), '7.0' );
	$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
	echo wp_kses_post( $html_message );
}

/**
 * Blueprint admin notice for minimum WordPress version.
 *
 * Warning when the site doesn't have the minimum required WordPress version.
 *
 * @return void
 */
function blueprint_fail_wp_version() {
	$message = sprintf( esc_html__( 'BluePrint Digital Forms requires WordPress version %s+. Because you are using an earlier version, the plugin is currently NOT RUNNING.', 'blueprint-digital-forms' ), '5.2' );
	$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
	echo wp_kses_post( $html_message );
}
