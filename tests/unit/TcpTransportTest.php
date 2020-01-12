<?php

use Codeception\Test\Unit;
use vetrinus\memcached\transport\TcpTransport;

class TcpTransportTest extends Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    // tests
    public function testExchange()
    {
        $transport = new TcpTransport('localhost', 11211);

        $command = 'get key' . "\r\n";
        $this->tester->assertEquals($transport->transmit($command), strlen($command));
        $response = 'END' . "\r\n";
        $this->tester->assertEquals($response, $transport->read(2048));
    }

    public function testInvalidConstructorParams()
    {
        $this->tester->expectThrowable(
            new RuntimeException('fsockopen(): unable to connect to localhost:11210 (Connection refused)', 2),
            function () {
                new TcpTransport('localhost', 11210);
            }
        );
    }
}
