<?php declare(strict_types=1);

namespace Qlimix\Cli\Output\Style;

final class ANSIMarkup implements MarkupInterface
{
    private const BLACK = 'black';
    private const RED = 'red';
    private const GREEN = 'green';
    private const YELLOW = 'yellow';
    private const BLUE = 'blue';
    private const MAGENTA = 'magenta';
    private const CYAN = 'cyan';
    private const GRAY = 'gray';

    private const BOLD = "\e[1m";
    private const UNDERLINE = "\e[4m";

    private const DEFAULT_STYLE = "\e[21m";
    private const DEFAULT_TEXT_COLOR = "\e[39m";
    private const DEFAULT_BACKGROUND_COLOR= "\e[49m";

    private const BACKGROUND_COLORS = [
        self::BLACK => "\e[40m",
        self::RED => "\e[41m",
        self::GREEN => "\e[42m",
        self::YELLOW => "\e[43m",
        self::BLUE => "\e[44m",
        self::MAGENTA => "\e[45m",
        self::CYAN => "\e[46m",
        self::GRAY => "\e[47m",
    ];

    private const TEXT_COLORS = [
        self::BLACK => "\e[30m",
        self::RED => "\e[31m",
        self::GREEN => "\e[32m",
        self::YELLOW => "\e[33m",
        self::BLUE => "\e[34m",
        self::MAGENTA => "\e[35m",
        self::CYAN => "\e[36m",
        self::GRAY => "\e[37m",
    ];

    public function markup(BackgroundColor $background, TextColor $textColor, TextStyle $style, string $text): string
    {
        $backgroundColor = $this->getBackgroundColor($background);
        $color = $this->getTextColor($textColor);
        $styling = $this->getStyling($style);

        $prefix = '';
        $suffix = '';
        if ($backgroundColor !== null) {
            $prefix .= $backgroundColor;
            $suffix .= self::DEFAULT_BACKGROUND_COLOR;
        }

        if ($color !== null) {
            $prefix .= $color;
            $suffix .= self::DEFAULT_TEXT_COLOR;
        }

        if ($styling !== null) {
            $prefix .= $styling;
            $suffix .= self::DEFAULT_STYLE;
        }

        return $prefix.$text.$suffix;
    }

    private function getBackgroundColor(BackgroundColor $backgroundColor): ?string
    {
        switch ($backgroundColor) {
            case $backgroundColor->isBlack():
                return self::BACKGROUND_COLORS[self::BLACK];
            case $backgroundColor->isRed():
                return self::BACKGROUND_COLORS[self::RED];
            case $backgroundColor->isGreen():
                return self::BACKGROUND_COLORS[self::GREEN];
            case $backgroundColor->isYellow():
                return self::BACKGROUND_COLORS[self::YELLOW];
            case $backgroundColor->isBlue():
                return self::BACKGROUND_COLORS[self::BLUE];
            case $backgroundColor->isMagenta():
                return self::BACKGROUND_COLORS[self::MAGENTA];
            case $backgroundColor->isCyan():
                return self::BACKGROUND_COLORS[self::CYAN];
            case $backgroundColor->isGray():
                return self::BACKGROUND_COLORS[self::GRAY];
        }

        return null;
    }

    private function getTextColor(TextColor $textColor): ?string
    {
        switch ($textColor) {
            case $textColor->isBlack():
                return self::TEXT_COLORS[self::BLACK];
            case $textColor->isRed():
                return self::TEXT_COLORS[self::RED];
            case $textColor->isGreen():
                return self::TEXT_COLORS[self::GREEN];
            case $textColor->isYellow():
                return self::TEXT_COLORS[self::YELLOW];
            case $textColor->isBlue():
                return self::TEXT_COLORS[self::BLUE];
            case $textColor->isMagenta():
                return self::TEXT_COLORS[self::MAGENTA];
            case $textColor->isCyan():
                return self::TEXT_COLORS[self::CYAN];
            case $textColor->isGray():
                return self::TEXT_COLORS[self::GRAY];
        }

        return null;
    }

    private function getStyling(TextStyle $textStyle): ?string
    {
        switch ($textStyle) {
            case $textStyle->isBoldAndUnderline():
                return self::BOLD.self::UNDERLINE;
            case $textStyle->isBold():
                return self::BOLD;
            case $textStyle->isUnderline():
                return self::UNDERLINE;
        }

        return null;
    }
}
