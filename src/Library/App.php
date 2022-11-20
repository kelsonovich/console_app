<?php

namespace Library;

use Library\Command\Command;
use Library\Storage\Storage;
use Library\Parsing\Parsing;
use Library\Response\Response;

class App
{
    private static $command;

    /** Display all saved commands */
    public static function getAllCommands (): void
    {
        Response::allCommands(Storage::getAll());
    }

    /** Display command name and description by command */
    public static function showHelpByCommand (array $argv): void
    {
        $command = self::getCommandInstance($argv);

        Response::withDescription($command);
    }

    /** Update name and description into command */
    public static function updateCommand (array $argv, array $parameters = []): void
    {
        $command = self::getCommandInstance($argv);

        $command->setName($parameters['name']);
        $command->setDescription($parameters['description']);
        $command->save();
    }

    /** Get command */
    public static function getCommandInfo (array $argv): Command
    {
        return self::getCommandInstance($argv);
    }

    /** Parse command */
    public static function parseCommand (array $argv): void
    {
        $command = self::getCommandInstance($argv);

        Response::pretty($command);
    }

    /** Get command object */
    private static function getCommandInstance (array $argv): Command
    {
        if (! self::$command) {
            self::$command = new Command(new Parsing($argv));
        }

        return self::$command;
    }
}
