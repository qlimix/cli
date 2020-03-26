<?php declare(strict_types=1);

namespace Qlimix\Tests\Cli\Command;

use PHPUnit\Framework\TestCase;
use Qlimix\Cli\Command\Option;
use Qlimix\Cli\Command\Value;

final class OptionTest extends TestCase
{
    public function testShouldOption(): void
    {
        $name = 'foo';
        $short = 'f';
        $description = 'foo to bar';
        $value = new Value(false, false, 'opt-default7');
        $isArray = false;

        $option = new Option($name, $short, $description, $value, $isArray);

        $this->assertSame($name, $option->getName());
        $this->assertSame($short, $option->getShort());
        $this->assertSame($description, $option->getDescription());
        $this->assertSame($value, $option->getValue());
        $this->assertSame($isArray, $option->isArray());
    }
}
