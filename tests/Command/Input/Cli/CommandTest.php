<?php declare(strict_types=1);

namespace Qlimix\Tests\Cli\Command\Input\Cli;

use PHPUnit\Framework\TestCase;
use Qlimix\Cli\Command\Input\Cli\Command;

final class CommandTest extends TestCase
{
    public function testShouldCommand(): void
    {
        $name = 'test';
        $command = new Command($name);

        $this->assertSame($name, $command->getCommand());
    }
}
