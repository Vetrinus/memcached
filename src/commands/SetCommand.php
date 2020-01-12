<?php

namespace vetrinus\memcached\commands;

class SetCommand extends BaseCommand
{
    /** @var string */
    private $key;

    /** @var mixed */
    private $value;

    /** @var int */
    private $expiration;

    /**
     * SetCommand constructor.
     * @param       $key
     * @param mixed $value
     * @param int   $expiration
     */
    public function __construct(string $key, $value, int $expiration)
    {
        $this->key = $key;
        $this->value = $value;
        $this->expiration = $expiration;
    }

    public function represent(): string
    {
        $serialized = serialize($this->value);

        return sprintf(
            'set %s 0 %d %d%s%s%s',
            $this->key,
            $this->expiration,
            strlen($serialized),
            BaseCommand::NLCR,
            $serialized,
            BaseCommand::NLCR
        );
    }

    public function getExpiration(): int
    {
        return $this->expiration;
    }

    public function getSuccessResponseToken(): string
    {
        return 'STORED';
    }
}
