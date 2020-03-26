<?php declare(strict_types=1);

namespace Qlimix\Cli\Command\Registry;

use Qlimix\Cli\Command\Command;
use Qlimix\Cli\Command\Registry\Exception\NotFoundException;
use Qlimix\Cli\Command\Registry\Exception\NotUniqueException;

final class Registry implements RegistryInterface
{
    /** @var Command[] */
    private array $commands = [];

    /**
     * @inheritDoc
     */
    public function register(Command $command): void
    {
        foreach ($this->commands as $registeredProcess) {
            if ($command->equals($registeredProcess)) {
                throw new NotUniqueException('Command name already registered');
            }
        }

        $this->commands[] = $command;
    }

    /**
     * @inheritDoc
     */
    public function get(string $name): Command
    {
        foreach ($this->commands as $command) {
            if ($command->getName()->toString() === $name) {
                return $command;
            }
        }

        throw new NotFoundException('Command '.$name.' not found');
    }

    /**
     * @inheritDoc
     */
    public function getCommands(): array
    {
        return $this->commands;
    }
}
