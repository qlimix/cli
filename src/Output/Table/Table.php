<?php declare(strict_types=1);

namespace Qlimix\Cli\Output\Table;

use Qlimix\Cli\Output\Table\Calculator\CalculatorInterface;
use Qlimix\Cli\Output\Table\Decorator\DecoratorInterface;
use Qlimix\Cli\Output\Table\Exception\TableException;
use Throwable;

final class Table implements TableInterface
{
    private CalculatorInterface $calculator;

    private DecoratorInterface $decorator;

    public function __construct(CalculatorInterface $calculator, DecoratorInterface $decorator)
    {
        $this->calculator = $calculator;
        $this->decorator = $decorator;
    }

    /**
     * @inheritDoc
     */
    public function draw(array $headers, array $values): string
    {
        if (empty($headers)) {
            throw new TableException('Headers can\'t be empty!');
        }

        $voodoo = $values;
        $voodoo[] = $headers;
        try {
            $sizes = $this->calculator->calculate(
                $voodoo,
                $this->decorator->getColumnSeparatorSize(),
                $this->decorator->getSeparatorSize()
            );
        } catch (Throwable $exception) {
            throw new TableException('Failed to calculate table size', 0, $exception);
        }

        $columns = [];
        foreach ($headers as $header) {
            $columns[] = new Column($header);
        }

        $header = new Row($columns);

        $rows = [];
        foreach ($values as $value) {
            $columns = [];
            foreach ($value as $item) {
                $columns[] = new Column($item);
            }

            $rows[] = new Row($columns);
        }

        $table = new Formatter($header, $rows, $this->decorator, $sizes);

        return $table->draw();
    }
}
