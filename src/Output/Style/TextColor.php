<?php declare(strict_types=1);

namespace Qlimix\Cli\Output\Style;

final class TextColor
{
    private const BLACK = 'black';
    private const RED = 'red';
    private const GREEN = 'green';
    private const YELLOW = 'yellow';
    private const BLUE = 'blue';
    private const MAGENTA = 'magenta';
    private const CYAN = 'cyan';
    private const GRAY = 'gray';
    private const DEFAULT = 'default';

    private string $color;

    public function __construct(string $color)
    {
        $this->color = $color;
    }

    public static function createBlack(): self
    {
        return new self(self::BLACK);
    }

    public function isBlack(): bool
    {
        return $this->color === self::BLACK;
    }

    public static function createRed(): self
    {
        return new self(self::RED);
    }

    public function isRed(): bool
    {
        return $this->color === self::RED;
    }

    public static function createGreen(): self
    {
        return new self(self::GREEN);
    }

    public function isGreen(): bool
    {
        return $this->color === self::GREEN;
    }

    public static function createYellow(): self
    {
        return new self(self::YELLOW);
    }

    public function isYellow(): bool
    {
        return $this->color === self::YELLOW;
    }

    public static function createBlue(): self
    {
        return new self(self::BLUE);
    }

    public function isBlue(): bool
    {
        return $this->color === self::BLUE;
    }

    public static function createMagenta(): self
    {
        return new self(self::MAGENTA);
    }

    public function isMagenta(): bool
    {
        return $this->color === self::MAGENTA;
    }

    public static function createCyan(): self
    {
        return new self(self::CYAN);
    }

    public function isCyan(): bool
    {
        return $this->color === self::CYAN;
    }

    public static function createGray(): self
    {
        return new self(self::GRAY);
    }

    public function isGray(): bool
    {
        return $this->color === self::GRAY;
    }

    public static function createDefault(): self
    {
        return new self(self::DEFAULT);
    }

    public function isDefault(): bool
    {
        return $this->color === self::DEFAULT;
    }
}
