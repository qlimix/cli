<?php declare(strict_types=1);

namespace Qlimix\Tests\Cli\Command\Input;

use PHPUnit\Framework\TestCase;
use Qlimix\Cli\Command\Argument;
use Qlimix\Cli\Command\Input\InputArgument;

final class InputArgumentTest extends TestCase
{
    public function testShouldInputArgument(): void
    {
        $argument = new Argument('arg1', 'arg1', true, false);
        $inputArgument = new InputArgument($argument, 'arg-value1');

        $this->assertSame('arg-value1', $inputArgument->getValue());
        $this->assertSame($argument, $inputArgument->getArgument());
        $this->assertTrue($inputArgument->isArgument($argument));
    }
}
