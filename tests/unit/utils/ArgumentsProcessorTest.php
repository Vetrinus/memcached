<?php

namespace utils;

use vetrinus\memcached\exceptions\InvalidArgumentException;
use vetrinus\memcached\processors\ArgumentsProcessor;

class ArgumentsProcessorTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;


    public static function validKeys()
    {
        return [
            ['AbC19_.'],
            ['1234567890123456789012345678901234567890123456789012345678901234'],
        ];
    }

    public static function invalidKeys()
    {
        return [
            [''],
            [true],
            [false],
            [null],
            [2.5],
            [new \stdClass()],
            [['array']],
            [2],
        ];
    }

    public static function invalidTtl()
    {
        return [
            [''],
            [true],
            [false],
            ['abc'],
            [2.5],
            [' 1'], // can be casted to a int
            ['12foo'], // can be casted to a int
            ['025'], // can be interpreted as hex
            [new \stdClass()],
            [['array']],
        ];
    }

    public static function validTtl()
    {
        return [
            [0, time()],
            [1, 1],
            [new \DateInterval('P1D'), time() + 3600 * 24],
            [null, 0],
        ];
    }

    public static function validData()
    {
        return [
            ['AbC19_.'],
            [4711],
            [47.11],
            [true],
            [null],
            [['key' => 'value']],
            [new \stdClass()],
        ];
    }


    /**
     * @param $key
     * @dataProvider invalidKeys
     */
    public function testInvalidKey($key)
    {
        $this->tester->expectThrowable(InvalidArgumentException::class, function () use ($key) {
            $this->getProcessor()->sanitizeKey($key);
        });
    }

    /**
     * @param $key
     * @dataProvider validKeys
     */
    public function testValidKey($key)
    {
        $this->tester->assertIsString($this->getProcessor()->sanitizeKey($key));
    }

    public function testInvalidValue()
    {
        $processor = $this->getProcessor();

        $this->tester->expectThrowable(InvalidArgumentException::class, function () use ($processor) {
            $processor->sanitizeValue(@fopen('https://google.com', 'r'));
        });
    }

    /**
     * @param $value
     * @dataProvider validData
     */
    public function testValidValue($value)
    {
        $this->tester->assertEquals($this->getProcessor()->sanitizeValue($value), $value);
    }


    /**
     * @param $ttl
     * @dataProvider invalidTtl
     */
    public function testInvalidTtl($ttl)
    {
        $this->tester->expectThrowable(InvalidArgumentException::class, function () use ($ttl) {
            $this->getProcessor()->sanitizeTtl($ttl);
        });
    }

    /**
     * @param $source
     * @param $result
     * @dataProvider validTtl
     */
    public function testValidTtl($source, $result)
    {
        $this->tester->assertEqualsWithDelta($this->getProcessor()->sanitizeTtl($source), $result, 20);
    }

    private function getProcessor(): ArgumentsProcessor
    {
        return new ArgumentsProcessor();
    }
}
