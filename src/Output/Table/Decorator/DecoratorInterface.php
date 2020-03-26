<?php declare(strict_types=1);

namespace Qlimix\Cli\Output\Table\Decorator;

use Qlimix\Cli\Output\Table\Calculator\Size;
use Qlimix\Cli\Output\Table\Row;

interface DecoratorInterface
{
    public function row(Row $row, Size $size): string;

    public function headers(Row $row, Size $size): string;

    public function getLine(int $repeat, int $columns): string;

    public function getColumnSeparatorSize(): int;

    public function getSeparatorSize(): int;
}
