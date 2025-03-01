<?php

namespace ArtistudioPopup;

require_once plugin_dir_path(__FILE__) . 'class-popup-meta.php';

class PopupMeta {
    use Singleton;

    protected function init() {
		// Add a custom meta box for popups in the admin panel
        add_action('add_meta_boxes', [$this, 'add_popup_meta_box']);
		// Save the custom meta data when the post is saved
        add_action('save_post', [$this, 'save_popup_meta_data']);
    }

    // Add Custom Meta Box for Page Selection
    public function add_popup_meta_box() {
        add_meta_box(
            'popup_page_meta_box',
            'Select Page for Popup',
            [$this, 'popup_page_meta_box_callback'],
            'popup',
            'side'
        );
    }

    // Callback Function for Meta Box
    public function popup_page_meta_box_callback($post) {
        $selected_page = get_post_meta($post->ID, '_popup_page', true);
        $pages = get_pages();

        echo '<label for="popup_page">Select Page:</label>';
        echo '<select name="popup_page" id="popup_page">';
        echo '<option value="">All Pages</option>';
        foreach ($pages as $page) {
            echo '<option value="' . esc_attr($page->ID) . '" ' . selected($selected_page, $page->ID, false) . '>' . esc_html($page->post_title) . '</option>';
        }
        echo '</select>';
    }

    // Save Meta Box Data
    public function save_popup_meta_data($post_id) {
        if (isset($_POST['popup_page'])) {
            update_post_meta($post_id, '_popup_page', sanitize_text_field($_POST['popup_page']));
        }
    }
}
