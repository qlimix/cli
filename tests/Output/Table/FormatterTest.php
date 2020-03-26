<?php declare(strict_types=1);

namespace Qlimix\Tests\Cli\Output\Table;

use PHPUnit\Framework\TestCase;
use Qlimix\Cli\Output\Table\Calculator\Size;
use Qlimix\Cli\Output\Table\Column;
use Qlimix\Cli\Output\Table\Decorator\DecoratorInterface;
use Qlimix\Cli\Output\Table\Row;
use Qlimix\Cli\Output\Table\Formatter;

final class FormatterTest extends TestCase
{
    public function testShouldFormat(): void
    {
        $header = new Row([
           new Column('foo'),
           new Column('bar'),
           new Column('oof'),
           new Column('rab'),
        ]);

        $rows = [
            new Row([
                new Column('test1'),
                new Column('test2'),
                new Column('test3'),
                new Column('test4'),
            ]),
            new Row([
                new Column('test5'),
                new Column('test6'),
                new Column('test7'),
                new Column('test8'),
            ]),
            new Row([
                new Column('test9'),
                new Column('test10'),
                new Column('test11'),
                new Column('test12'),
            ]),
        ];

        $decorator = $this->createMock(DecoratorInterface::class);

        $decorator->expects($this->once())
            ->method('getLine');

        $decorator->expects($this->once())
            ->method('headers');

        $decorator->expects($this->exactly(3))
            ->method('row');

        $formatter = new Formatter($header, $rows, $decorator, new Size([5, 5, 5, 6]));

        $formatter->draw();
    }
}
