<?php

namespace vetrinus\memcached;

use DateInterval;
use DateTime;
use vetrinus\memcached\exceptions\InvalidArgumentException;

abstract class BaseCommand
{
    public const NLCR = "\r\n";

    abstract public function represent(): string;

    abstract public function getSuccessResponseToken(): string;

    protected function processExpiration($expiration): int
    {
        switch (true) {
            case is_null($expiration):
                return 0;
            case is_integer($expiration):
                return $expiration;
            case $expiration instanceof DateInterval:
                $now = new DateTime();
                $now->add($expiration);

                return $now->getTimestamp();
            default:
                throw new InvalidArgumentException(gettype($expiration));
        }
    }

    protected function processKey($key): string
    {
        if (is_string($key) && !empty($key)) {
            return $key;
        }

        throw new InvalidArgumentException(gettype($key));
    }
}
