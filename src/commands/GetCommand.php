<?php

namespace vetrinus\memcached\commands;

use vetrinus\memcached\BaseCommand;

class GetCommand extends BaseCommand
{
    /** @var string */
    private $key;

    /**
     * DeleteCommand constructor.
     * @param string $key
     */
    public function __construct($key)
    {
        $this->key = $this->processKey($key);
    }

    public function represent(): string
    {
        return 'get ' . $this->key . BaseCommand::NLCR;
    }

    public function getSuccessResponseToken(): string
    {
        return 'END';
    }
}
