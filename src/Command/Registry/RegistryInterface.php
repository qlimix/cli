<?php declare(strict_types=1);

namespace Qlimix\Cli\Command\Registry;

use Qlimix\Cli\Command\Command;
use Qlimix\Cli\Command\Registry\Exception\NotFoundException;
use Qlimix\Cli\Command\Registry\Exception\NotUniqueException;

interface RegistryInterface
{
    /**
     * @throws NotUniqueException
     */
    public function register(Command $command): void;

    /**
     * @throws NotFoundException
     */
    public function get(string $name): Command;

    /**
     * @return Command[]
     */
    public function getCommands(): array;
}
