<?php declare(strict_types=1);

namespace Qlimix\Cli\Output\Progress\Decorator;

use Qlimix\Cli\Output\Progress\Decorator\Exception\DecoratorException;

interface DecoratorInterface
{
    /**
     * @return string[]
     *
     * @throws DecoratorException
     */
    public function decorate(int $progress): array;
}
