<?php declare(strict_types=1);

namespace Qlimix\Cli\Output\Table\Calculator;

use Qlimix\Cli\Output\Table\Calculator\Exception\CalculatorException;
use Qlimix\Cli\Output\Terminal\TerminalInterface;
use Throwable;
use function count;

final class AutoResizingCalculator implements CalculatorInterface
{
    use CanGetSizePerColumn;

    private TerminalInterface $terminal;

    private int $minColumnSize;

    public function __construct(TerminalInterface $terminal, int $minColumnSize)
    {
        $this->terminal = $terminal;
        $this->minColumnSize = $minColumnSize;
    }

    /**
     * @inheritDoc
     */
    public function calculate(array $values, int $separatorSize, int $sideSize): Size
    {
        try {
            $terminalSize = $this->terminal->getSize();
        } catch (Throwable $exception) {
            throw new CalculatorException('Failed to get terminal size', 0, $exception);
        }

        $sizes = $this->lengthSizesPerColumn($values);

        $countColumns = (count($values[0]) - 1) * $separatorSize + $sideSize;
        $maxSizeWithColumnSpacing = $this->getMaxTotalSize($sizes) + $countColumns;
        if ($terminalSize->getWidth() >= $maxSizeWithColumnSpacing) {
            $leftOver = $terminalSize->getWidth() - $maxSizeWithColumnSpacing;
            $this->increaseSpace($leftOver, $sizes);
        } else {
            $toShrink = $maxSizeWithColumnSpacing - $terminalSize->getWidth();
            $this->decreaseSpace($toShrink, $sizes);
        }

        return new Size($sizes);
    }

    /**
     * @param int[] $sizes
     */
    private function increaseSpace(int $increase, array &$sizes): void
    {
        $count = count($sizes);
        $pointer = 0;
        while ($increase > 0) {
            $sizes[$pointer]++;
            $pointer++;
            if ($pointer === $count) {
                $pointer = 0;
            }

            $increase--;
        }
    }

    /**
     * @param int[] $sizes
     */
    private function decreaseSpace(int $shrink, array &$sizes): void
    {
        $count = count($sizes);
        $pointer = 0;
        $minimizedColumns = [];
        while ($shrink > 0) {
            if ($sizes[$pointer] === $this->minColumnSize) {
                $minimizedColumns[$pointer] = true;
            } else {
                $sizes[$pointer]--;
                $shrink--;
            }

            $pointer++;
            if ($pointer === $count) {
                $pointer = 0;
            }

            if (count($minimizedColumns) === count($sizes)) {
                return;
            }
        }
    }

    /**
     * @param int[] $sizes
     */
    private function getMaxTotalSize(array $sizes): int
    {
        $maxSize = 0;
        foreach ($sizes as $size) {
            $maxSize += $size;
        }

        return $maxSize;
    }
}
