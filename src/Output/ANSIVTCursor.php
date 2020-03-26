<?php declare(strict_types=1);

namespace Qlimix\Cli\Output;

use function sprintf;

/**
 * @see http://www.termsys.demon.co.uk/vtansi.htm#cursor
 */
final class ANSIVTCursor implements CursorInterface
{
    private OutputInterface $output;

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    public function hide(): void
    {
        $this->output->write("\033[?25l");
    }

    public function show(): void
    {
        $this->output->write("\033[?25h");
    }

    public function up(int $lines): void
    {
        $this->output->write(sprintf("\033[%dA", $lines));
    }

    public function down(int $lines): void
    {
        $this->output->write(sprintf("\033[%dB", $lines));
    }

    public function clearLines(int $lines): void
    {
        for ($i = 1; $i <= $lines; $i++) {
            $this->up(1);
            $this->clearCurrentLine();
        }
    }

    public function clearCurrentLine(): void
    {
        $this->output->write("\r");
        $this->output->write("\033[K");
    }
}
