<?php

namespace vetrinus\memcached;

use DateInterval;
use DateTime;
use Generator;
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
                if ($expiration <= 0) {
                    return time() - 1;
                }

                return $expiration;
            case $expiration instanceof DateInterval:
                $now = new DateTime();
                $now->add($expiration);

                return $now->getTimestamp();
            default:
                throw new InvalidArgumentException(
                    sprintf('Invalid expiration type: %s', gettype($expiration))
                );
        }
    }

    protected function processKey($key): string
    {
        if (is_string($key)) {
            if (is_numeric($key)) {
                return (int)$key;
            }

            if (!empty($key)) {
                if (preg_match('/\\\\|{|}|@|:/m', $key) === 1) {
                    throw new InvalidArgumentException('forbidden character detected');
                }

                return $key;
            }
        }

        if (is_integer($key)) {
            return $key;
        }

        throw new InvalidArgumentException(
            sprintf('Invalid key type: %s', gettype($key))
        );
    }
}
