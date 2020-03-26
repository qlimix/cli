<?php declare(strict_types=1);

namespace Qlimix\Tests\Cli\Output\Progress\Decorator;

use PHPUnit\Framework\TestCase;
use Qlimix\Cli\Output\CursorInterface;
use Qlimix\Cli\Output\OutputInterface;
use Qlimix\Cli\Output\Progress\Decorator\Exception\DecoratorException;
use Qlimix\Cli\Output\Progress\Decorator\ProgressDecorator;
use Qlimix\Cli\Output\Progress\Progress;
use Qlimix\Cli\Output\Terminal\Exception\TerminalException;
use Qlimix\Cli\Output\Terminal\Size;
use Qlimix\Cli\Output\Terminal\TerminalInterface;

final class DecoratorTest extends TestCase
{
    public function testShouldDecorate(): void
    {
        $output = $this->createMock(OutputInterface::class);
        $terminal = $this->createMock(TerminalInterface::class);
        $cursor = $this->createMock(CursorInterface::class);

        $decorator = new ProgressDecorator($terminal);
        $total = 10;
        $i = 1;

        $expectedProgress = [
            '[->                ]',
            '[--->              ]',
            '[----->            ]',
            '[------>           ]',
            '[-------->         ]',
            '[---------->       ]',
            '[----------->      ]',
            '[------------->    ]',
            '[--------------->  ]',
            '[----------------->]',
        ];
        $terminal->expects($this->any())
            ->method('getSize')
            ->willReturn(new Size(20, 100));

        $cursor->expects($this->once())
            ->method('hide');

        $cursor->expects($this->once())
            ->method('show');

        $output->expects($this->exactly($total))
            ->method('writeLine')
            ->with($this->callback(static function (string $text) use (&$i, &$expectedProgress): bool {
                return $text === $expectedProgress[$i-1];
            }));

        $progress = new Progress($output, $decorator, $cursor, $total);

        for (; $i <= $total; $i++) {
            $progress->progress($i);
        }
    }

    public function testShouldThrowOnOutputException(): void
    {
        $terminal = $this->createMock(TerminalInterface::class);
        $terminal->expects($this->once())
            ->method('getSize')
            ->willThrowException(new TerminalException());

        $decorator = new ProgressDecorator($terminal);

        $this->expectException(DecoratorException::class);
        $decorator->decorate(1);
    }

    public function testShouldDrawWithZeroProgress(): void
    {
        $terminal = $this->createMock(TerminalInterface::class);
        $terminal->expects($this->once())
            ->method('getSize')
            ->willReturn(new Size(20, 100));

        $decorator = new ProgressDecorator($terminal);
        $this->assertSame(['[>                 ]'], $decorator->decorate(0));
    }
}
