<?php declare(strict_types=1);

namespace Qlimix\Tests\Cli\Command\Registry;

use PHPUnit\Framework\TestCase;
use Qlimix\Cli\Command\Command;
use Qlimix\Cli\Command\CommandInterface;
use Qlimix\Cli\Command\Name;
use Qlimix\Cli\Command\Registry\Exception\NotFoundException;
use Qlimix\Cli\Command\Registry\Exception\NotUniqueException;
use Qlimix\Cli\Command\Registry\Registry;

final class RegistryTest extends TestCase
{
    private Registry $registry;

    protected function setUp(): void
    {
        $this->registry = new Registry();
    }

    public function testShouldRegister(): void
    {
        $name = new Name('test');
        $commandExec = $this->createMock(CommandInterface::class);

        $command = new Command($name, 'default', $commandExec, [], []);

        $this->registry->register($command);

        $this->assertSame($command, $this->registry->get($name));
        $this->assertSame($command, $this->registry->getCommands()[0]);
    }

    public function testShouldThrowOnNotUniqueCommand(): void
    {
        $name = new Name('test');
        $commandExec = $this->createMock(CommandInterface::class);

        $command = new Command($name, 'default', $commandExec, [], []);

        $this->registry->register($command);
        $this->expectException(NotUniqueException::class);
        $this->registry->register($command);
    }

    public function testShouldThrowOnNotFoundCommand(): void
    {
        $this->expectException(NotFoundException::class);
        $this->registry->get(new Name('test'));
    }
}
