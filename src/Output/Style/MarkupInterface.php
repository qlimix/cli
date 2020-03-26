<?php declare(strict_types=1);

namespace Qlimix\Cli\Output\Style;

interface MarkupInterface
{
    public function markup(BackgroundColor $background, TextColor $textColor, TextStyle $style, string $text): string;
}
