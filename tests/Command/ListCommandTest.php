<?php declare(strict_types=1);

namespace Qlimix\Tests\Cli\Command;

use PHPUnit\Framework\TestCase;
use Qlimix\Cli\Command\Command;
use Qlimix\Cli\Command\CommandInterface;
use Qlimix\Cli\Command\Exception\ExecutionException;
use Qlimix\Cli\Command\Input\InputInterface;
use Qlimix\Cli\Command\ListCommand;
use Qlimix\Cli\Command\Name;
use Qlimix\Cli\Command\Registry\RegistryInterface;
use Qlimix\Cli\Output\Exception\OutputException;
use Qlimix\Cli\Output\OutputInterface;

final class ListCommandTest extends TestCase
{
    public function testShouldList(): void
    {
        $registry = $this->createMock(RegistryInterface::class);
        $output = $this->createMock(OutputInterface::class);
        $commandInput = $this->createMock(InputInterface::class);

        $registry->expects($this->once())
            ->method('getCommands')
            ->willReturn([
                    new Command(
                        new Name('Foo'),
                        'Foo description',
                        $this->createMock(CommandInterface::class),
                    [],
                    []
                ),
                    new Command(
                        new Name('Bar'),
                        'Bar description',
                        $this->createMock(CommandInterface::class),
                    [],
                    []
                ),
            ]);

        $listCommand = new ListCommand($registry, $output);

        $expected = <<<OUTPUT
Command list:
Foo
	Foo description
Bar
	Bar description
OUTPUT;

        $result = null;

        $output->expects($this->once())
            ->method('writeLine')
            ->with($this->callback(function (string $output) use (&$result): bool {
                $result = $output;
                return true;
            }));

        $listCommand->execute($commandInput);

        $this->assertSame($expected, $result);
    }

    public function testShouldThrowOnOutputException(): void
    {
        $registry = $this->createMock(RegistryInterface::class);
        $output = $this->createMock(OutputInterface::class);
        $commandInput = $this->createMock(InputInterface::class);

        $registry->expects($this->once())
            ->method('getCommands')
            ->willReturn([]);

        $listCommand = new ListCommand($registry, $output);

        $output->expects($this->once())
            ->method('writeLine')
            ->willThrowException(new OutputException());

        $this->expectException(ExecutionException::class);
        $listCommand->execute($commandInput);
    }
}
