<?php
/**
 * Created by PhpStorm.
 * User: antarus66
 * Date: 6/27/15
 * Time: 10:51 AM
 */

namespace antarus66\BAHomework3\App\Configs;


class Config extends AbstractConfig
{
    private static $instance;
    private $configs;

    private function __construct()
    {
        $this->configs = parse_ini_file('config.ini');
    }

    private function __clone()
    {}

    private function __wakeup()
    {}

    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new Config();
        }

        return self::$instance;
    }

    public function getSetting($setting_name)
    {
        return $this->configs[$setting_name];
    }
}