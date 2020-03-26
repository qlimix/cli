<?php declare(strict_types=1);

namespace Qlimix\Tests\Cli\Output\Table\Calculator;

use PHPUnit\Framework\TestCase;
use Qlimix\Cli\Output\Table\Calculator\Size;

final class SizeTest extends TestCase
{
    public function testShouldSize(): void
    {
        $size = new Size([1, 2, 3, 4]);

        $this->assertSame(1, $size->next());
        $this->assertSame(2, $size->next());
        $this->assertSame(3, $size->next());
        $this->assertSame(4, $size->next());
        $this->assertSame(10, $size->getTotalSize());
    }
    public function testShouldAutoResetToBegin(): void
    {
        $size = new Size([1, 2, 3, 4]);

        $this->assertSame(1, $size->next());
        $this->assertSame(2, $size->next());
        $this->assertSame(3, $size->next());
        $this->assertSame(4, $size->next());
        $this->assertSame(10, $size->getTotalSize());

        $this->assertSame(1, $size->next());
        $this->assertSame(2, $size->next());
        $this->assertSame(3, $size->next());
        $this->assertSame(4, $size->next());
        $this->assertSame(10, $size->getTotalSize());

        $this->assertSame(1, $size->next());
        $this->assertSame(2, $size->next());
        $this->assertSame(3, $size->next());
        $this->assertSame(4, $size->next());
        $this->assertSame(10, $size->getTotalSize());
    }
}
