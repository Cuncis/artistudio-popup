<?php
/**
 * Plugin Name:     Artistudio Popup
 * Plugin URI:      https://karangreksa.site
 * Description:     Plugin to display custom popups using VueJS
 * Author:          Karang Reksa Ginolla
 * Author URI:      https://karangreksa.site
 * Text Domain:     artistudio-popup
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Artistudio_Popup
 */

// Your code starts here.
if(!defined('ABSPATH')) {
	exit;	// Prevent direct access to the file
}

// Autoload classes dynamically
spl_autoload_register(function($class) {
	$prefix = 'ArtistudioPopup\\';	// Namespace prefix
	$base_dir = __DIR__ . '/includes/';	// Base directory for class files

	// Check if the class uses the namespace prefix
	if(strpos($class, $prefix) === 0) {
		$relative_class = substr($class, strlen($prefix));
		$file = $base_dir . 'class-' . strtolower(str_replace('\\', '-', 'relative_class')) . '.php';	// Convert to filename format

		if(file_exists($file)) {
			require $file;	// Load the class file
		} else {
			error_log("Autoload failed: File not found - $file");	// Log error if file is missing
		}
	}
});

// Include necessary class files manually
require_once plugin_dir_path(__FILE__) . 'includes/class-popup-cpt.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-popup-meta.php';
require_once plugin_dir_path(__FILE__) . 'includes/trait-singleton.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-popup-rest-api.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-popup-assets.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-popup-frontend.php';


// Use classes from the namespace
use ArtistudioPopup\PopupCPT;
use ArtistudioPopup\PopupMeta;
use ArtistudioPopup\PopupRestAPI;
use ArtistudioPopup\PopupAssets;
use ArtistudioPopup\PopupFrontend;

// Initialize plugin components using Singleton pattern
PopupCPT::get_instance();
PopupMeta::get_instance();
PopupRestAPI::get_instance();
PopupAssets::get_instance();
PopupFrontend::get_instance();
