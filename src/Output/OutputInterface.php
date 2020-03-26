<?php declare(strict_types=1);

namespace Qlimix\Cli\Output;

use Qlimix\Cli\Output\Exception\OutputException;

interface OutputInterface
{
    /**
     * @throws OutputException
     */
    public function write(string $text): void;

    /**
     * @throws OutputException
     */
    public function writeLine(string $text): void;
}
