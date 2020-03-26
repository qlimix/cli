<?php declare(strict_types=1);

namespace Qlimix\Cli\Input\Hidden;

use Qlimix\Cli\Input\Exception\HiddenException;

interface HiddenInterface
{
    /**
     * @throws HiddenException
     */
    public function hide(): void;

    /**
     * @throws HiddenException
     */
    public function show(): void;
}
