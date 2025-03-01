<?php

namespace ArtistudioPopup;

require_once plugin_dir_path(__FILE__) . 'trait-singleton.php';

class PopupFrontend {
    use Singleton;

    protected function init() {
		// Add a page-specific class to the body tag
        add_filter('body_class', [$this, 'add_page_id_body_class']);
		// Inject the custom popup HTML into the footer
		add_action('wp_footer', array($this, 'my_custom_popup_html'));
    }

	// Render the Vue.js popup container in the footer
	function my_custom_popup_html() {
		?>
		<div id="my-vue-popup">
			<div v-if="showPopup" class="vue-popup-overlay">
				<div class="vue-popup-content">
					<h2>{{ popupData.title }}</h2>
					<p v-html="popupData.description"></p>
					<button @click="closePopup">Close</button>
				</div>
			</div>
		</div>
		<?php
	}

	// Add the page ID as a class to the body tag
    public function add_page_id_body_class($classes) {
        if (is_page()) {
            global $post;
            $classes[] = 'page-id-' . $post->ID;

			// Inject a script in the footer to store the page ID in a data attribute
            add_action('wp_footer', function() use ($post) {
                echo '<script>document.body.setAttribute("data-page-id", "' . esc_js($post->ID) . '");</script>';
            });
        }
        return $classes;
    }
}
