<?php

namespace Library\Parsing;

class Parsing
{
    /** Enter command properties */
    private string $command  = '';
    private array $arguments = [];
    private array $options   = [];

    private array $argv;

    /**
     * Parsing constructor.
     *
     * @param array $argv
     */
    public function __construct (array $argv)
    {
        $this->argv = $argv;

        $this->parsing();
    }

    /** Parsing enter command by properties*/
    private function parsing (): void
    {
        $this->setCommand();
        $this->setArguments();
        $this->setOptions();
    }

    /** Set command */
    private function setCommand(): void
    {
        $this->command = $this->argv[1];
    }

    /** Parse all arguments */
    private function setArguments(): void
    {
        foreach ($this->argv as $key => $argv) {
            if ($this->isArguments($argv)) {
                $arrayOfArguments = $this->getArgumentsFromString($argv);

                $this->arguments = array_merge($this->arguments, $arrayOfArguments);
            }
        }
    }

    /** Parse all options and arguments */
    private function setOptions(): void
    {
        foreach ($this->argv as $key => $argv) {
            if ($this->isOption($argv)) {
                $option = str_replace(['[', ']'], '', $argv);

                [$optionName, $optionArguments] = explode('=', $option);

                $optionArguments = ($this->isArguments($optionArguments))
                    ? $this->getArgumentsFromString($optionArguments)
                    : [$optionArguments];

                $this->options[$optionName] = $optionArguments;
            }
        }
    }

    /** Check if argument by pattern */
    private function isArguments(string $argv) : bool
    {
        return substr($argv, 0, 1) === '{' && substr($argv, -1) === '}';
    }

    /** Check if option by pattern */
    private function isOption(string $argv) : bool
    {
        return substr($argv, 0, 1) === '[' && substr($argv, -1) === ']';
    }

    /** Get array arguments from string */
    private function getArgumentsFromString(string $argv) : array
    {
        $argv = str_replace(['{', '}'], '', $argv);

        return explode(',', $argv);
    }

    /** @return string */
    public function getCommand(): string
    {
        return $this->command;
    }

    /** @return array */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /** @return array */
    public function getOptions(): array
    {
        return $this->options;
    }
}