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
        fwrite(STDOUT, 'You can use next commands:' . PHP_EOL);
        foreach ($this->routes as $k=>$v) {
            fwrite(STDOUT, "  $k - {$v::getDescription()}");
        }
        fwrite(STDOUT, PHP_EOL);

    }

    public static function getDescription()
    {
        return 'Returns this manual.' . PHP_EOL;
    }
}