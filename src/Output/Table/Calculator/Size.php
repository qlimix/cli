<?php declare(strict_types=1);

namespace Qlimix\Cli\Output\Table\Calculator;

use function count;

final class Size
{
    /** @var int[] */
    private array $sizes;

    private int $pointer = 0;

    /**
     * @param int[] $sizes
     */
    public function __construct(array $sizes)
    {
        $this->sizes = $sizes;
    }

    public function next(): int
    {
        $next = $this->sizes[$this->pointer];

        $this->pointer++;
        if ($this->pointer === count($this->sizes)) {
            $this->pointer = 0;
        }

        return $next;
    }

    public function getTotalSize(): int
    {
        $maxSize = 0;
        foreach ($this->sizes as $size) {
            $maxSize += $size;
        }

        return $maxSize;
    }
}
