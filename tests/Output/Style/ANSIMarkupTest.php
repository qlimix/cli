<?php declare(strict_types=1);

namespace Qlimix\Tests\Cli\Output\Style;

use PHPUnit\Framework\TestCase;
use Qlimix\Cli\Output\Style\BackgroundColor;
use Qlimix\Cli\Output\Style\TextStyle;
use Qlimix\Cli\Output\Style\TextColor;
use Qlimix\Cli\Output\Style\ANSIMarkup;

final class ANSIMarkupTest extends TestCase
{
    /**
     * @dataProvider textColorProvider
     */
    public function testShouldTextColor(TextColor $textColor, string $ansiCode): void
    {
        $markup = new ANSIMarkup();

        $text = 'foo';
        $output = $markup->markup(
            BackgroundColor::createDefault(),
            $textColor,
            TextStyle::createDefault(),
            $text
        );

        $this->assertSame($ansiCode.$text."\e[39m", $output);
    }

    /**
     * @dataProvider backgroundColorProvider
     */
    public function testShouldBackgroundColor(BackgroundColor $backgroundColor, string $ansiCode): void
    {
        $markup = new ANSIMarkup();

        $text = 'foo';
        $output = $markup->markup(
            $backgroundColor,
            TextColor::createDefault(),
            TextStyle::createDefault(),
            $text
        );

        $this->assertSame($ansiCode.$text."\e[49m", $output);
    }

    /**
     * @dataProvider textStyleProvider
     */
    public function testShouldStyle(TextStyle $textStyle, string $ansiCode): void
    {
        $markup = new ANSIMarkup();

        $text = 'foo';
        $output = $markup->markup(
            BackgroundColor::createDefault(),
            TextColor::createDefault(),
            $textStyle,
            $text
        );

        $this->assertSame($ansiCode.$text."\e[21m", $output);
    }

    public function testShouldBackgroundColorAndTextColor(): void
    {
        $markup = new ANSIMarkup();

        $text = 'foo';
        $output = $markup->markup(
            BackgroundColor::createGreen(),
            TextColor::createBlue(),
            TextStyle::createDefault(),
            $text
        );

        $this->assertSame("\e[42m\e[34m".$text."\e[49m\e[39m", $output);
    }

    public function testShouldBackgroundColorAndTextColorAndTextStyle(): void
    {
        $markup = new ANSIMarkup();

        $text = 'foo';
        $output = $markup->markup(
            BackgroundColor::createGreen(),
            TextColor::createBlue(),
            TextStyle::createBold(),
            $text
        );

        $this->assertSame("\e[42m\e[34m\e[1m".$text."\e[49m\e[39m\e[21m", $output);
    }

    public function textColorProvider(): array
    {
        return [
            [TextColor::createRed(), "\e[31m"],
            [TextColor::createBlack(), "\e[30m"],
            [TextColor::createRed(), "\e[31m"],
            [TextColor::createGreen(), "\e[32m"],
            [TextColor::createYellow(), "\e[33m"],
            [TextColor::createBlue(), "\e[34m"],
            [TextColor::createMagenta(), "\e[35m"],
            [TextColor::createCyan(), "\e[36m"],
            [TextColor::createGray(), "\e[37m"],
        ];
    }

    public function backgroundColorProvider(): array
    {
        return [
            [BackgroundColor::createRed(), "\e[41m"],
            [BackgroundColor::createBlack(), "\e[40m"],
            [BackgroundColor::createRed(), "\e[41m"],
            [BackgroundColor::createGreen(), "\e[42m"],
            [BackgroundColor::createYellow(), "\e[43m"],
            [BackgroundColor::createBlue(), "\e[44m"],
            [BackgroundColor::createMagenta(), "\e[45m"],
            [BackgroundColor::createCyan(), "\e[46m"],
            [BackgroundColor::createGray(), "\e[47m"],
        ];
    }

    public function textStyleProvider(): array
    {
        return [
            [TextStyle::createBold(), "\e[1m"],
            [TextStyle::createUnderline(), "\e[4m"],
            [TextStyle::createBoldAndUnderline(), "\e[1m\e[4m"],
        ];
    }
}
