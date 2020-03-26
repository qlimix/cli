<?php declare(strict_types=1);

namespace Qlimix\Cli\Prompt;

use Qlimix\Cli\Prompt\Exception\ConfirmException;

interface ConfirmInterface
{
    /**
     * @param string[] $options
     *
     * @throws ConfirmException
     */
    public function confirm(string $text, array $options): bool;
}
