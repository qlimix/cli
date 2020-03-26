<?php declare(strict_types=1);

namespace Qlimix\Tests\Cli\Command\Input;

use PHPUnit\Framework\TestCase;
use Qlimix\Cli\Command\Argument;
use Qlimix\Cli\Command\Input\Input;
use Qlimix\Cli\Command\Input\InputArgument;
use Qlimix\Cli\Command\Input\InputOption;
use Qlimix\Cli\Command\Option;
use Qlimix\Cli\Command\Value;
use function count;

final class InputTest extends TestCase
{
    /** @var InputArgument[]  */
    private array $arguments;

    /** @var InputOption[] */
    private array $options;

    private Input $input;

    protected function setUp(): void
    {
        $this->arguments = [
            new InputArgument(
                new Argument('arg1', 'arg1', true, false),
                'arg-value1'
            )
        ];

        $this->options = [
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
                null
            )
        ];

        $this->input = new Input($this->arguments, $this->options, true);
    }

    public function testShouldHaveArgument(): void
    {
        $this->assertTrue(
            $this->input->hasArgument(new Argument('arg1', 'arg1', true, false))
        );
    }

    public function testShouldNotHaveArgument(): void
    {
        $this->assertFalse(
            $this->input->hasArgument(new Argument('arg2', 'arg1', true, false))
        );
    }

    public function testShouldHaveOptionWithValue(): void
    {
        $this->assertTrue(
            $this->input->hasOptionWithValue(
                new Option(
                    'opt1',
                    'a',
                    'opt1',
                    new Value(true, true, 'default-opt1'),
                    false
                )
            )
        );
    }

    public function testShouldNotHaveOptionWithValue(): void
    {
        $this->assertFalse(
            $this->input->hasOptionWithValue(
                new Option(
                    'opt2',
                    'a',
                    'opt2',
                    new Value(true, true, 'default-opt1'),
                    false
                )
            )
        );
    }

    public function testShouldGet(): void
    {
        $this->assertCount(count($this->arguments) ,$this->input->getArguments());
        $this->assertCount(count($this->options) ,$this->input->getOptions());
    }

    public function testIsReadFromInput(): void
    {
        $this->assertTrue($this->input->isReadFromInput());
    }
}
