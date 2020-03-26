<?php declare(strict_types=1);

namespace Qlimix\Tests\Cli\Prompt;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Qlimix\Cli\Input\Exception\InputException;
use Qlimix\Cli\Input\InputInterface;
use Qlimix\Cli\Output\Exception\OutputException;
use Qlimix\Cli\Output\OutputInterface;
use Qlimix\Cli\Prompt\Confirm;
use Qlimix\Cli\Prompt\Decorator\DecoratorInterface;
use Qlimix\Cli\Prompt\Exception\ConfirmException;

final class ConfirmTest extends TestCase
{
    private MockObject $decorator;

    private InputInterface $input;

    private OutputInterface $output;

    private Confirm $confirm;

    protected function setUp(): void
    {
        $this->decorator = $this->createMock(DecoratorInterface::class);
        $this->input = $this->createMock(InputInterface::class);
        $this->output = $this->createMock(OutputInterface::class);

        $this->confirm = new Confirm($this->decorator, $this->input, $this->output);
    }

    public function testShouldConfirm(): void
    {
        $question = 'Are you sure?';

        $this->decorator->expects($this->once())
            ->method('decorate')
            ->willReturn($question);

        $this->output->expects($this->once())
            ->method('writeLine')
            ->with($this->callback(static function (string $text) use ($question) {
                return $text === $question;
            }));

        $this->input->expects($this->once())
            ->method('read')
            ->willReturn('yes');

        $this->assertTrue($this->confirm->confirm($question, ['y', 'yes']));
    }

    public function testShouldNotConfirm(): void
    {
        $question = 'Are you sure?';

        $this->decorator->expects($this->once())
            ->method('decorate')
            ->willReturn($question);

        $this->output->expects($this->once())
            ->method('writeLine')
            ->with($this->callback(static function (string $text) use ($question) {
                return $text === $question;
            }));

        $this->input->expects($this->once())
            ->method('read')
            ->willReturn('foo');

        $this->assertFalse($this->confirm->confirm($question, ['y', 'yes']));
    }

    public function testShouldThrowOnOutputException(): void
    {
        $question = 'Are you sure?';

        $this->decorator->expects($this->once())
            ->method('decorate')
            ->willReturn($question);

        $this->output->expects($this->once())
            ->method('writeLine')
            ->willThrowException(new OutputException());

        $this->expectException(ConfirmException::class);
        $this->confirm->confirm($question, ['y', 'yes']);
    }

    public function testShouldThrowOnInputException(): void
    {
        $question = 'Are you sure?';

        $this->decorator->expects($this->once())
            ->method('decorate')
            ->willReturn($question);

        $this->input->expects($this->once())
            ->method('read')
            ->willThrowException(new InputException());

        $this->expectException(ConfirmException::class);
        $this->confirm->confirm($question, ['y', 'yes']);
    }
}
