<?php declare(strict_types=1);

namespace Qlimix\Cli\Command\Input;

use Qlimix\Cli\Command\Argument;
use Qlimix\Cli\Command\Option;

final class Input
{
    /** @var InputArgument[] */
    private array $arguments;

    /** @var InputOption[] */
    private array $options;

    private bool $readFromInput;

    /**
     * @param InputArgument[] $arguments
     * @param InputOption[] $options
     */
    public function __construct(array $arguments, array $options, bool $readFromInput)
    {
        $this->arguments = $arguments;
        $this->options = $options;
        $this->readFromInput = $readFromInput;
    }

    public function hasArgument(Argument $argument): bool
    {
        foreach ($this->arguments as $inputArgument) {
            if ($inputArgument->isArgument($argument)) {
                return true;
            }
        }

        return false;
    }

    public function hasOptionWithValue(Option $option): bool
    {
        foreach ($this->options as $inputOption) {
            if ($inputOption->isOption($option) && $inputOption->getValue() !== null) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return InputArgument[]
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * @return InputOption[]
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    public function isReadFromInput(): bool
    {
        return $this->readFromInput;
    }
}
