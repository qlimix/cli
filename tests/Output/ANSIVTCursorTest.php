<?php declare(strict_types=1);

namespace Qlimix\Tests\Cli\Output;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Qlimix\Cli\Output\OutputInterface;
use Qlimix\Cli\Output\ANSIVTCursor;

final class ANSIVTCursorTest extends TestCase
{
    private MockObject $output;

    private ANSIVTCursor $cursor;

    protected function setUp(): void
    {
        $this->output = $this->createMock(OutputInterface::class);
        $this->cursor = new ANSIVTCursor($this->output);
    }

    private function expectOutput(string $expected): void
    {
        $this->output->expects($this->once())
            ->method('write')
            ->with($this->callback(static function (string $output) use ($expected): bool {
                return $output === $expected;
            }));
    }

    public function testShouldHide(): void
    {
        $this->expectOutput("\033[?25l");
        $this->cursor->hide();
    }

    public function testShouldShow(): void
    {
        $this->expectOutput("\033[?25h");
        $this->cursor->show();
    }

    public function testShouldMoveUp(): void
    {
        $this->expectOutput("\033[1A");
        $this->cursor->up(1);
    }

    public function testShouldMoveUpMultipleLines(): void
    {
        $this->expectOutput("\033[3A");
        $this->cursor->up(3);
    }

    public function testShouldMoveDown(): void
    {
        $this->expectOutput("\033[1B");
        $this->cursor->down(1);
    }

    public function testShouldMoveDownMultipleLines(): void
    {
        $this->expectOutput("\033[3B");
        $this->cursor->down(3);
    }

    public function testShouldClearLines(): void
    {
        $index = 0;
        $values = [];
        $values[] = "\033[1A";
        $values[] = "\r";
        $values[] = "\033[K";

        $this->output->expects($this->exactly(3))
            ->method('write')
            ->with($this->callback(static function (string $output) use ($values, &$index): bool {
                $current = $index;
                $index++;
                return $output === $values[$current];
            }));

        $this->cursor->clearLines(1);
    }

    public function testShouldClearLinesMultipleLines(): void
    {
        $index = 0;
        $values = [];
        $values[] = "\033[1A";
        $values[] = "\r";
        $values[] = "\033[K";
        $values[] = "\033[1A";
        $values[] = "\r";
        $values[] = "\033[K";
        $values[] = "\033[1A";
        $values[] = "\r";
        $values[] = "\033[K";

        $this->output->expects($this->exactly(9))
            ->method('write')
            ->with($this->callback(static function (string $output) use ($values, &$index): bool {
                $current = $index;
                $index++;
                return $output === $values[$current];
            }));

        $this->cursor->clearLines(3);
    }

    public function testShouldClearLine(): void
    {
        $index = 0;
        $values = [];
        $values[] = "\r";
        $values[] = "\033[K";

        $this->output->expects($this->exactly(2))
            ->method('write')
            ->with($this->callback(static function (string $output) use ($values, &$index): bool {
                $current = $index;
                $index++;
                return $output === $values[$current];
            }));

        $this->cursor->clearCurrentLine();
    }
}
