<?php

use Cache\IntegrationTests\SimpleCacheTest;
use vetrinus\memcached\ClientFactory;

class MemcachedClientTest extends SimpleCacheTest
{
    public function createSimpleCache()
    {
        $factory = new ClientFactory();

        return $factory->createByDomainAndPort('localhost');
    }
}
