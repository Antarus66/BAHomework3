<?php

namespace antarus66\BAHomework3\Commands;

abstract class Command
{
    abstract public static function getDescription();
    abstract public function execute($options, $parameters);
}