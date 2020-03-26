<?php declare(strict_types=1);

namespace Qlimix\Cli\Prompt\Decorator;

interface DecoratorInterface
{
    public function decorate(string $text): string;
}
