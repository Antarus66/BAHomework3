<?php

namespace antarus66\BAHomework3\Commands;

class ShowHelp extends Command
{
    protected $routes;

    public function __construct($routes) {
        $this->routes = $routes;
    }

    public function execute($options, $parameters)
    {
        if (count($parameters) > 0) {
            $operation = $parameters[0];
            $operation_handler_class = $this->routes[$operation];
            fwrite(STDOUT, $operation_handler_class::getHelp());
        } else {
            fwrite(STDOUT, 'The following commands are available:' . PHP_EOL);
            foreach ($this->routes as $k=>$v) {
                fwrite(STDOUT, "    {$v::getDescription()}");
            }
        }
        fwrite(STDOUT, PHP_EOL);
    }

    public static function getDescription()
    {
        return 'help - Returns commands manual or help of determined function.' . PHP_EOL;
    }

    public static function getHelp() {
        return self::getDescription()
        . '    Syntax:  help [command]' . PHP_EOL
        . '    Example: help make-coffee' . PHP_EOL;
    }
}