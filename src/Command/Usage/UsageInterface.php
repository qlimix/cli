<?php declare(strict_types=1);

namespace Qlimix\Cli\Command\Usage;

use Qlimix\Cli\Command\Command;

interface UsageInterface
{
    public function usage(Command $command): string;
}
