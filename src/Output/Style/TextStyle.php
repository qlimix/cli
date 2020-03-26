<?php declare(strict_types=1);

namespace Qlimix\Cli\Output\Style;

final class TextStyle
{
    private bool $bold;
    private bool $underline;

    private function __construct(bool $bold, bool $underline)
    {
        $this->bold = $bold;
        $this->underline = $underline;
    }

    public static function createBold(): self
    {
        return new self(true, false);
    }

    public function isBold(): bool
    {
        return $this->bold;
    }

    public static function createUnderline(): self
    {
        return new self(false, true);
    }

    public function isUnderline(): bool
    {
        return $this->underline;
    }

    public static function createDefault(): self
    {
        return new self(false, false);
    }

    public function isDefault(): bool
    {
        return !$this->bold && !$this->underline;
    }

    public static function createBoldAndUnderline(): self
    {
        return new self(true, true);
    }

    public function isBoldAndUnderline(): bool
    {
        return $this->bold && $this->underline;
    }
}
