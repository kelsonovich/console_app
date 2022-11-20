<?php

namespace Library\Response;

use Library\Command\Command;

class Response
{
    /** Pretty output info by command */
    public static function pretty(Command $command): void
    {
        self::setNewLine(2);
        echo "Called command: {$command->getCommand()}";
        self::setNewLine(3);

        if (count($command->getArguments()) > 0) {
            echo "Arguments: ";
            self::setNewLine();

            foreach ($command->getArguments() as $argument) {
                echo self::getOffset(4) . " - " . self::getOffset() . $argument;
                self::setNewLine();
            }

            self::setNewLine(2);
        }

        if (count($command->getOptions()) > 0) {
            echo "Options: ";
            self::setNewLine();

            foreach ($command->getOptions() as $option => $arguments) {
                echo self::getOffset(4) . " - " . self::getOffset() . $option;
                self::setNewLine();

                foreach ($arguments as $argument) {
                    echo self::getOffset(8) . " - " . self::getOffset() . $argument;
                    self::setNewLine();
                }
            }

            self::setNewLine(2);
        }
    }

    /** Pretty output all commands with their description */
    public static function allCommands(array $commands): void
    {
        if (count($commands) === 0) {
            self::setNewLine(2);
            echo "Commands not found...";
            self::setNewLine(2);
            die();
        }

        self::setNewLine(2);
        echo "All commands: ";
        self::setNewLine(3);

        foreach ($commands as $key => $command) {
            echo self::getOffset(4) . " - " . self::getOffset() . $key;
            self::setNewLine();
            echo self::getOffset(9) . 'Description:';
            self::setNewLine();
            echo self::getOffset(8) . " - " . self::getOffset() . $command['description'];
            self::setNewLine();
        }

        die();
    }

    /** Pretty output all commands with their description */
    public static function withDescription(object $command): void
    {
        self::setNewLine(2);
        echo "Command: {$command->getCommand()}";
        self::setNewLine(2);
        echo "Description: ";
        self::setNewLine();
        echo self::getOffset(2) . " - " . self::getOffset() . $command->getDescription();
        self::setNewLine(2);

        die();
    }

    /** Enter line into console */
    public static function line(string $text): void
    {
        self::setNewLine();
        echo $text;
        self::setNewLine();
    }

    /** Set new line for output */
    private static function setNewLine(int $times = 1): void
    {
        echo str_repeat(PHP_EOL, $times);
    }

    /** Set offset from start */
    private static function getOffset(int $times = 2): string
    {
        return str_repeat(' ', $times);
    }
}