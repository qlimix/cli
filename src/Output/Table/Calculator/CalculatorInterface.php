<?php declare(strict_types=1);

namespace Qlimix\Cli\Output\Table\Calculator;

use Qlimix\Cli\Output\Table\Calculator\Exception\CalculatorException;

interface CalculatorInterface
{
    /**
     * @param array<int, array<int, string>> $values
     *
     * @throws CalculatorException
     */
    public function calculate(array $values, int $separatorSize, int $sideSize): Size;
}
