<?php

namespace vetrinus\memcached;

use Psr\SimpleCache\CacheInterface;
use vetrinus\memcached\processors\ArgumentsProcessor;
use vetrinus\memcached\transport\TcpTransport;
use vetrinus\memcached\transport\Transport;

class ClientFactory
{
    public const DEFAULT_MEMCACHED_PORT = 11211;

    public function createByDomainAndPort(string $domain, int $port = self::DEFAULT_MEMCACHED_PORT): CacheInterface
    {
        return $this->createByTransport(new TcpTransport($domain, $port));
    }

    public function createByTransport(Transport $transport): CacheInterface
    {
        return new MemcachedClient($transport, new ArgumentsProcessor());
    }
}
