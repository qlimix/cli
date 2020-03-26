<?php declare(strict_types=1);

namespace Qlimix\Tests\Cli\Command\Input;

use PHPUnit\Framework\TestCase;
use Qlimix\Cli\Command\Input\InputOption;
use Qlimix\Cli\Command\Option;
use Qlimix\Cli\Command\Value;

final class InputOptionTest extends TestCase
{
    public function testShouldInputOption(): void
    {
        $option = new Option(
            'opt1',
            'a',
            'opt1',
            new Value(true, true, 'default-opt1'),
            false
        );

        $inputOption = new InputOption($option, 'opt-value1');

        $this->assertTrue($inputOption->isOption($option));
        $this->assertSame($option, $inputOption->getOption());
        $this->assertSame('opt-value1', $inputOption->getValue());
    }
}
