<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              kusy.urz.pl
 * @since             1.0.0
 * @package           E_Learning
 *
 * @wordpress-plugin
 * Plugin Name:       E-Learning
 * Plugin URI:        kusy.urz.pl/projekt
 * Description:       Obsługa materiałów używanych do e-learning
 * Version:           1.0.0
 * Author:            Kusy&&Kucharzyk
 * Author URI:        kusy.urz.pl
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       e-learning
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-e-learning-activator.php
 */
function activate_e_learning() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-e-learning-activator.php';
	E_Learning_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-e-learning-deactivator.php
 */
function deactivate_e_learning() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-e-learning-deactivator.php';
	E_Learning_Deactivator::deactivate();
}



function wp_elearning_shortcode(){
	include_once(plugin_dir_path( __FILE__ ) . "includes/e-learning-shortcode.php");
	}
add_shortcode('e_learning', 'wp_elearning_shortcode');


register_activation_hook( __FILE__, 'activate_e_learning' );
register_deactivation_hook( __FILE__, 'deactivate_e_learning' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-e-learning.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_e_learning() {

	$plugin = new E_Learning();
	$plugin->run();

}
run_e_learning();


