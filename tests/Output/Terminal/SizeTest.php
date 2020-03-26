<?php declare(strict_types=1);

namespace Qlimix\Tests\Cli\Output\Terminal;

use PHPUnit\Framework\TestCase;
use Qlimix\Cli\Output\Terminal\Size;

final class SizeTest extends TestCase
{
    public function testShouldSize(): void
    {
        $width = 10;
        $height = 15;

        $size = new Size($width, $height);

        $this->assertSame($width, $size->getWidth());
        $this->assertSame($height, $size->getHeight());
    }
}
