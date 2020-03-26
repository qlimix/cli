<?php declare(strict_types=1);

namespace Qlimix\Tests\Cli\Command\Input;

use PHPUnit\Framework\TestCase;
use Qlimix\Cli\Command\Argument;
use Qlimix\Cli\Command\Command;
use Qlimix\Cli\Command\CommandInterface;
use Qlimix\Cli\Command\Input\CommandInput;
use Qlimix\Cli\Command\Input\Exception\ArgumentNotFoundException;
use Qlimix\Cli\Command\Input\Exception\OptionNotFoundException;
use Qlimix\Cli\Command\Input\Input;
use Qlimix\Cli\Command\Input\InputArgument;
use Qlimix\Cli\Command\Input\InputOption;
use Qlimix\Cli\Command\Name;
use Qlimix\Cli\Command\Option;
use Qlimix\Cli\Command\Value;

final class CommandInputTest extends TestCase
{
    private Input $input;

    private CommandInput $commandInput;

    protected function setUp(): void
    {
        $name = new Name('test');
        $commandExec = $this->createMock(CommandInterface::class);
        $arguments = [new Argument('test', 'foo', true, false)];
        $options = [
            new Option(
                'opt1',
                'a',
                'opt1',
                new Value(true, true, 'opt-default1'),
                false
            ),
            new Option(
                'opt2',
                'b',
                'opt2',
                new Value(true, true, 'opt-default2'),
                false
            ),
            new Option(
                'opt3',
                'c',
                'opt2',
                new Value(true, true, 'opt-default3'),
                true
            ),
            new Option(
                'opt4',
                'd',
                'opt4',
                new Value(true, true, 'opt-default4'),
                true
            ),
            new Option(
                'opt5',
                'd',
                'opt5',
                new Value(true, true, 'opt-default5'),
                true
            ),
            new Option(
                'opt6',
                'd',
                'opt6',
                new Value(false, false, 'opt-default6'),
                false
            ),
            new Option(
                'opt7',
                'd',
                'opt7',
                new Value(false, false, 'opt-default7'),
                false
            ),
        ];

        $command = new Command($name, 'default', $commandExec, $arguments, $options);

        $this->input = new Input(
            [
                new InputArgument(
                    new Argument('arg1', 'arg1', true, false),
                    'arg-value1'
                ),
                new InputArgument(
                    new Argument('arg2', 'arg2', true, false),
                    'arg-value2'
                ),
                new InputArgument(
                    new Argument('arg3', 'arg3', true, true),
                    'arg-value3'
                ),
                new InputArgument(
                    new Argument('arg3', 'arg3', true, true),
                    'arg-value4'
                ),
            ],
            [
                new InputOption(
                    new Option(
                        'opt1',
                        'a',
                        'opt1',
                        new Value(true, true, 'default-opt1'),
                        false
                    ),
                    'opt-value1'
                ),
                new InputOption(
                    new Option(
                        'opt2',
                        'b',
                        'opt2',
                        new Value(true, true, 'default-opt2'),
                        false
                    ),
                    'opt-value2'
                ),
                new InputOption(
                    new Option(
                        'opt3',
                        'b',
                        'opt3',
                        new Value(true, true, 'default-opt3'),
                        true
                    ),
                    'opt-value3'
                ),
                new InputOption(
                    new Option(
                        'opt3',
                        'b',
                        'opt3',
                        new Value(true, true, 'default-opt3'),
                        true
                    ),
                    'opt-value4'
                ),
                new InputOption(
                    new Option(
                        'opt4',
                        'b',
                        'opt4',
                        new Value(false, false, 'default-opt4'),
                        true
                    ),
                    null
                ),
                new InputOption(
                    new Option(
                        'opt6',
                        'b',
                        'opt6',
                        new Value(false, false, 'default-opt6'),
                        false
                    ),
                    null
                ),
            ],
            true
        );

        $this->commandInput = new CommandInput($command, $this->input);
    }

    public function testShouldGetArgument(): void
    {
        $argument = $this->commandInput->getArgument('arg1');

        $this->assertSame('arg-value1', $argument);
    }

    public function testShouldThrowOnNotFoundGetArgument(): void
    {
        $this->expectException(ArgumentNotFoundException::class);
        $this->commandInput->getArgument('foobar');
    }

    public function testShouldGetArguments(): void
    {
        $argument = $this->commandInput->getArrayArguments('arg3');

        $this->assertSame(['arg-value3', 'arg-value4'], $argument);
    }

    public function testShouldThrowOnNotFoundGetArguments(): void
    {
        $this->expectException(ArgumentNotFoundException::class);
        $this->commandInput->getArrayArguments('foobar');
    }

    public function testShouldGetOption(): void
    {
        $option = $this->commandInput->getOption('opt1');

        $this->assertSame('opt-value1', $option);
    }

    public function testShouldGetOptionDefaultValue(): void
    {
        $option = $this->commandInput->getOption('opt4');

        $this->assertSame('opt-default4', $option);
    }

    public function testShouldThrowOnNotFoundGetOption(): void
    {
        $this->expectException(OptionNotFoundException::class);
        $this->commandInput->getOption('foobar');
    }

    public function testShouldGetOptions(): void
    {
        $option = $this->commandInput->getArrayOptions('opt3');

        $this->assertSame(['opt-value3', 'opt-value4'], $option);
    }

    public function testShouldGetOptionsAndSkipNullValue(): void
    {
        $option = $this->commandInput->getArrayOptions('opt4');

        $this->assertSame(['opt-default4'], $option);
    }

    public function testShouldThrowOnNotFoundGetOptions(): void
    {
        $this->expectException(OptionNotFoundException::class);
        $this->commandInput->getArrayOptions('foobar');
    }

    public function testShouldReadFromInput(): void
    {
        $this->assertTrue($this->commandInput->readFromInput());
    }

    public function testOptionIsFlagged(): void
    {
        $this->assertTrue($this->commandInput->isOptionFlagged('opt6'));
    }

    public function testOptionIsNotFlagged(): void
    {
        $this->assertFalse($this->commandInput->isOptionFlagged('opt7'));
    }
}
