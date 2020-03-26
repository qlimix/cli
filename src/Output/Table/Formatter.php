<?php declare(strict_types=1);

namespace Qlimix\Cli\Output\Table;

use Qlimix\Cli\Output\Table\Calculator\Size;
use Qlimix\Cli\Output\Table\Decorator\DecoratorInterface;
use function implode;

final class Formatter
{
    private Row $header;

    /** @var Row[] */
    private array $rows;

    private DecoratorInterface $decorator;

    private Size $size;

    /**
     * @param Row[] $rows
     */
    public function __construct(Row $header, array $rows, DecoratorInterface $decorator, Size $size)
    {
        $this->header = $header;
        $this->rows = $rows;
        $this->decorator = $decorator;
        $this->size = $size;
    }

    public function draw(): string
    {
        $start = $this->decorator->getLine($this->size->getTotalSize(), $this->header->count());
        $lines = [];
        $lines[] = $start;
        $lines[] = $this->decorator->headers($this->header, $this->size);
        $lines[] = $start;

        foreach ($this->rows as $row) {
            $lines[] = $this->decorator->row($row, $this->size);
        }

        $lines[] = $start;

        return implode("\n", $lines)."\n";
    }
}
