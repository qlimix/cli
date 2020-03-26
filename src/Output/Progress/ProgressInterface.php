<?php declare(strict_types=1);

namespace Qlimix\Cli\Output\Progress;

use Qlimix\Cli\Output\Progress\Exception\ProgressException;

interface ProgressInterface
{
    /**
     * @throws ProgressException
     */
    public function progress(int $progress): void;
}
