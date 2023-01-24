<?php

namespace App\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class ParserCommandTest extends KernelTestCase
{
    public function testExecute()
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('app:parser');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'uri' => 'http://127.0.0.1:8000/products.xml'
        ]);

        $commandTester->assertCommandIsSuccessful();
    }
}