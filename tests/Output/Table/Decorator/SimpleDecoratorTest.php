<?php declare(strict_types=1);

namespace Qlimix\Tests\Cli\Output\Table\Decorator;

use PHPUnit\Framework\TestCase;
use Qlimix\Cli\Output\Table\Calculator\Size;
use Qlimix\Cli\Output\Table\Column;
use Qlimix\Cli\Output\Table\Decorator\SimpleDecorator;
use Qlimix\Cli\Output\Table\Row;

final class SimpleDecoratorTest extends TestCase
{
    public function testShouldDecorate(): void
    {
        $simple = new SimpleDecorator('-');

        $row = new Row([
            new Column('foo'),
            new Column('foobar'),
        ]);

        $this->assertSame('- foo    - foobar     -', $simple->row($row, new Size([6, 10])));
        $this->assertSame('- foo    - foobar     -', $simple->headers($row, new Size([6, 10])));
        $this->assertSame('-----------------------', $simple->getLine(16, 2));
    }

    public function testShouldDecorateWithEmptySeparator(): void
    {
        $simple = new SimpleDecorator('');

        $row = new Row([
            new Column('foo'),
            new Column('foobar'),
        ]);

        $this->assertSame('foo     foobar    ', $simple->row($row, new Size([6, 10])));
        $this->assertSame('foo     foobar    ', $simple->headers($row, new Size([6, 10])));
        $this->assertSame('                    ', $simple->getLine(16, 2));
    }
}
