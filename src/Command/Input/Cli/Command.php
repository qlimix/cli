<?php declare(strict_types=1);

namespace Qlimix\Cli\Command\Input\Cli;

final class Command
{
    private string $command;

    public function __construct(string $command)
    {
        $this->command = $command;
    }

    public function getCommand(): string
    {
        return $this->command;
    }
}
