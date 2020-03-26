<?php declare(strict_types=1);

namespace Qlimix\Cli\Command\Input\Parser;

use Qlimix\Cli\Command\Command;
use Qlimix\Cli\Command\Input\InputInterface;
use Qlimix\Cli\Command\Input\Parser\Exception\ParserException;

interface ParserInterface
{
    /**
     * @throws ParserException
     */
    public function parse(Command $command): InputInterface;
}
