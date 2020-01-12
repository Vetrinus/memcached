<?php

namespace vetrinus\memcached\commands;

use vetrinus\memcached\BaseCommand;

class DeleteCommand extends BaseCommand
{
    /** @var string */
    private $key;

    /**
     * DeleteCommand constructor.
     * @param $key
     */
    public function __construct($key)
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
