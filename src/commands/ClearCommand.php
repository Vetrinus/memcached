<?php

namespace vetrinus\memcached\commands;

use vetrinus\memcached\BaseCommand;

class ClearCommand extends BaseCommand
{
    public function represent(): string
    {
        return 'flush_all' . BaseCommand::NLCR;
    }

    public function getSuccessResponseToken(): string
    {
        return 'OK';
    }
}
