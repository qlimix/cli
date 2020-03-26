<?php declare(strict_types=1);

namespace Qlimix\Cli\Command\Input;

use Qlimix\Cli\Command\Command;
use Qlimix\Cli\Command\Input\Exception\ArgumentNotFoundException;
use Qlimix\Cli\Command\Input\Exception\OptionNotFoundException;
use function count;

final class CommandInput implements InputInterface
{
    private Command $command;

    private Input $input;

    public function __construct(Command $command, Input $input)
    {
        $this->command = $command;
        $this->input = $input;
    }

    /**
     * @inheritDoc
     */
    public function getArgument(string $argument): string
    {
        foreach ($this->input->getArguments() as $inputArgument) {
            if ($inputArgument->getArgument()->getName() === $argument) {
                return $inputArgument->getValue();
            }
        }

        throw new ArgumentNotFoundException('Could not find '.$argument);
    }

    /**
     * @inheritDoc
     */
    public function getArrayArguments(string $argument): array
    {
        $inputArguments = [];
        foreach ($this->input->getArguments() as $inputArgument) {
            if ($inputArgument->getArgument()->getName() !== $argument) {
                continue;
            }

            $inputArguments[] = $inputArgument->getValue();
        }

        if (count($inputArguments) === 0) {
            throw new ArgumentNotFoundException('Could not find '.$argument);
        }

        return $inputArguments;
    }

    /**
     * @inheritDoc
     */
    public function getOption(string $option): string
    {
        foreach ($this->input->getOptions() as $inputOption) {
            if ($inputOption->getValue() !== null && $inputOption->getOption()->getName() === $option) {
                return $inputOption->getValue();
            }
        }

        foreach ($this->command->getOptions() as $commandOption) {
            if ($commandOption->getName() === $option) {
                return $commandOption->getValue()->getDefault();
            }
        }

        throw new OptionNotFoundException('Could not find '.$option);
    }

    public function isOptionFlagged(string $option): bool
    {
        foreach ($this->input->getOptions() as $inputOption) {
            if ($inputOption->getValue() === null
                && $inputOption->getOption()->getName() === $option
                && !$inputOption->getOption()->getValue()->isRequired()
            ) {
                return true;
            }
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function getArrayOptions(string $option): array
    {
        $inputOptions = [];
        foreach ($this->input->getOptions() as $inputOption) {
            if ($inputOption->getOption()->getName() !== $option) {
                continue;
            }

            $value = $inputOption->getValue();
            if ($value === null) {
                continue;
            }

            $inputOptions[] = $inputOption->getValue();
        }

        if (count($inputOptions) === 0) {
            foreach ($this->command->getOptions() as $commandOption) {
                if ($commandOption->getName() === $option) {
                    $inputOptions[] = $commandOption->getValue()->getDefault();
                    break;
                }
            }
        }

        if (count($inputOptions) === 0) {
            throw new OptionNotFoundException('Could not find '.$option);
        }

        return $inputOptions;
    }

    public function readFromInput(): bool
    {
        return $this->input->isReadFromInput();
    }
}
