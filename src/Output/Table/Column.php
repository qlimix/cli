<?php declare(strict_types=1);

namespace Qlimix\Cli\Output\Table;

use function str_repeat;
use function strlen;
use function substr;

final class Column
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function draw(int $maxSize): string
    {
        $length = strlen($this->value);
        if ($length > $maxSize) {
            $value = substr($this->value, 0, $maxSize);
            if ($value === false) {
                $value = '';
            }
        } else {
            $value = $this->value.str_repeat(' ', $maxSize - $length);
        }

        return $value;
    }
}
