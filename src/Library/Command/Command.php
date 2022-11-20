<?php

namespace Library\Command;

use Library\Parsing\Parsing;
use Library\Storage\Storage;

class Command
{
    /** Command properties */
    private string $name        = '';
    private string $description = '';
    private string $command     = '';
    private array $arguments    = [];
    private array $options      = [];

    public function __construct(Parsing $parsing)
    {
        $this->command   = $parsing->getCommand();
        $this->arguments = $parsing->getArguments();
        $this->options   = $parsing->getOptions();

        $this->setFromStorage();
    }

    /** Set name and description if command already exists */
    private function setFromStorage() :void
    {
        $model = Storage::getByCommand($this->command);

        if ($model) {
            $this->name        = $model['name'];
            $this->description = $model['description'];
        }
    }

    /** Set command name */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /** set command description */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Get Command name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get Command description
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Get Command
     *
     * @return string
     */
    public function getCommand(): string
    {
        return $this->command;
    }

    /**
     * Get Command options
     *
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * Get Command options
     *
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /** Save command */
    public function save(): void
    {
        Storage::save($this);
    }
}