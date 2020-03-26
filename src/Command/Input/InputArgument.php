<?php declare(strict_types=1);

namespace Qlimix\Cli\Command\Input;

use Qlimix\Cli\Command\Argument;

final class InputArgument
{
    private Argument $argument;

    private string $value;

    public function __construct(Argument $argument, string $value)
    {
        $this->argument = $argument;
        $this->value = $value;
    }

    public function isArgument(Argument $argument): bool
    {
        return $argument->getName() === $this->argument->getName();
    }

    public function getArgument(): Argument
    {
        return $this->argument;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
