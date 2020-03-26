<?php declare(strict_types=1);

namespace Qlimix\Tests\Cli\Output\Table\Calculator;

use PHPUnit\Framework\TestCase;
use Qlimix\Cli\Output\Table\Calculator\AutoResizingCalculator;
use Qlimix\Cli\Output\Table\Calculator\Exception\CalculatorException;
use Qlimix\Cli\Output\Terminal\Exception\TerminalException;
use Qlimix\Cli\Output\Terminal\Size;
use Qlimix\Cli\Output\Terminal\TerminalInterface;

final class AutoResizeCalculatorTest extends TestCase
{
    public function testShouldCalculateDecreasedColumns(): void
    {
        $terminal = $this->createMock(TerminalInterface::class);
        $terminal->expects($this->once())
            ->method('getSize')
            ->willReturn(new Size(23, 100));

        $autoResize = new AutoResizingCalculator($terminal, 2);

        $sizes = $autoResize->calculate([['foo', 'foobar', 'foobarfoobar']], 3, 2);
        $this->assertSame(2, $sizes->next());
        $this->assertSame(3, $sizes->next());
        $this->assertSame(10, $sizes->next());
        $this->assertSame(15, $sizes->getTotalSize());
    }

    public function testShouldCalculateDecreasedColumnsReachingMinColumnOnAllColumns(): void
    {
        $terminal = $this->createMock(TerminalInterface::class);
        $terminal->expects($this->once())
            ->method('getSize')
            ->willReturn(new Size(19, 100));

        $autoResize = new AutoResizingCalculator($terminal, 2);

        $sizes = $autoResize->calculate([['foo', 'foobar', 'foobarfoobar']], 3, 2);
        $this->assertSame(2, $sizes->next());
        $this->assertSame(2, $sizes->next());
        $this->assertSame(7, $sizes->next());
        $this->assertSame(11, $sizes->getTotalSize());
    }

    public function testShouldCalculateIncreasedColumns(): void
    {
        $terminal = $this->createMock(TerminalInterface::class);
        $terminal->expects($this->once())
            ->method('getSize')
            ->willReturn(new Size(100, 100));

        $autoResize = new AutoResizingCalculator($terminal, 2);

        $sizes = $autoResize->calculate([['foo', 'foobar', 'foobarfoobar']], 3, 2);
        $this->assertSame(27, $sizes->next());
        $this->assertSame(30, $sizes->next());
        $this->assertSame(35, $sizes->next());
        $this->assertSame(92, $sizes->getTotalSize());
    }

    public function testShouldCalculateColumnSizeIsBiggerThanFirstValues(): void
    {
        $terminal = $this->createMock(TerminalInterface::class);
        $terminal->expects($this->once())
            ->method('getSize')
            ->willReturn(new Size(100, 100));

        $autoResize = new AutoResizingCalculator($terminal, 2);

        $sizes = $autoResize->calculate(
            [['foo', 'foobar', 'foobarfoobar'], ['foobar', 'foo', 'foobarfoobar']],
            3,
            2
        );

        $this->assertSame(29, $sizes->next());
        $this->assertSame(29, $sizes->next());
        $this->assertSame(34, $sizes->next());
        $this->assertSame(92, $sizes->getTotalSize());
    }

    public function testShouldCalculateHitAllColumnMinimalSize(): void
    {
        $terminal = $this->createMock(TerminalInterface::class);
        $terminal->expects($this->once())
            ->method('getSize')
            ->willReturn(new Size(16, 100));

        $autoResize = new AutoResizingCalculator($terminal, 3);

        $sizes = $autoResize->calculate([['foo', 'foobar', 'foobarfoobar']], 3, 2);
        $this->assertSame(3, $sizes->next());
        $this->assertSame(3, $sizes->next());
        $this->assertSame(3, $sizes->next());
        $this->assertSame(9, $sizes->getTotalSize());
    }

    public function testShouldThrowOnTerminalException(): void
    {
        $terminal = $this->createMock(TerminalInterface::class);
        $terminal->expects($this->once())
            ->method('getSize')
            ->willThrowException(new TerminalException());

        $autoResize = new AutoResizingCalculator($terminal, 3);

        $this->expectException(CalculatorException::class);
        $autoResize->calculate([['foo', 'foobar', 'foobarfoobar']], 3, 2);
    }

    public function testShouldThrowOnInconsistentColumnCount(): void
    {
        $terminal = $this->createMock(TerminalInterface::class);
        $terminal->expects($this->once())
            ->method('getSize')
            ->willReturn(new Size(16, 100));

        $autoResize = new AutoResizingCalculator($terminal, 3);

        $this->expectException(CalculatorException::class);
        $autoResize->calculate(
            [['foo', 'foobar', 'foobarfoobar'], ['foo', 'bar', 'foobar', 'raboof']],
            3,
            2
        );
    }
}
