<?php declare(strict_types=1);

namespace Qlimix\Cli\Output\Table\Calculator;

final class SimpleCalculator implements CalculatorInterface
{
    use CanGetSizePerColumn;

    /**
     * @param mixed[] $values
     */
    public function calculate(array $values, int $separatorSize, int $sideSize): Size
    {
        $sizes = $this->lengthSizesPerColumn($values);

        return new Size($sizes);
    }
}
