<?php declare(strict_types=1);

namespace Qlimix\Cli\Output\Progress;

interface FactoryInterface
{
    public function create(int $total): ProgressInterface;
}
