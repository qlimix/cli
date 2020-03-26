<?php declare(strict_types=1);

namespace Qlimix\Cli\Command;

use Qlimix\Cli\Command\Exception\ExecutionException;
use Qlimix\Cli\Command\Input\InputInterface;

interface CommandInterface
{
    /**
     * @throws ExecutionException
     */
    public function execute(InputInterface $input): void;
}
