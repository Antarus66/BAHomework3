<?php

namespace antarus66\BAHomework3\Commands;
use antarus66\BAHomework3\Exceptions\CommandException;

abstract class Command
{
    protected $required_options_num;
    protected $required_params_num;

    abstract public static function getDescription();
    abstract public function execute($options, $parameters);

    protected function checkRequiredInput($options, $parameters) {
        if (count($options) < $this->required_options_num) {
            throw new CommandException("Required option(s) is not determined!");
        } elseif (count($parameters) < $this->required_params_num) {
            throw new CommandException("Required parameter(s) is not determined!");
        }
    }
}