<?php declare(strict_types=1);

namespace Qlimix\Tests\Cli\Output\Progress;

use PHPUnit\Framework\TestCase;
use Qlimix\Cli\Output\CursorInterface;
use Qlimix\Cli\Output\Exception\OutputException;
use Qlimix\Cli\Output\OutputInterface;
use Qlimix\Cli\Output\Progress\Decorator\DecoratorInterface;
use Qlimix\Cli\Output\Progress\Decorator\Exception\DecoratorException;
use Qlimix\Cli\Output\Progress\Exception\ProgressException;
use Qlimix\Cli\Output\Progress\Progress;

final class ProgressTest extends TestCase
{
    /**
     * @dataProvider totalProgressProvider
     */
    public function testShouldProgress(int $total): void
    {
        $output = $this->createMock(OutputInterface::class);
        $decorator = $this->createMock(DecoratorInterface::class);
        $cursor = $this->createMock(CursorInterface::class);

        $decorator->expects($this->exactly($total))
            ->method('decorate')
            ->willReturn(['-']);

        $cursor->expects($this->once())
            ->method('hide');

        $cursor->expects($this->once())
            ->method('show');

        $output->expects($this->exactly($total))
            ->method('writeLine');

        $progress = new Progress($output, $decorator, $cursor, $total);

        for ($i = 1; $i <= $total; $i++) {
            $progress->progress($i);
        }
    }

    public function testShouldThrowOnDecoratorException(): void
    {
        $output = $this->createMock(OutputInterface::class);
        $decorator = $this->createMock(DecoratorInterface::class);
        $cursor = $this->createMock(CursorInterface::class);

        $decorator->expects($this->once())
            ->method('decorate')
            ->willThrowException(new DecoratorException());

        $progress = new Progress($output, $decorator, $cursor, 10);

        $this->expectException(ProgressException::class);
        $progress->progress(1);
    }

    public function testShouldThrowOnOutputException(): void
    {
        $output = $this->createMock(OutputInterface::class);
        $decorator = $this->createMock(DecoratorInterface::class);
        $cursor = $this->createMock(CursorInterface::class);

        $decorator->expects($this->once())
            ->method('decorate')
            ->willReturn(['-']);

        $output->expects($this->once())
            ->method('writeLine')
            ->willThrowException(new OutputException());

        $progress = new Progress($output, $decorator, $cursor, 10);

        $this->expectException(ProgressException::class);
        $progress->progress(1);
    }

    public function totalProgressProvider(): array
    {
        return [
          [19],
          [65],
          [32],
          [435],
          [41],
        ];
    }
}
