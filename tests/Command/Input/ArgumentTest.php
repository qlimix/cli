<?php declare(strict_types=1);

namespace Qlimix\Tests\Cli\Command\Input;

use PHPUnit\Framework\TestCase;
use Qlimix\Cli\Command\Argument;

final class ArgumentTest extends TestCase
{
    public function testShouldArgument(): void
    {
        $name = 'test';
        $description = 'test description';
        $required = true;
        $isArray = false;

        $argument = new Argument($name, $description, $required, $isArray);

        $this->assertSame($name, $argument->getName());
        $this->assertSame($description, $argument->getDescription());
        $this->assertTrue($argument->isRequired());
        $this->assertFalse($argument->isArray());
    }
}
