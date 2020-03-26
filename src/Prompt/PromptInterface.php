<?php declare(strict_types=1);

namespace Qlimix\Cli\Prompt;

use Qlimix\Cli\Prompt\Exception\PromptException;

interface PromptInterface
{
    /**
     * @throws PromptException
     */
    public function prompt(string $text): string;
}
