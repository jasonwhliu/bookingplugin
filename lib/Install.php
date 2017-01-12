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

    public function createDB() {
        $create_db_sql = 'CREATE TABLE `wordpress`.`wp_ridingbooking` ( `id` INT NOT NULL AUTO_INCREMENT , `b_date` TIMESTAMP NOT NULL , `b_begin` TIMESTAMP NOT NULL , `b_end` TIMESTAMP NOT NULL , `b_userid` INT NOT NULL , `b_msg` TEXT NOT NULL , `b_status` INT NOT NULL , `time` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , `msg` TEXT NOT NULL , `status` INT NOT NULL , PRIMARY KEY (`id`), INDEX `date_index` (`b_date`), INDEX `buser_index` (`b_userid`)) ENGINE = InnoDB';
        

    }
}