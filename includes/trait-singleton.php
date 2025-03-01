<?php

namespace ArtistudioPopup;

trait Singleton {
    private static $instance = null; // Holds the singleton instance

    public static function get_instance() {
		// Creates a new instance if none exists, then initializes it
        if (self::$instance === null) {
            self::$instance = new self();
            self::$instance->init();
        }
        return self::$instance;
    }

    protected function init() {
        // This method should be overridden in classes using this trait.
    }
}
