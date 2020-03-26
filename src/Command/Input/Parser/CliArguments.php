<?php declare(strict_types=1);

namespace Qlimix\Cli\Command\Input\Parser;

use Qlimix\Cli\Command\Input\Parser\Exception\ArgumentsException;

final class CliArguments
{
    /** @var CliArgument[] */
    private array $arguments;

    private int $pointer = 0;

    /**
     * @param CliArgument[] $arguments
     */
    public function __construct(array $arguments)
    {
        $this->arguments = $arguments;
    }

    /**
     * @throws ArgumentsException
     */
    public function next(): CliArgument
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
    public function peek(): CliArgument
    {
        if (!isset($this->arguments[$this->pointer])) {
            throw new ArgumentsException('invalid argument');
        }

        return $this->arguments[$this->pointer];
    }
}
