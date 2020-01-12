<?php

namespace vetrinus\memcached\commands;

class GetMultipleCommand extends BaseCommand
{
    /** @var string[] */
    private $keys = [];

    public function __construct($keys)
    {
        $this->keys = $keys;
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
