<?php

namespace ArtistudioPopup;

require_once plugin_dir_path(__FILE__) . 'trait-singleton.php';

class PopupAssets
{
	use Singleton;

	// Initiallize the class and enqueue scripts and styles
	protected function init()
	{
		add_action('wp_enqueue_scripts', [$this, 'enqueue']);
	}

	// Load Vue.js, custom Javascript, and CSS files
	public function enqueue()
	{
		wp_enqueue_script('vue', 'https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.min.js', [], null, true);
		wp_enqueue_script('popup-js', plugin_dir_url(__FILE__) . '../assets/js/popup.js', ['vue'], null, true);
		wp_enqueue_style('popup-style', plugin_dir_url(__FILE__) . '../assets/css/popup.css', [], '1.0');
	}
}
