<?php declare(strict_types=1);

namespace Qlimix\Cli\Output\Table\Calculator;

use Qlimix\Cli\Output\Table\Calculator\Exception\CalculatorException;
use function count;
use function strlen;

trait CanGetSizePerColumn
{
    /**
     * @param array<int, array<int, string>> $items
     *
     * @return int[]
     *
     * @throws CalculatorException
     */
    private function lengthSizesPerColumn(array $items): array
    {
        $amountOfItems = 0;
        $size = [];
        foreach ($items as $item) {
            $sizeOfItem = count($item);
            if ($amountOfItems === 0) {
                $amountOfItems = $sizeOfItem;
            }

            if ($amountOfItems !== $sizeOfItem) {
                throw new CalculatorException('Inconsistent row sizes');
            }

            foreach ($item as $index => $subItem) {
                $itemSize = strlen($subItem);
                if (!isset($size[$index])) {
                    $size[$index] = $itemSize;
                }

                if ($itemSize <= $size[$index]) {
                    continue;
                }

                $size[$index] = $itemSize;
            }
        }

        return $size;
    }
}
