<?php
/*
Plugin Name: Riding booding
Plugin URI: http://localhost
Description: self booking
Author: self
Author URI: http://localhost
Text Domain: booking
Domain Path: /languages/
Version: 0.1
 */
//D:\wamp\www\wordpress\wp-content\plugins\ridingbooking\ridingbooking.php
if ( ! defined('BOOKING_FILE')) {
    define('BOOKING_FILE', __FILE__);
}
//ridingbooking.php
if ( ! defined('BOOKING_PLUGIN_FILENAME')) {
    define('BOOKING_PLUGIN_FILENAME', basename(__FILE__));
}
//ridingbooking
if ( ! defined('BOOKING_PLUGIN_DIRNAME')) {
    define('BOOKING_PLUGIN_DIRNAME', plugin_basename(dirname(__FILE__)));
}
//D:\wamp\www\wordpress\wp-content\plugins\ridingbooking
if ( ! defined('BOOKING_PLUGIN_DIR')) {
    define('BOOKING_PLUGIN_DIR', untrailingslashit(plugin_dir_path(BOOKING_FILE)));
}
//http://localhost/wordpress/wp-content/plugins/ridingbooking
if ( ! defined('BOOKING_PLUGIN_URL')) {
    define('BOOKING_PLUGIN_URL', untrailingslashit(plugins_url('', BOOKING_FILE)));
}
if (is_admin()) {
    add_action('admin_menu', 'add_main_menu');
}
function add_main_menu() {
    if (is_admin()) {
        add_menu_page('Riding Booking1', 'Riding Booking', 'administrator', 'ttttt', array("Admin", "indexAction"), '', 2);
    }
}
spl_autoload_register(function ($className) {
    $className = ltrim($className, '\\');
    $fileName  = '';
    $namespace = '';
    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
    $find_pre_path = array(
        BOOKING_PLUGIN_DIR . '/lib',
        BOOKING_PLUGIN_DIR . '/models',
        BOOKING_PLUGIN_DIR . '/controllers'
    );
    foreach ($find_pre_path as $pre) {
        $tmp = $pre . "/" . $fileName;
        if (file_exists($tmp)) {
            require_once $tmp;
            break;
        }
    }
});