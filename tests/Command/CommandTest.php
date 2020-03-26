<?php declare(strict_types=1);

namespace Qlimix\Tests\Cli\Command;

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
        $name = new Name('default');
        $description = 'default';

        $argument = new Argument('foo', 'foo', true, false);

        $option = new Option(
            'verbose',
            'v',
            'verbose',
            new Value(false, false, ''),
            false
        );

        $mockCommand = $this->createMock(CommandInterface::class);

        $command = new Command(
            $name,
            $description,
            $mockCommand,
            [$argument],
            [$option]
        );

        $this->assertSame($name->toString(), $command->getName()->toString());
        $this->assertSame($description, $command->getDescription());
        $this->assertSame($argument, $command->getArguments()[0]);
        $this->assertSame($option, $command->getOptions()[0]);
        $this->assertSame($mockCommand, $command->getCommand());
        $this->assertTrue($command->equals($command));
    }
}
