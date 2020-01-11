<?php

use Cache\IntegrationTests\SimpleCacheTest;
use vetrinus\memached\MemcachedClient;

class MemcachedClientTest extends SimpleCacheTest
{
    public function createSimpleCache()
    {
        return new MemcachedClient();
    }
}
