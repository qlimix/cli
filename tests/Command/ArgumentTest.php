<?php declare(strict_types=1);

namespace Qlimix\Tests\Cli\Command;

use PHPUnit\Framework\TestCase;
use Qlimix\Cli\Command\Argument;

final class ArgumentTest extends TestCase
{
    public function testShouldArgument(): void
    {
        $name = 'foo';
        $description = 'foo about foo';
        $required = true;
        $isArray = false;

        $argument = new Argument($name, $description, $required, $isArray);

        $this->assertSame($name, $argument->getName());
        $this->assertSame($description, $argument->getDescription());
        $this->assertSame($required, $argument->isRequired());
        $this->assertSame($isArray, $argument->isArray());
    }
}
