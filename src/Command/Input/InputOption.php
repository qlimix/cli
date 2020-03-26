<?php declare(strict_types=1);

namespace Qlimix\Cli\Command\Input;

use Qlimix\Cli\Command\Option;

final class InputOption
{
    private Option $option;

    private ?string $value;

    public function __construct(Option $option, ?string $value)
    {
        $this->option = $option;
        $this->value = $value;
    }

    public function isOption(Option $option): bool
    {
        return $option->getName() === $this->option->getName();
    }

    public function getOption(): Option
    {
        return $this->option;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }
}
