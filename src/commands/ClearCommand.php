<?php

namespace vetrinus\memcached\commands;

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
