<?php

namespace Library\Storage;

use Library\Command\Command;

class Storage
{
    /** Path to file */
    private static string $pathToCommandsJson = './storage/commands.json';

    /** All models */
    protected static array $models = [];

    /** Self instance  */
    private static $instance;

    /** Get instance of class */
    protected static function getInstance (): self
    {
        if (! self::$instance) {
            if (! file_exists(self::$pathToCommandsJson)) {
                self::saveAllCommands();
            }

            self::getAllCommands();

            self::$instance = new static();
        }

        return self::$instance;
    }

    /** Update all commands */
    private static function saveAllCommands(): void
    {
        file_put_contents(self::$pathToCommandsJson, json_encode(self::$models));
    }

    /** Set all commands on property */
    private static function getAllCommands(): void
    {
        self::$models = json_decode(file_get_contents(self::$pathToCommandsJson), true);
    }

    /** Get all commands */
    public static function getAll(): array
    {
        self::getInstance();

        return self::$models;
    }

    /** Save command instance by command code */
    public static function getByCommand(string $command)
    {
        self::getInstance();

        if (! array_key_exists($command, self::$models)) {
            return false;
        }

        return self::$models[$command];
    }

    /** Save command */
    public static function save (Command $command): void
    {
        self::$models[$command->getCommand()] = [
            'name'        => $command->getName(),
            'description' => $command->getDescription(),
            'command'     => $command->getCommand(),
            'arguments'   => $command->getArguments(),
            'options'     => $command->getOptions(),
        ];

        self::saveAllCommands();
    }
}