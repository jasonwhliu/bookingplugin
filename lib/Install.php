<?php
/**
 * 插件安装
 */
class Install {
    public function __construct() {}
    public static function ini() {
        $user = new User();
        $user->pluginIni();
    }
    public function install() {
        self::ini();
        echo "install";
    }
    public function uninstall() {
        echo "uninstall";
    }
    public function deactivation() {
        echo "deactivation";
    }
}