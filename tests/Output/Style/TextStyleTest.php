<?php declare(strict_types=1);

namespace Qlimix\Tests\Cli\Output\Style;

use PHPUnit\Framework\TestCase;
use Qlimix\Cli\Output\Style\TextStyle;

final class TextStyleTest extends TestCase
{
    public function testShouldBeDefault(): void
    {
        $style = TextStyle::createDefault();

        $this->assertTrue($style->isDefault());
        $this->assertFalse($style->isBold());
    }

    public function testShouldBeBold(): void
    {
        $style = TextStyle::createBold();

        $this->assertTrue($style->isBold());
        $this->assertFalse($style->isUnderline());
    }

    public function testShouldBeUnderline(): void
    {
        $style = TextStyle::createUnderline();

        $this->assertTrue($style->isUnderline());
        $this->assertFalse($style->isBold());
    }

    public function testShouldBeBoldAndUnderline(): void
    {
        $style = TextStyle::createBoldAndUnderline();

        $this->assertTrue($style->isUnderline());
        $this->assertTrue($style->isBold());
    }
}
