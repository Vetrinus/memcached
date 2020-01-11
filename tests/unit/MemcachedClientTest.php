<?php

use Cache\IntegrationTests\SimpleCacheTest;
use vetrinus\memcached\MemcachedClient;

class MemcachedClientTest extends SimpleCacheTest
{
    public function createSimpleCache()
    {
        return new MemcachedClient();
    }
}
