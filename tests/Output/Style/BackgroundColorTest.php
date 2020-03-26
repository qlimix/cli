<?php declare(strict_types=1);

namespace Qlimix\Tests\Cli\Output\Style;

use PHPUnit\Framework\TestCase;
use Qlimix\Cli\Output\Style\BackgroundColor;

final class BackgroundColorTest extends TestCase
{
    public function testShouldBeBlack(): void
    {
        $color = BackgroundColor::createBlack();

        $this->assertTrue($color->isBlack());
        $this->assertFalse($color->isRed());
    }

    public function testShouldBeRed(): void
    {
        $color = BackgroundColor::createRed();

        $this->assertTrue($color->isRed());
        $this->assertFalse($color->isBlue());
    }

    public function testShouldBeGreen(): void
    {
        $color = BackgroundColor::createGreen();

        $this->assertTrue($color->isGreen());
        $this->assertFalse($color->isRed());
    }

    public function testShouldBeYellow(): void
    {
        $color = BackgroundColor::createYellow();

        $this->assertTrue($color->isYellow());
        $this->assertFalse($color->isRed());
    }

    public function testShouldBeBlue(): void
    {
        $color = BackgroundColor::createBlue();

        $this->assertTrue($color->isBlue());
        $this->assertFalse($color->isRed());
    }

    public function testShouldBeMagenta(): void
    {
        $color = BackgroundColor::createMagenta();

        $this->assertTrue($color->isMagenta());
        $this->assertFalse($color->isRed());
    }

    public function testShouldBeCyan(): void
    {
        $color = BackgroundColor::createCyan();

        $this->assertTrue($color->isCyan());
        $this->assertFalse($color->isRed());
    }

    public function testShouldBeGray(): void
    {
        $color = BackgroundColor::createGray();

        $this->assertTrue($color->isGray());
        $this->assertFalse($color->isRed());
    }

    public function testShouldBeDefault(): void
    {
        $color = BackgroundColor::createDefault();

        $this->assertTrue($color->isDefault());
        $this->assertFalse($color->isRed());
    }
}
