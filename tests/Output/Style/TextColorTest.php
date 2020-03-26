<?php declare(strict_types=1);

namespace Qlimix\Tests\Cli\Output\Style;

use PHPUnit\Framework\TestCase;
use Qlimix\Cli\Output\Style\TextColor;

final class TextColorTest extends TestCase
{
    public function testShouldBeBlack(): void
    {
        $color = TextColor::createBlack();

        $this->assertTrue($color->isBlack());
        $this->assertFalse($color->isRed());
    }

    public function testShouldBeRed(): void
    {
        $color = TextColor::createRed();

        $this->assertTrue($color->isRed());
        $this->assertFalse($color->isBlue());
    }

    public function testShouldBeGreen(): void
    {
        $color = TextColor::createGreen();

        $this->assertTrue($color->isGreen());
        $this->assertFalse($color->isRed());
    }

    public function testShouldBeYellow(): void
    {
        $color = TextColor::createYellow();

        $this->assertTrue($color->isYellow());
        $this->assertFalse($color->isRed());
    }

    public function testShouldBeBlue(): void
    {
        $color = TextColor::createBlue();

        $this->assertTrue($color->isBlue());
        $this->assertFalse($color->isRed());
    }

    public function testShouldBeMagenta(): void
    {
        $color = TextColor::createMagenta();

        $this->assertTrue($color->isMagenta());
        $this->assertFalse($color->isRed());
    }

    public function testShouldBeCyan(): void
    {
        $color = TextColor::createCyan();

        $this->assertTrue($color->isCyan());
        $this->assertFalse($color->isRed());
    }

    public function testShouldBeGray(): void
    {
        $color = TextColor::createGray();

        $this->assertTrue($color->isGray());
        $this->assertFalse($color->isRed());
    }

    public function testShouldBeDefault(): void
    {
        $color = TextColor::createDefault();

        $this->assertTrue($color->isDefault());
        $this->assertFalse($color->isRed());
    }
}
