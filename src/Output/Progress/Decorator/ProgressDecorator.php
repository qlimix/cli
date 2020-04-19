<?php declare(strict_types=1);

namespace Qlimix\Cli\Output\Progress\Decorator;

use Qlimix\Cli\Output\Progress\Decorator\Exception\DecoratorException;
use Qlimix\Cli\Output\Terminal\TerminalInterface;
use Throwable;
use function floor;
use function str_repeat;

final class ProgressDecorator implements DecoratorInterface
{
    private const START = '[';
    private const END = ']';
    private const PROGRESS = '-';
    private const POINTER = '>';

    private TerminalInterface $terminal;

    public function __construct(TerminalInterface $terminal)
    {
        $this->terminal = $terminal;
    }

    /**
     * @inheritDoc
     */
    public function decorate(int $progress): array
    {
        try {
            $size = $this->terminal->getSize();
        } catch (Throwable $exception) {
            throw new DecoratorException('Failed to get terminal size', 0, $exception);
        }

        $progressBarSize = $size->getWidth() - 3;
        if ($progress > 0) {
            $progressDraw = (int) floor($progress * $progressBarSize / 100);
        } else {
            $progressDraw = 0;
        }

        $todoDraw = (int) floor($progressBarSize - $progressDraw);

        $progressDraw = $progressDraw > 0 ? str_repeat(self::PROGRESS, $progressDraw) : '';
        $todoDraw = $todoDraw > 0 ? str_repeat(' ', $todoDraw) : '';

        return [
            self::START
            .$progressDraw
            .self::POINTER
            .$todoDraw
            .self::END,
        ];
    }
}
