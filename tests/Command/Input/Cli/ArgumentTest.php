<?php declare(strict_types=1);

namespace Qlimix\Tests\Cli\Command\Input\Cli;

use PHPUnit\Framework\TestCase;
use Qlimix\Cli\Command\Input\Cli\Argument;

final class ArgumentTest extends TestCase
{
    /**
     * @dataProvider longOptionProvider
     */
    public function testShouldBeLongOption(string $value): void
    {
        $argument = new Argument($value);

        $this->assertTrue($argument->isLongOption());
    }

    /**
     * @return array<int, array<int, string>>
     */
    public function longOptionProvider(): array
    {
        return [
            ['--foo'],
            ['--foo="test"'],
            ['--foo test'],
        ];
    }

    /**
     * @dataProvider shortOptionProvider
     */
    public function testShouldBeShortOption(string $value): void
    {
        $argument = new Argument($value);

        $this->assertTrue($argument->isShortOption());
    }

    /**
     * @return array<int, array<int, string>>
     */
    public function shortOptionProvider(): array
    {
        return [
            ['-f'],
            ['-f test'],
            ['-fv'],
        ];
    }

    public function testShouldBeReadInput(): void
    {
        $argument = new Argument('-');

        $this->assertTrue($argument->isReadInput());
    }

    public function testShouldBeNoMoreOptions(): void
    {
        $argument = new Argument('--');

        $this->assertTrue($argument->isNoMoreOptions());
    }

    public function testShouldBeOptionValue(): void
    {
        $argument = new Argument('value');

        $this->assertTrue($argument->isOptionValue());
    }

    public function testShouldNotBeOptionValue(): void
    {
        $argument = new Argument('--value');

        $this->assertFalse($argument->isOptionValue());
    }

    public function testShouldConvertToString(): void
    {
        $value = '--value';
        $argument = new Argument($value);

        $this->assertSame($value, $argument->toString());
    }
}
