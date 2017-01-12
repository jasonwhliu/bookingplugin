<?php
/**
 * 自动渲染嘞
 */
class AutoRender {
    const CLASS_NAME = __CLASS__;
    const TPL_PATH   = BOOKING_PLUGIN_DIR . "/views";
    public function __constrcut() {}
    public static function render($params = array()) {
        $call = self::getPreMethod();
        if (strpos($call['function'], 'Action') !== false) {
            $file_name = self::TPL_PATH . "/" . $call['class'] . "/" . str_replace('Action', '', $call['function']) . ".phtml";
            if (is_file($file_name)) {
                foreach ($params as $key => $value) {
                    $$key = $value;
                }
                include $file_name;
            }
        }
    }
    /**
     * 获取调用方信息
     */
    public static function getPreMethod() {
        $debug_info = debug_backtrace();
        $line       = '';
        $call       = '';
        foreach ($debug_info as $one) {
            if (self::CLASS_NAME != $one['class']) {
                $call = $one;
                break;
            }
            $line = $one['line'];
        }
        return $call;
    }
}