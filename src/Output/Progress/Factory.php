<?php declare(strict_types=1);

namespace Qlimix\Cli\Output\Progress;

use Qlimix\Cli\Output\CursorInterface;
use Qlimix\Cli\Output\OutputInterface;
use Qlimix\Cli\Output\Progress\Decorator\DecoratorInterface;

final class Factory implements FactoryInterface
{
    private OutputInterface $output;

    private DecoratorInterface $decorator;

    private CursorInterface $cursor;

    public function __construct(OutputInterface $output, DecoratorInterface $decorator, CursorInterface $cursor)
    {
        $this->output = $output;
        $this->decorator = $decorator;
        $this->cursor = $cursor;
    }

    public function create(int $total): ProgressInterface
    {
        return new Progress($this->output, $this->decorator, $this->cursor, $total);
    }
}
