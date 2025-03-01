<?php

namespace ArtistudioPopup;

require_once plugin_dir_path(__FILE__) . 'trait-singleton.php';
require_once plugin_dir_path(__FILE__) . 'interface-popup.php';

class PopupCPT implements PopupInterface {
    use Singleton;

	// Initialize the class and register actions
    protected function init() {
        add_action('init', [$this, 'register']);
    }

	// Register the custom post type 'popup'
    public function register() {
        register_post_type('popup', [
            'labels'      => ['name' => 'Popups', 'singular_name' => 'Popup'],
            'public'      => true,
            'show_in_rest'=> true,
            'supports'    => ['title', 'editor'],
            'menu_icon'   => 'dashicons-format-chat',
        ]);
    }
}

