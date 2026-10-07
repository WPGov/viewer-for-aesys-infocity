<?php
/*
Plugin Name:  Aesys MyInfo.City viewer
Description:  Viewer for Aesys MyInfoCity displays
Version:      2.3
Author:       Marco Milesi
Author URI: https://www.marcomilesi.com
Contributors: Milmor
*/

if (!defined('ABSPATH')) {
    exit;
}

class AesysInfoCityViewer {
    private static $instance = null;
    private const OPTION_NAME = 'viewer-for-aesys-infocity';

    private function __construct() {
        $this->init_hooks();
    }

    public static function get_instance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function init_hooks() {
        add_action('init', [$this, 'load_admin']);
        add_action('init', [$this, 'register_assets']);
        add_action('admin_init', [$this, 'admin_init']);
        add_shortcode('aesys', [$this, 'handle_shortcode']);
    }

    public function load_admin() {
        if (is_admin()) {
            require_once plugin_dir_path(__FILE__) . 'class-admin.php';
        }
    }

    public function register_assets() {
        // Swap the loader with the real display image once the page is ready
        wp_register_script('aesys-viewer', false, [], false, true);
        wp_add_inline_script('aesys-viewer', '(function() {
    function loadAesysImgs() {
        document.querySelectorAll("img.aesys-img[data-src]").forEach(function(img) {
            img.src = img.dataset.src;
            img.removeAttribute("data-src");
        });
    }
    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", loadAesysImgs);
    } else {
        loadAesysImgs();
    }
})();');
    }

    public function admin_init() {
        register_setting(self::OPTION_NAME, 'aesys_panels');
    }

    public function handle_shortcode($atts) {
        ob_start();
        require plugin_dir_path(__FILE__) . 'class-shortcode.php';
        return ob_get_clean();
    }

    public function get_display_url($id) {
        // Display IDs are always numeric
        if (!preg_match('/^\d{1,10}$/', (string) $id)) {
            return false;
        }

        $file = $id . '.gif';
        $remote_url = add_query_arg('VMSID', $id, 'https://www.myinfo.city/VMS/getCurrentPreviewGIF');
        $local_path = plugin_dir_path(__FILE__) . 'scrape/' . $file;
        $cache_time = 15 * MINUTE_IN_SECONDS;
        $retry_time = 5 * MINUTE_IN_SECONDS;

        $old_timestamp = (int) get_option('aesys_time_' . $id);
        $is_fresh = $old_timestamp > (current_time('timestamp') - $cache_time) && file_exists($local_path);

        // Refresh the cache, waiting a few minutes after a failed attempt
        if (!$is_fresh && !get_transient('aesys_retry_' . $id)) {
            if ($this->save_remote_file($remote_url, $local_path)) {
                update_option('aesys_time_' . $id, current_time('timestamp'), false);
            } else {
                set_transient('aesys_retry_' . $id, 1, $retry_time);
            }
        }

        // Fallback to existing local file or remote URL
        return file_exists($local_path)
            ? plugins_url('scrape/' . $file, __FILE__)
            : $remote_url;
    }

    private function save_remote_file($remote_url, $local_path) {
        $response = wp_remote_get($remote_url, ['timeout' => 5]);
        if (is_wp_error($response) || 200 !== wp_remote_retrieve_response_code($response)) {
            return false;
        }

        // Store only valid GIF images
        $body = wp_remote_retrieve_body($response);
        if (strncmp($body, 'GIF8', 4) !== 0) {
            return false;
        }

        return false !== file_put_contents($local_path, $body, LOCK_EX);
    }
}

// Initialize plugin
function aesys_init() {
    return AesysInfoCityViewer::get_instance();
}
add_action('plugins_loaded', 'aesys_init');

// Backwards compatibility for existing code ($refresh is ignored)
function aesys_get_url($id, $refresh = false) {
    return aesys_init()->get_display_url($id);
}

// Load Gutenberg block
require_once plugin_dir_path(__FILE__) . 'blocks/aesys-block.php';
