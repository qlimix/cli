<?php declare(strict_types=1);

namespace Qlimix\Cli\Output\Terminal;

use Qlimix\Cli\Output\Terminal\Exception\TerminalException;
use Throwable;
use function count;
use function exec;
use function explode;

final class SttyTerminal implements TerminalInterface
{
    /**
     * @inheritDoc
     */
    public function getSize(): Size
    {
        try {
            $size = explode(' ', exec('stty size'));
        } catch (Throwable $exception) {
            throw new TerminalException('Failed getting terminal size', 0, $exception);
        }

        if (count($size) !== 2) {
            throw new TerminalException('Failed getting terminal size');
        }

        return new Size((int) $size[1], (int) $size[0]);
    }
}
