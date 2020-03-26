<?php declare(strict_types=1);

namespace Qlimix\Tests\Cli\Output\Table\Calculator;

use PHPUnit\Framework\TestCase;
use Qlimix\Cli\Output\Table\Calculator\Exception\CalculatorException;
use Qlimix\Cli\Output\Table\Calculator\SimpleCalculator;

final class SimpleCalculatorTest extends TestCase
{
    public function testShouldCalculate(): void
    {
        $simpleSize = new SimpleCalculator();

        $sizes = $simpleSize->calculate([['foo', 'foobar', 'foobarfoobar']], 3, 2);

        $this->assertSame(3, $sizes->next());
        $this->assertSame(6, $sizes->next());
        $this->assertSame(12, $sizes->next());
        $this->assertSame(21, $sizes->getTotalSize());
    }

    public function testShouldThrowOnInconsistentColumnCount(): void
    {
        $simpleSize = new SimpleCalculator();

        $this->expectException(CalculatorException::class);
        $simpleSize->calculate(
            [['foo', 'foobar', 'foobarfoobar'], ['foo', 'bar', 'foobar', 'raboof']],
            3,
            2
        );
    }

    public function testShouldCalculateColumnSizeIsBiggerThanFirstValues(): void
    {
        $simpleSize = new SimpleCalculator();

        $sizes = $simpleSize->calculate(
            [['foo', 'foobar', 'foobarfoobar'], ['foobar', 'foo', 'foobarfoobar']],
            3,
            2
        );

        $this->assertSame(6, $sizes->next());
        $this->assertSame(6, $sizes->next());
        $this->assertSame(12, $sizes->next());
        $this->assertSame(24, $sizes->getTotalSize());
    }
}
