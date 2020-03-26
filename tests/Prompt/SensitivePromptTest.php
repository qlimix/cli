<?php declare(strict_types=1);

namespace Qlimix\Tests\Cli\Prompt;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Qlimix\Cli\Input\Exception\InputException;
use Qlimix\Cli\Input\Hidden\HiddenInterface;
use Qlimix\Cli\Input\InputInterface;
use Qlimix\Cli\Output\Exception\OutputException;
use Qlimix\Cli\Output\OutputInterface;
use Qlimix\Cli\Prompt\Confirm;
use Qlimix\Cli\Prompt\Decorator\DecoratorInterface;
use Qlimix\Cli\Prompt\Exception\ConfirmException;
use Qlimix\Cli\Prompt\Exception\PromptException;
use Qlimix\Cli\Prompt\SensitivePrompt;

final class SensitivePromptTest extends TestCase
{
    private MockObject $decorator;

    private InputInterface $input;

    private OutputInterface $output;

    private HiddenInterface $hidden;

    private SensitivePrompt $prompt;

    protected function setUp(): void
    {
        $this->decorator = $this->createMock(DecoratorInterface::class);
        $this->input = $this->createMock(InputInterface::class);
        $this->output = $this->createMock(OutputInterface::class);
        $this->hidden = $this->createMock(HiddenInterface::class);

        $this->prompt = new SensitivePrompt($this->decorator, $this->input, $this->output, $this->hidden);
    }

    public function testShouldPrompt(): void
    {
        $question = 'Password:';
        $password = '1234';

        $this->decorator->expects($this->once())
            ->method('decorate')
            ->willReturn($question);

        $this->hidden->expects($this->once())
            ->method('hide');

        $this->output->expects($this->once())
            ->method('writeLine')
            ->with($this->callback(static function (string $text) use ($question) {
                return $text === $question;
            }));

        $this->input->expects($this->once())
            ->method('read')
            ->willReturn($password);

        $this->hidden->expects($this->once())
            ->method('show');

        $this->assertSame($password, $this->prompt->prompt($question));
    }

    public function testShouldThrowOnOutputException(): void
    {
        $question = 'Password:';

        $this->decorator->expects($this->once())
            ->method('decorate')
            ->willReturn($question);

        $this->output->expects($this->once())
            ->method('writeLine')
            ->willThrowException(new OutputException());

        $this->expectException(PromptException::class);
        $this->prompt->prompt($question);
    }

    public function testShouldThrowOnInputException(): void
    {
        $question = 'Password:';

        $this->decorator->expects($this->once())
            ->method('decorate')
            ->willReturn($question);

        $this->input->expects($this->once())
            ->method('read')
            ->willThrowException(new InputException());

        $this->expectException(PromptException::class);
        $this->prompt->prompt($question);
    }
}
