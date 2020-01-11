<?php

use Cache\IntegrationTests\SimpleCacheTest;
use vetrinus\memcached\ClientFactory;

class MemcachedClientTest extends SimpleCacheTest
{

    protected $skippedTests = [
        'testBasicUsageWithLongKey'    => 'Too much for memcached default settings',
        'testGetMultipleWithGenerator' => 'TODO',
        'testBinaryData'               => 'TODO',
    ];

    public function createSimpleCache()
    {
        $factory = new ClientFactory();

        return $factory->createByDomainAndPort('localhost');
    }
}
