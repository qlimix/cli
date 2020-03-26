<?php declare(strict_types=1);

namespace Qlimix\Cli\Output\Progress;

use Qlimix\Cli\Output\CursorInterface;
use Qlimix\Cli\Output\OutputInterface;
use Qlimix\Cli\Output\Progress\Decorator\DecoratorInterface;
use Qlimix\Cli\Output\Progress\Exception\ProgressException;
use Throwable;
use function count;
use function floor;
use function implode;

final class Progress implements ProgressInterface
{
    private OutputInterface $output;

    private DecoratorInterface $decorator;

    private CursorInterface $cursor;

    private int $total;

    private int $lines = 0;

    private bool $drawn = false;

    public function __construct(
        OutputInterface $output,
        DecoratorInterface $decorator,
        CursorInterface $cursor,
        int $total
    ) {
        $this->output = $output;
        $this->decorator = $decorator;
        $this->cursor = $cursor;
        $this->total = $total;
    }

    /**
     * @inheritDoc
     */
    public function progress(int $progress): void
    {
        if ($progress > 0) {
            $progress = (int) floor($progress * 100 / $this->total);
        }

        try {
            $progressBar = $this->decorator->decorate($progress);
        } catch (Throwable $exception) {
            throw new ProgressException('Failed to decorate progress', 0, $exception);
        }

        $this->lines = count($progressBar);
        if ($this->drawn) {
            $this->cursor->clearLines($this->lines);
        } else {
            $this->cursor->hide();
        }

        if ($progress === 100) {
            $this->cursor->show();
        }

        $this->drawn = true;
        try {
            $this->output->writeLine(implode("\n", $progressBar));
        } catch (Throwable $exception) {
            throw new ProgressException('Failed to output progress', 0, $exception);
        }
    }
}
