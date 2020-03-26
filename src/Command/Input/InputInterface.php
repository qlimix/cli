<?php declare(strict_types=1);

namespace Qlimix\Cli\Command\Input;

use Qlimix\Cli\Command\Input\Exception\ArgumentNotFoundException;
use Qlimix\Cli\Command\Input\Exception\OptionNotFoundException;

interface InputInterface
{
    /**
     * @throws ArgumentNotFoundException
     */
    public function getArgument(string $argument): string;

    /**
     * @return string[]
     *
     * @throws ArgumentNotFoundException
     */
    public function getArrayArguments(string $argument): array;

    /**
     * @throws OptionNotFoundException
     */
    public function getOption(string $option): string;

    public function isOptionFlagged(string $option): bool;

    /**
     * @return string[]
     *
     * @throws OptionNotFoundException
     */
    public function getArrayOptions(string $option): array;

    public function readFromInput(): bool;
}
