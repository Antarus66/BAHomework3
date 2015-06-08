<?php

namespace antarus66\BAHomework3;

use antarus66\BAHomework3\Exceptions\CLIException;

class Application
{
    protected $di_container;
    protected $routes;

    public function __construct($di_container)
    {
        $this->di_container = $di_container;
        $this->routes = $di_container['routes'];
    }

    public function start()
    {
        $this->route('help');
        // REPL cycle
        while (true) {
            fwrite(STDOUT, 'coffeemaker> ');
            try {
                $this->handleCommandString(fgets(STDIN));
            } catch (CLIException $e) {
                fwrite(STDERR, $e->getMessage() . PHP_EOL);
                $this->route('help');
            }
        }
    }

    public function handleCommandString($command_string)
    {
        $command_array = array_map('trim', explode(" ", $command_string));
        $command = null;
        $options = [];
        $params = [];

        for ($i = 0; $i < count($command_array); $i++) {
            $el = $command_array[$i];

            if ($i === 0 && $el != null && substr($el, 0, 1) !== '-') {
                $command = $el;
                continue;
            }

            if (substr($el, 0, 2) === '--') {
                $options[] = substr($el, 2);
            } else {
                $params[] = $el;
            }
        }

        if ($command == null) {
            throw new CLIException('Command is not detected!');
        }

        $this->route($command, $options, $params);
    }

    public function route($command, $options=null, $parameters=null) {
        if (!array_key_exists($command, $this->routes)) {
            throw new CLIException('Unknown command!');
        }

        $command_handler = $this->di_container[$command . '_command_handler'];
        $command_handler->execute($options, $parameters);
    }
}