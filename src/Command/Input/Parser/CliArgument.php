<?php declare(strict_types=1);

namespace Qlimix\Cli\Command\Input\Parser;

use function strlen;
use function strpos;

final class CliArgument
{
    private const INPUT_READ_TOKEN = '-';
    private const NO_MORE_OPTIONS_TOKEN = '--';

    private string $argument;

    public function __construct(string $argument)
    {
        $this->argument = $argument;
    }

    public function toString(): string
    {
        return $this->argument;
    }

    public function isOption(): bool
    {
        return $this->isLongOption() || $this->isShortOption();
    }

    public function isShortOption(): bool
    {
        return strlen($this->argument) >= 2
            && strpos($this->argument, '-') === 0
            && strpos($this->argument, '-', 1) === false;
    }

    public function isLongOption(): bool
    {
        return strpos($this->argument, '--') === 0;
    }

    public function isReadInput(): bool
    {
        return $this->argument === self::INPUT_READ_TOKEN;
    }

    public function isNoMoreOptions(): bool
    {
        return $this->argument === self::NO_MORE_OPTIONS_TOKEN;
    }

    public function isOptionValue(): bool
    {
        return !$this->isLongOption()
            && !$this->isShortOption()
            && !$this->isReadInput()
            && !$this->isNoMoreOptions();
    }
}
