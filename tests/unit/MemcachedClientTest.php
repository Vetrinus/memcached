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

    public function testDataTypeInteger()
    {
        $this->cache->set('key', 5);
        $result = $this->cache->get('key');
        $this->assertEquals(5, $result, 'Wrong data type. If we store an int we must get an int back.');
        $this->assertIsInt($result, 'Wrong data type. If we store an int we must get an int back.');
    }
}
