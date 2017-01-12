<?php
class Option {
    const OPTION_PRE          = 'ridingbooking';
    const OPTION_SEPARATOR    = '^';
    public static $OPTION_SET = array();
    public function __construct() {}
    public static function get($key) {
        $key = self::_buildKey($key);
        return get_option($key, '');
    }
    public static function add($key, $value) {
        if ( ! in_array($key, slef::$OPTION_SET)) {
            return false;
        }
        $key = self::_buildKey($key);
        return add_option($key, $value, '', 'yes');
    }
    public static function update($key, $value) {
        $key = self::_buildKey($key);
        return update_option($key, $value);
    }
    public static function delete($key) {
        $key = self::_buildKey($key);
        return delete_option($key);
    }
    private static function _buildKey($key) {
        return self::OPTION_PRE . self::OPTION_SEPARATOR . $key;
    }
}