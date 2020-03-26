<?php declare(strict_types=1);

namespace Qlimix\Cli\Output\Table\Decorator;

use Qlimix\Cli\Output\Table\Calculator\Size;
use Qlimix\Cli\Output\Table\Row;
use function implode;
use function str_repeat;
use function strlen;

final class SimpleDecorator implements DecoratorInterface
{
    private string $separator;

    public function __construct(string $separator)
    {
        $this->separator = $separator;
    }

    public function row(Row $row, Size $size): string
    {
        $columns = [];
        foreach ($row->getColumns() as $column) {
            $columns[] = $column->draw($size->next());
        }

        $line = implode($this->getColumnSeparator(), $columns);

        return $this->getRowStart().$line.$this->getRowEnd();
    }

    public function headers(Row $row, Size $size): string
    {
        $columns = [];
        foreach ($row->getColumns() as $column) {
            $columns[] = $column->draw($size->next());
        }

        $line = implode($this->getColumnSeparator(), $columns);

        return $this->getRowStart().$line.$this->getRowEnd();
    }

    public function getLine(int $repeat, int $columns): string
    {
        $repeat += (($columns - 1 ) * $this->getColumnSeparatorSize()) + $this->getSeparatorSize();
        if ($this->isEmpty()) {
            return str_repeat(' ', $repeat);
        }

        return str_repeat($this->separator, $repeat);
    }

    public function getColumnSeparatorSize(): int
    {
        return strlen($this->getColumnSeparator());
    }

    public function getSeparatorSize(): int
    {
        return $this->isEmpty() ? 2 : 4;
    }

    private function getColumnSeparator(): string
    {
        return $this->separator === ' ' ? $this->separator : ' '.$this->separator.' ';
    }

    private function getRowStart(): string
    {
        if ($this->isEmpty()) {
            return '';
        }

        return $this->separator.' ';
    }

    private function getRowEnd(): string
    {
        if ($this->isEmpty()) {
            return '';
        }

        return ' '.$this->separator;
    }

    private function isEmpty(): bool
    {
        return $this->separator === '';
    }
}
