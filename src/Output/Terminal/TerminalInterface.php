<?php declare(strict_types=1);

namespace Qlimix\Cli\Output\Terminal;

use Qlimix\Cli\Output\Terminal\Exception\TerminalException;

interface TerminalInterface
{
    /**
     * @throws TerminalException
     */
    public function getSize(): Size;
}
