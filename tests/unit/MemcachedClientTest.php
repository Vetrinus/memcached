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

    /**
     * @return array
     * Memcached allow to use as a key a part of parent::invalidArrayKeys()
     */
    public static function invalidArrayKeys()
    {
        return [
            [''],
            [true],
            [false],
            [null],
            [2.5],
            [new \stdClass()],
            [['array']],
        ];
    }

    public static function invalidKeys()
    {
        return array_merge(
            self::invalidArrayKeys(),
            [
                [2],
            ]
        );
    }

    public function createSimpleCache()
    {
        $factory = new ClientFactory();

        return $factory->createByDomainAndPort('localhost');
    }
}
