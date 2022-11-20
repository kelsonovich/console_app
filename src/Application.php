<?php

namespace Application;

use Library\App;
use Library\Command\Command;
use Library\Response\Response;

class Application
{
    public static function start (array $argv): void
    {
        if (self::withoutParameters($argv)) {
            App::getAllCommands();
        }

        if (self::emptyCommand($argv)) {
            $command    = App::getCommandInfo($argv);
            $parameters = self::getParameters($command);
            App::updateCommand($argv, $parameters);
        }

        if (self::isHelp($argv)) {
            App::showHelpByCommand($argv);
        }

        App::parseCommand($argv);
    }

    /** Check if enter without commands */
    private static function withoutParameters(array $argv): bool
    {
        return (count($argv) === 1);
    }

    /** Check if needed show command with description */
    private static function isHelp(array $argv): bool
    {
        return in_array('{help}', $argv);
    }

    /** Check if enter command without parameters */
    private static function emptyCommand (array $argv): bool
    {
        return (count($argv) === 2);
    }

    /** Update command */
    private static function getParameters (Command $command): array
    {
        Response::line("Enter new name for command (Old name: '{$command->getName()}'):");
        $parameters['name'] = readline();

        Response::line("Enter new name for command (Old name: '{$command->getDescription()}'):");
        $parameters['description'] = readline();

        Response::line("Command update successfully");

        return $parameters;
    }
}
