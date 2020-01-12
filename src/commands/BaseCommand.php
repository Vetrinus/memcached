<?php

namespace vetrinus\memcached\commands;

abstract class BaseCommand
{
    public const NLCR = "\r\n";

    abstract public function represent(): string;

    abstract public function getSuccessResponseToken(): string;
}
