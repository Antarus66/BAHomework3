<?php

namespace antarus66\BAHomework3\Commands;


class ExitProgramm extends Command
{
    public function execute($options, $parameters)
    {
        fwrite(STDOUT, "Coffee machine is turning off. Have a nice day!" . PHP_EOL);
        sleep(1);
        die();
    }

    public static function getDescription()
    {
        return 'exit - Closes this programm.' . PHP_EOL;
    }

    public static function getHelp() {
        return self::getDescription() . '    Syntax:  exit' . PHP_EOL;
    }
}