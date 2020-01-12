<?php

namespace vetrinus\memcached\processors;

use DateInterval;
use DateTime;
use vetrinus\memcached\exceptions\InvalidArgumentException;

class ArgumentsProcessor
{
    public function sanitizeKey($key): string
    {
        if (is_string($key)) {
            if (is_numeric($key)) {
                return $key;
            }

            if (!empty($key)) {
                return $key;
            }
        }

        throw new InvalidArgumentException(
            sprintf('Invalid key type: %s', gettype($key))
        );
    }

    public function sanitizeValue($value)
    {
        if (is_resource($value)) {
            throw new InvalidArgumentException('Resourse is not serializable type');
        }

        return $value;
    }

    public function sanitizeTtl($ttl): int
    {
        switch (true) {
            case is_null($ttl):
                return 0;
            case is_integer($ttl):
                if ($ttl <= 0) {
                    return time() - 1;
                }

                return $ttl;
            case $ttl instanceof DateInterval:
                $now = new DateTime();
                $now->add($ttl);

                return $now->getTimestamp();
            default:
                throw new InvalidArgumentException(
                    sprintf('Invalid expiration type: %s', gettype($ttl))
                );
        }
    }
}
