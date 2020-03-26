<?php declare(strict_types=1);

namespace Qlimix\Cli\Input\Hidden;

use function exec;

final class SttyHidden implements HiddenInterface
{
    public function hide(): void
    {
        exec('stty -echo');
    }

    public function show(): void
    {
        exec('stty echo');
    }
}
