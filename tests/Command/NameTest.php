<?php declare(strict_types=1);

namespace Qlimix\Tests\Cli\Command;

use PHPUnit\Framework\TestCase;
use Qlimix\Cli\Command\Exception\InvalidNameException;
use Qlimix\Cli\Command\Name;

final class NameTest extends TestCase
{
    public function testShouldName(): void
    {
        $nameValue = 'foo';
        $name = new Name($nameValue);

        $this->assertSame($nameValue, $name->toString());
    }

    /**
     * @dataProvider provideInvalidNames
     */
    public function testShouldThrowOnInvalidName(string $name): void
    {
        $this->expectException(InvalidNameException::class);
        new Name($name);
    }

    public function provideInvalidNames(): array
    {
        return [
            ['name' => '_abc'],
            ['name' => ';'],
            ['name' => 'foo|bar'],
            ['name' => '123'],
        ];
    }
}
