<?php declare(strict_types=1);

namespace Qlimix\Tests\Cli\Output\Table;

use PHPUnit\Framework\TestCase;
use Qlimix\Cli\Output\Table\Column;
use Qlimix\Cli\Output\Table\Row;
use function count;

final class RowTest extends TestCase
{
    public function testShouldRow(): void
    {
        $columns = [
            new Column('foo', 4),
            new Column('bar', 4),
        ];

        $row = new Row($columns);

        $rowColumns = $row->getColumns();

        $this->assertSame($columns[0], $rowColumns[0]);
        $this->assertSame($columns[1], $rowColumns[1]);
        $this->assertSame(count($columns), $row->count());
    }
}
