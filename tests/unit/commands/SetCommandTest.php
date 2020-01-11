<?php

namespace commands;

use vetrinus\memcached\BaseCommand;
use vetrinus\memcached\commands\SetCommand;

class SetCommandTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    // tests
    public function testPresentSuccess()
    {
        $command = new SetCommand('key', 'valueToSave');

        $mustBe = 'set key 0 0 19' . BaseCommand::NLCR . 's:11:"valueToSave";' . BaseCommand::NLCR;
        $this->tester->assertEquals($mustBe, $command->represent());
    }

    public function testExpiration()
    {
        $command = new SetCommand('key', 'valueToSave', 3600);

        $mustBe = 'set key 0 3600 19' . BaseCommand::NLCR . 's:11:"valueToSave";' . BaseCommand::NLCR;
        $this->tester->assertEquals($mustBe, $command->represent());
    }

    public function testSuccessToken()
    {
        $command = new SetCommand('key', 'valueToSave');

        $this->tester->assertEquals('STORED', $command->getSuccessResponseToken());
    }

    public function testDateInterval()
    {
        $command = new SetCommand('key', 'valueToSave', new \DateInterval('PT5S'));

        $this->tester->assertEquals(5, $command->getExpiration());
    }
}
