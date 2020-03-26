<?php declare(strict_types=1);

namespace Qlimix\Tests\Cli\Command\Input;

use PHPUnit\Framework\TestCase;
use Qlimix\Cli\Command\Argument;
use Qlimix\Cli\Command\Command;
use Qlimix\Cli\Command\CommandInterface;
use Qlimix\Cli\Command\Name;
use Qlimix\Cli\Command\Option;
use Qlimix\Cli\Command\Value;

final class CommandTest extends TestCase
{
    public function testShouldCommand(): void
    {
        $name = new Name('test');
        $commandExec = $this->createMock(CommandInterface::class);
        $arguments = [new Argument('test', 'foo', true, false)];
        $options = [new Option(
            'bar',
            'f',
            'bar',
            new Value(true, true, 'foo'),
            false
        )];

        $command = new Command($name, 'default', $commandExec, $arguments, $options);

        $this->assertSame($name->toString(), $command->getName()->toString());
        $this->assertSame($commandExec, $command->getCommand());
        $this->assertCount(count($arguments), $command->getArguments());
        $this->assertCount(count($options), $command->getOptions());
        $this->assertTrue($command->equals($command));
    }
}
