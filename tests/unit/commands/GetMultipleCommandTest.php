<?php

namespace commands;

use vetrinus\memcached\BaseCommand;
use vetrinus\memcached\commands\GetMultipleCommand;

class GetMultipleCommandTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    // tests
    public function testSuccess()
    {
        $command = new GetMultipleCommand([
            'key1',
            'key2',
            'key-3',
        ]);

        $mustBe = 'get key1 key2 key-3' . BaseCommand::NLCR;

        $this->tester->assertEquals($mustBe, $command->represent());
    }
}
