<?php declare(strict_types=1);

namespace Qlimix\Tests\Cli\Command\Input\Parser;

use PHPUnit\Framework\TestCase;
use Qlimix\Cli\Command\Input\Parser\CliArgument;

final class CliArgumentTest extends TestCase
{
    /**
     * @dataProvider longOptionProvider
     */
    public function testShouldBeLongOption(string $value): void
    {
        $argument = new CliArgument($value);

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
        $argument = new CliArgument($value);

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
        $argument = new CliArgument('-');

        $this->assertTrue($argument->isReadInput());
    }

    public function testShouldBeNoMoreOptions(): void
    {
        $argument = new CliArgument('--');

        $this->assertTrue($argument->isNoMoreOptions());
    }

    public function testShouldBeOptionValue(): void
    {
        $argument = new CliArgument('value');

        $this->assertTrue($argument->isOptionValue());
    }

    public function testShouldNotBeOptionValue(): void
    {
        $argument = new CliArgument('--value');

        $this->assertFalse($argument->isOptionValue());
    }

    public function testShouldConvertToString(): void
    {
        $value = '--value';
        $argument = new CliArgument($value);

        $this->assertSame($value, $argument->toString());
    }
}
