<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       kusy.urz.pl
 * @since      1.0.0
 *
 * @package    E_Learning
 * @subpackage E_Learning/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    E_Learning
 * @subpackage E_Learning/admin
 * @author     Students <frajeros@gmail.com>
 */
class E_Learning_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}



	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles($hook) {


		global $e_learning;
		global $e_learning2;
		global $e_learning3;
		
		if( $hook != $e_learning && $hook != $e_learning2 && $hook != $e_learning3) {
		return;
		}

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts($hook) {

		global $e_learning;
		global $e_learning2;
		global $e_learning3;

		if( $hook != $e_learning && $hook != $e_learning2 && $hook != $e_learning3) {
		return;
		}

		
		wp_enqueue_script('enqueue_scripts', 'https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js', array(), null, false);
	
	}


public function add_plugin_admin_menu() {

    /*
     * Add a settings page for this plugin to the Settings menu.
     *
     * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
     *
     *        Administration Menus: http://codex.wordpress.org/Administration_Menus
     *
     */
	global $e_learning;
	global $e_learning2;
	global $e_learning3;
    $e_learning=add_menu_page( 'E-learning', 'E-learning', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page')
	);
	$e_learning2=add_submenu_page( $this->plugin_name, 'Materiały', 'Materiały', 'manage_options', 'e_learning_materialy', array($this, 'display_plugin_materialy_page'));
	$e_learning3=add_submenu_page( $this->plugin_name, 'Realizacja', 'Realizacja', 'manage_options', 'e_learning_realizacja', array($this, 'display_plugin_realizacja_page'));

}

 /**
 * Add settings action link to the plugins page.
 *
 * @since    1.0.0
 */

public function add_action_links( $links ) {
    /*
    *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
    */
   $settings_link = array(
    '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
   );
   return array_merge(  $settings_link, $links );

}

/**
 * Render the settings page for this plugin.
 *
 * @since    1.0.0
 */

public function display_plugin_setup_page() {
	include_once( 'partials/e-learning-admin-display.php' );
}

public function display_plugin_realizacja_page() {
	include_once( 'partials/e-learning-admin-display-realizacja.php' );
}

public function display_plugin_materialy_page() {
	include_once( 'partials/e-learning-admin-display-materialy.php' );

}




}
?>