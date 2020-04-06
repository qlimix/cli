<?php declare(strict_types=1);

namespace Qlimix\Cli\Command\Input\Cli;

use Qlimix\Cli\Command\Input\Parser\Exception\ArgumentsException;

final class Arguments
{
    /** @var Argument[] */
    private array $arguments;

    private int $pointer = 0;

    /**
     * @param Argument[] $arguments
     */
    public function __construct(array $arguments)
    {
        $this->arguments = $arguments;
    }

    /**
     * @throws ArgumentsException
     */
    public function next(): Argument
    {
        if (!isset($this->arguments[$this->pointer])) {
            throw new ArgumentsException('invalid argument');
        }

        $item = $this->arguments[$this->pointer];

        $this->pointer++;

        return $item;
    }

    /**
     * @throws ArgumentsException
     */
    public function peek(): Argument
    {
        if (!isset($this->arguments[$this->pointer])) {
            throw new ArgumentsException('invalid argument');
        }

        return $this->arguments[$this->pointer];
    }
}
