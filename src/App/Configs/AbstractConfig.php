<?php
/**
 * Created by PhpStorm.
 * User: antarus66
 * Date: 6/27/15
 * Time: 11:14 AM
 */

namespace antarus66\BAHomework3\App\Configs;

abstract class AbstractConfig
{
    abstract public function getSetting($setting_name);
}