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
    private $version;
    private const OPTION_NAME = 'viewer-for-aesys-infocity';
    private const VERSION_OPTION = 'aesys_version_number';
    
    private function __construct() {
        $this->version = $this->get_plugin_version();
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
        add_action('admin_init', [$this, 'admin_init']);
        add_shortcode('aesys', [$this, 'handle_shortcode']);
    }

    private function get_plugin_version() {
        if (!function_exists('get_plugin_data')) {
            require_once(ABSPATH . 'wp-admin/includes/plugin.php');
        }
        $plugin_data = get_plugin_data(__FILE__);
        return $plugin_data['Version'];
    }

    public function load_admin() {
        require_once plugin_dir_path(__FILE__) . 'class-admin.php';
    }

    public function admin_init() {
        register_setting(self::OPTION_NAME, 'aesys_panels');
        
        if (version_compare($this->version, get_option(self::VERSION_OPTION)) === 1) {
            update_option(self::VERSION_OPTION, $this->version);
        }
    }

    public function handle_shortcode($atts) {
        ob_start();
        require plugin_dir_path(__FILE__) . 'class-shortcode.php';
        return ob_get_clean();
    }

    public function get_display_url($id, $refresh = false) {
        $remote_url = 'https://www.myinfo.city/VMS/getCurrentPreviewGIF?VMSID=' . $id;
        $local_url = plugin_dir_path(__FILE__) . 'scrape/' . $id . '.gif';
        $cache_time = 15 * MINUTE_IN_SECONDS;
        
        $old_timestamp = get_option('aesys_time_' . $id);
        
        // Check if cached version is still valid
        if ($old_timestamp && 
            ($old_timestamp > (current_time('timestamp') - $cache_time)) && 
            file_exists($local_url)) {
            return plugins_url('scrape/' . $id . '.gif', __FILE__);
        }
        
        // Try to fetch and save new version
        if ($this->save_remote_file($remote_url, $local_url)) {
            update_option('aesys_time_' . $id, current_time('timestamp'));
            return plugins_url('scrape/' . $id . '.gif', __FILE__);
        }
        
        // Fallback to existing local file or remote URL
        return file_exists($local_url) 
            ? plugins_url('scrape/' . $id . '.gif', __FILE__)
            : $remote_url;
    }

    private function save_remote_file($remote_url, $local_path) {
        return @copy($remote_url, $local_path);
    }
}

// Initialize plugin
function aesys_init() {
    return AesysInfoCityViewer::get_instance();
}
add_action('plugins_loaded', 'aesys_init');

// Backwards compatibility for existing code
function aesys_get_url($id, $refresh = false) {
    return aesys_init()->get_display_url($id, $refresh);
}

// Load Gutenberg block
require_once plugin_dir_path(__FILE__) . 'blocks/aesys-block.php';
