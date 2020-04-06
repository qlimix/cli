<?php declare(strict_types=1);

namespace Qlimix\Cli\Command\Input\Parser;

use Qlimix\Cli\Command\Command;
use Qlimix\Cli\Command\Input\Cli\Argument;
use Qlimix\Cli\Command\Input\Cli\Arguments;
use Qlimix\Cli\Command\Input\CommandInput;
use Qlimix\Cli\Command\Input\Input;
use Qlimix\Cli\Command\Input\InputArgument;
use Qlimix\Cli\Command\Input\InputInterface;
use Qlimix\Cli\Command\Input\InputOption;
use Qlimix\Cli\Command\Input\Parser\Exception\ArgumentsException;
use Qlimix\Cli\Command\Input\Parser\Exception\ParserException;
use Qlimix\Cli\Command\Option;
use Throwable;
use function array_merge;
use function array_shift;
use function count;
use function current;
use function preg_match;
use function str_split;
use function substr;

final class Parser implements ParserInterface
{
    private const OPTION_LONG_VALUE_REGEX = '^([a-zA-Z0-9\-\_]+)(?|\=["\']{1}(.*)["\']{1})$';

    private Arguments $arguments;

    public function __construct(Arguments $arguments)
    {
        $this->arguments = $arguments;
    }

    /**
     * @inheritDoc
     */
    public function parse(Command $command): InputInterface
    {
        $commandArguments = $command->getArguments();
        $commandOptions = $command->getOptions();

        $options = [];
        $arguments = [];
        $readFromInput = false;
        $processOptions = true;
        do {
            try {
                $argument = $this->arguments->next();
            } catch (Throwable $exception) {
                break;
            }

            switch ($argument) {
                case $argument->isReadInput():
                    $readFromInput = true;
                    break;
                case $argument->isNoMoreOptions():
                    $processOptions = false;
                    break;
                case $argument->isOption() && !$processOptions:
                    break;
                case $argument->isLongOption():
                    $options[] = $this->parseLongOption($argument, $commandOptions);
                    break;
                case $argument->isShortOption():
                    $options = array_merge($options, $this->parseShortOption($argument, $commandOptions));
                    break;
                default:
                    $arguments[] = $this->parseArgument($argument, $commandArguments);
            }
        } while (true);

        return new CommandInput($command, new Input($arguments, $options, $readFromInput));
    }

    /**
     * @param Option[] $options
     *
     * @return InputOption[]
     *
     * @throws ParserException
     */
    private function parseShortOption(Argument $cliArgument, array &$options): array
    {
        $shortOptions = str_split($cliArgument->toString());
        array_shift($shortOptions);

        if (count($shortOptions) === 1) {
            return [$this->shortOption($shortOptions[0], $options, true)];
        }

        $foundShortOptions = [];
        foreach ($shortOptions as $shortOption) {
            $foundShortOptions[] = $this->shortOption($shortOption, $options, false);
        }

        return $foundShortOptions;
    }

    /**
     * @param Option[] $options
     *
     * @throws ParserException
     */
    private function shortOption(string $cliArgument, array &$options, bool $checkValue): InputOption
    {
        foreach ($options as $index => $option) {
            if ($option->getShort() !== $cliArgument) {
                continue;
            }

            $value = null;
            if ($checkValue) {
                $value = $this->parseOptionValue($option);
            }

            if (!$option->isArray()) {
                unset($options[$index]);
            }

            return new InputOption($option, $value);
        }

        throw new ParserException('didn\'t find an matching short option');
    }

    /**
     * @param Option[] $options
     *
     * @throws ParserException
     */
    private function parseLongOption(Argument $cliArgument, array &$options): InputOption
    {
        $longOption = substr($cliArgument->toString(), 2);

        $matches = [];
        $value = null;
        if (preg_match('~'.self::OPTION_LONG_VALUE_REGEX.'~', $longOption, $matches)) {
            $longOption = $matches[1];
            $value = $matches[2];
        }

        $matchedOption = null;
        $matchedIndex = null;
        foreach ($options as $index => $option) {
            if ($option->getName() === $longOption) {
                $matchedOption = $option;
                $matchedIndex = $index;
                break;
            }
        }

        if ($matchedOption === null) {
            throw new ParserException('didn\'t find an matching long option');
        }

        if ($value === null) {
            $value = $this->parseOptionValue($matchedOption);
        }

        if (!$matchedOption->isArray()) {
            unset($options[$matchedIndex]);
        }

        return new InputOption($matchedOption, $value);
    }

    private function parseOptionValue(Option $option): ?string
    {
        $value = null;
        if (!$option->getValue()->has()) {
            return $value;
        }

        try {
            if ($this->arguments->peek()->isOptionValue()) {
                $value = $this->arguments->next()->toString();
            } else {
                $value = $option->getValue()->getDefault();
            }
        } catch (ArgumentsException $exception) {
            return null;
        }

        return $value;
    }

    /**
     * @param \Qlimix\Cli\Command\Argument[] $arguments
     *
     * @throws ParserException
     */
    private function parseArgument(Argument $cliArgument, array &$arguments): InputArgument
    {
        $argument = current($arguments);
        if ($argument === false) {
            throw new ParserException('No more arguments left to find');
        }

        $argCount = count($arguments);

        if ($argCount > 1 || ($argCount === 1 && !$argument->isArray())) {
            array_shift($arguments);
        }

        return new InputArgument($argument, $cliArgument->toString());
    }
}
