<?php

namespace vetrinus\memcached\commands;

class GetCommand extends BaseCommand
{
    /** @var string */
    private $key;

    /**
     * DeleteCommand constructor.
     * @param $key
     */
    public function __construct(string $key)
    {
        $this->key = $key;
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
