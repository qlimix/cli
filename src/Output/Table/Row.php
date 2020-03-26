<?php declare(strict_types=1);

namespace Qlimix\Cli\Output\Table;

use function count;

final class Row
{
    /** @var Column[] */
    private array $columns;

    /**
     * @param Column[] $columns
     */
    public function __construct(array $columns)
    {
        $this->columns = $columns;
    }

    /**
     * @return Column[]
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    public function count(): int
    {
        return count($this->columns);
    }
}
