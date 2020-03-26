<?php declare(strict_types=1);

namespace Qlimix\Tests\Cli\Command;

use PHPUnit\Framework\TestCase;
use Qlimix\Cli\Command\Value;

final class ValueTest extends TestCase
{
    public function testShouldValue(): void
    {
        $has = true;
        $required = true;
        $default = 'foo';

        $value = new Value($has, $required, $default);

        $this->assertSame($has, $value->has());
        $this->assertSame($required, $value->isRequired());
        $this->assertSame($default, $value->getDefault());
    }
}
