<?php declare(strict_types=1);

namespace Qlimix\Cli\Output\Table;

use Qlimix\Cli\Output\Table\Exception\TableException;

interface TableInterface
{
    /**
     * @param array<int, string> $headers
     * @param array<int, array<int, string>>$values
     *
     * @throws TableException
     */
    public function draw(array $headers, array $values): string;
}
