<?php

namespace antarus66\BAHomework3;

use antarus66\BAHomework3\Exceptions\CLIException;
use antarus66\BAHomework3\Exceptions\CommandException;

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
        fwrite(STDOUT, "CoffeeMachine programm." . PHP_EOL);
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
        $command_array = array_map('trim', explode(" ", trim($command_string)));
        $command = null;
        $options = [];
        $params = [];

        for ($i = 0; $i < count($command_array); $i++) {
            $el = $command_array[$i];

            if ($i === 0 && $el != null && substr($el, 0, 1) !== '-') {
                $command = $el;
            } elseif (substr($el, 0, 2) === '--') {
                $options[] = substr($el, 2);
            } else {
                $params[] = $el;
            }
        }

        $this->route($command, $options, $params);
    }

    public function route($command, $options=null, $parameters=null) {
        if ($command == null) {
            throw new CLIException('Command is not detected!');
        }

        if (!array_key_exists($command, $this->routes)) {
            throw new CLIException('Unknown command!');
        }

        $command_handler = $this->di_container[$command . '_command_handler'];
        try {
            $command_handler->execute($options, $parameters);
        } catch (CommandException $e) {
            fwrite(STDERR, $e->getMessage() . PHP_EOL);
            $this->route('help', null, [$command]);
        }
    }
}