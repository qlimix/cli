<?php declare(strict_types=1);

namespace Qlimix\Tests\Cli\Command\Input\Validator;

use PHPUnit\Framework\TestCase;
use Qlimix\Cli\Command\Argument;
use Qlimix\Cli\Command\Command;
use Qlimix\Cli\Command\CommandInterface;
use Qlimix\Cli\Command\Input\Input;
use Qlimix\Cli\Command\Input\InputArgument;
use Qlimix\Cli\Command\Input\InputOption;
use Qlimix\Cli\Command\Input\Validator\Exception\ArgumentMissingException;
use Qlimix\Cli\Command\Input\Validator\Exception\OptionValueRequiredException;
use Qlimix\Cli\Command\Input\Validator\Validator;
use Qlimix\Cli\Command\Name;
use Qlimix\Cli\Command\Option;
use Qlimix\Cli\Command\Value;

final class ValidatorTest extends TestCase
{
    private Validator $validator;

    protected function setUp(): void
    {
        $this->validator = new Validator();
    }

    public function testShouldValidate(): void
    {
        $name = new Name('test');
        $commandExec = $this->createMock(CommandInterface::class);
        $arguments = [
            new Argument('arg1', 'arg1', true, false),
            new Argument('arg2', 'arg2', true, false),
        ];

        $options = [
            new Option(
                'opt1',
                'a',
                'opt1',
                new Value(true, true, 'opt-default1'),
                false
            ),
        ];

        $command = new Command($name, 'default', $commandExec, $arguments, $options);

        $input = new Input(
            [
                new InputArgument(
                    new Argument('arg1', 'arg1', true, false),
                    'arg-value1'
                ),
                new InputArgument(
                    new Argument('arg2', 'arg2', true, false),
                    'arg-value2'
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
            ],
            true
        );

        $this->validator->validate($command, $input);
        $this->addToAssertionCount(1);
    }

    public function testShouldValidateArgumentsArray(): void
    {
        $name = new Name('test');
        $commandExec = $this->createMock(CommandInterface::class);
        $arguments = [
            new Argument('arg1', 'arg1', true, false),
            new Argument('arg2', 'arg2', true, true),
        ];

        $options = [];

        $command = new Command($name, 'default', $commandExec, $arguments, $options);

        $input = new Input(
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
                    new Argument('arg2', 'arg2', true, false),
                    'arg-value3'
                ),
            ],
            [],
            true
        );

        $this->validator->validate($command, $input);
        $this->addToAssertionCount(1);
    }

    public function testShouldThrowOnArgumentMissing(): void
    {
        $name = new Name('test');
        $commandExec = $this->createMock(CommandInterface::class);
        $arguments = [
            new Argument('arg1', 'arg1', true, false),
        ];

        $options = [];

        $command = new Command($name, 'default', $commandExec, $arguments, $options);

        $input = new Input(
            [],
            [],
            true
        );

        $this->expectException(ArgumentMissingException::class);
        $this->validator->validate($command, $input);
    }

    public function testShouldThrowOnArgumentArrayMissing(): void
    {
        $name = new Name('test');
        $commandExec = $this->createMock(CommandInterface::class);
        $arguments = [
            new Argument('arg1', 'arg1', true, false),
            new Argument('arg2', 'arg2', true, true),
        ];

        $options = [];

        $command = new Command($name, 'default', $commandExec, $arguments, $options);

        $input = new Input(
            [
                new InputArgument(
                    new Argument('arg1', 'arg1', true, false),
                    'arg-value1'
                ),
            ],
            [],
            true
        );

        $this->expectException(ArgumentMissingException::class);
        $this->validator->validate($command, $input);
    }

    public function testShouldValidateOptionsArray(): void
    {
        $name = new Name('test');
        $commandExec = $this->createMock(CommandInterface::class);
        $arguments = [];

        $options = [
            new Option(
                'opt1',
                'a',
                'opt1',
                new Value(true, true, 'opt-default1'),
                false
            ),
        ];

        $command = new Command($name, 'default', $commandExec, $arguments, $options);

        $input = new Input(
            [],
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
            ],
            true
        );

        $this->validator->validate($command, $input);
        $this->addToAssertionCount(1);
    }

    public function testShouldThrowOnOptionMissing(): void
    {
        $name = new Name('test');
        $commandExec = $this->createMock(CommandInterface::class);
        $arguments = [];

        $options = [
            new Option(
                'opt1',
                'a',
                'opt1',
                new Value(true, true, 'opt-default1'),
                false
            ),
        ];

        $command = new Command($name, 'default', $commandExec, $arguments, $options);

        $input = new Input(
            [],
            [],
            true
        );

        $this->expectException(OptionValueRequiredException::class);
        $this->validator->validate($command, $input);
    }

    public function testShouldThrowOnOptionArrayMissing(): void
    {
        $name = new Name('test');
        $commandExec = $this->createMock(CommandInterface::class);
        $arguments = [];

        $options = [
            new Option(
                'opt1',
                'a',
                'opt1',
                new Value(true, true, 'opt-default1'),
                true
            ),
        ];

        $command = new Command($name, 'default', $commandExec, $arguments, $options);

        $input = new Input(
            [],
            [],
            true
        );

        $this->expectException(OptionValueRequiredException::class);
        $this->validator->validate($command, $input);
    }
}
