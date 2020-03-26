<?php declare(strict_types=1);

namespace Qlimix\Tests\Cli\Output\Table;

use PHPUnit\Framework\TestCase;
use Qlimix\Cli\Output\Table\Column;

final class ColumnTest extends TestCase
{
    public function testShouldDrawWithAddedSpaces(): void
    {
        $value = 'foo';
        $column = new Column($value);

        $this->assertSame($value.' ', $column->draw(4));
    }

    public function testShouldDrawWithRemovedValueContent(): void
    {
        $column = new Column('foo');

        $this->assertSame('fo', $column->draw(2));
    }
}
