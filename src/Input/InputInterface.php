<?php declare(strict_types=1);

namespace Qlimix\Cli\Input;

use Qlimix\Cli\Input\Exception\InputException;

interface InputInterface
{
    /**
     * @throws InputException
     */
    public function read(int $length): string;

    /**
     * @throws InputException
     */
    public function readAll(): string;
}
