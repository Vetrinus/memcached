<?php

namespace vetrinus\memcached\commands;

use vetrinus\memcached\BaseCommand;

class DeleteCommand extends BaseCommand
{
    /** @var string */
    private $key;

    /**
     * DeleteCommand constructor.
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->key = $this->processKey($key);
    }


    public function represent(): string
    {
        return 'delete ' . $this->key . BaseCommand::NLCR;
    }

    public function getSuccessResponseToken(): string
    {
        return 'DELETED';
    }
}
