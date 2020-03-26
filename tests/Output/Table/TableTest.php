<?php declare(strict_types=1);

namespace Qlimix\Tests\Cli\Output\Table;

use PHPUnit\Framework\TestCase;
use Qlimix\Cli\Output\Table\Calculator\AutoResizingCalculator;
use Qlimix\Cli\Output\Table\Calculator\CalculatorInterface;
use Qlimix\Cli\Output\Table\Calculator\Exception\CalculatorException;
use Qlimix\Cli\Output\Table\Calculator\SimpleCalculator;
use Qlimix\Cli\Output\Table\Decorator\DecoratorInterface;
use Qlimix\Cli\Output\Table\Decorator\SimpleDecorator;
use Qlimix\Cli\Output\Table\Exception\TableException;
use Qlimix\Cli\Output\Table\Table;
use Qlimix\Cli\Output\Terminal\Size;
use Qlimix\Cli\Output\Terminal\TerminalInterface;

final class TableTest extends TestCase
{
    public function testShouldDrawSimpleTable(): void
    {
        $calculator = new SimpleCalculator();
        $decorator = new SimpleDecorator('-');

        $table = new Table($calculator, $decorator);

        $tableDrawn = <<<TABLE
------------------------------------
- foo   - bar    - oof    - rab    -
------------------------------------
- test1 - test2  - test3  - test4  -
- test5 - test6  - test7  - test8  -
- test9 - test10 - test11 - test12 -
------------------------------------

TABLE;

        $this->assertSame(
            $tableDrawn,
            $table->draw(
                ['foo', 'bar', 'oof', 'rab'],
                [
                    ['test1', 'test2', 'test3', 'test4'],
                    ['test5', 'test6', 'test7', 'test8'],
                    ['test9', 'test10', 'test11', 'test12']
                ]
            )
        );
    }

    public function testShouldDrawAutoResizedTable(): void
    {
        $terminal = $this->createMock(TerminalInterface::class);
        $terminal->expects($this->once())
            ->method('getSize')
            ->willReturn(new Size(30, 100));

        $calculator = new AutoResizingCalculator($terminal, 2);
        $decorator = new SimpleDecorator('-');

        $table = new Table($calculator, $decorator);

        $tableDrawn = <<<TABLE
------------------------------
- foo - bar  - oof   - rab   -
------------------------------
- tes - test - test3 - test4 -
- tes - test - test7 - test8 -
- tes - test - test1 - test1 -
------------------------------

TABLE;

        $this->assertSame(
            $tableDrawn,
            $table->draw(
                ['foo', 'bar', 'oof', 'rab'],
                [
                    ['test1', 'test2', 'test3', 'test4'],
                    ['test5', 'test6', 'test7', 'test8'],
                    ['test9', 'test10', 'test11', 'test12']
                ]
            )
        );
    }

    public function testShouldThrowOnDrawEmptyHeaders(): void
    {
        $calculator = $this->createMock(CalculatorInterface::class);
        $decorator = $this->createMock(DecoratorInterface::class);

        $table = new Table($calculator, $decorator);

        $this->expectException(TableException::class);
        $table->draw([], []);
    }

    public function testShouldThrowOnCalculateException(): void
    {
        $calculator = $this->createMock(CalculatorInterface::class);
        $decorator = $this->createMock(DecoratorInterface::class);

        $calculator->expects($this->once())
            ->method('calculate')
            ->willThrowException(new CalculatorException());

        $table = new Table($calculator, $decorator);

        $this->expectException(TableException::class);
        $table->draw(['foo'], []);
    }
}
