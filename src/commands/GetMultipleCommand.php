<?php

namespace vetrinus\memcached\commands;

use vetrinus\memcached\BaseCommand;

class GetMultipleCommand extends BaseCommand
{
    /** @var string[] */
    private $keys = [];

    public function __construct($keys)
    {
        foreach ($keys as $key) {
            $this->keys[] = $this->processKey($key);
        }
    }

    public function represent(): string
    {
        $command = 'get';

        foreach ($this->keys as $key) {
            $command .= ' ' . $key;
        }

        $command .= BaseCommand::NLCR;

        return $command;
    }

    public function getSuccessResponseToken(): string
    {
        return 'END';
    }
}
