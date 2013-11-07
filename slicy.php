<?php
/*
	Plugin Name: Slicy
	Demo: http://slicy.ahansson.com
	Description: Slicy Slider is a fully responsive slider that supports up to 30 slides with your images.
	Version: 1.4
	Author: Aleksander Hansson
	Author URI: http://ahansson.com
	v3: true
*/

class ah_Slicy_Plugin {

	function __construct() {
		add_action( 'init', array( &$this, 'ah_updater_init' ) );
	}

	/**
	 * Load and Activate Plugin Updater Class.
	 * @since 0.1.0
	 */
	function ah_updater_init() {

		/* Load Plugin Updater */
		require_once( trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/plugin-updater.php' );

		/* Updater Config */
		$config = array(
			'base'      => plugin_basename( __FILE__ ), //required
			'repo_uri'  => 'http://shop.ahansson.com',  //required
			'repo_slug' => 'slicy',  //required
		);

		/* Load Updater Class */
		new AH_Slicy_Plugin_Updater( $config );
	}

}

new ah_Slicy_Plugin;