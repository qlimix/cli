<?php declare(strict_types=1);

namespace Qlimix\Cli\Output;

interface CursorInterface
{
    public function hide(): void;

    public function show(): void;

    public function clearLines(int $lines): void;

    public function clearCurrentLine(): void;
}
