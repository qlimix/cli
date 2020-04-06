<?php declare(strict_types=1);

namespace Qlimix\Tests\Cli\Command\Input\Cli;

use PHPUnit\Framework\TestCase;
use Qlimix\Cli\Command\Input\Cli\Argument;
use Qlimix\Cli\Command\Input\Cli\Arguments;
use Qlimix\Cli\Command\Input\Parser\Exception\ArgumentsException;

final class ArgumentsTest extends TestCase
{
    public function testShouldNext(): void
    {
        $foo = 'foo';
        $bar = 'bar';

        $cliArgument = new Arguments([
            new Argument('foo'),
            new Argument('bar'),
        ]);

        $this->assertSame($foo, $cliArgument->next()->toString());
        $this->assertSame($bar, $cliArgument->next()->toString());

        $this->expectException(ArgumentsException::class);
        $cliArgument->next();
    }

    public function testShouldThrowOnNothingMoreToNext(): void
    {
        $cliArgument = new Arguments([]);
        $this->expectException(ArgumentsException::class);
        $cliArgument->next();
    }

    public function testShouldPeek(): void
    {
        $foo = 'foo';

        $cliArgument = new Arguments([
            new Argument('foo'),
        ]);

        $this->assertSame($foo, $cliArgument->peek()->toString());
        $this->assertSame($foo, $cliArgument->next()->toString());

        $this->expectException(ArgumentsException::class);
        $cliArgument->peek();
    }

    public function testShouldThrowOnNothingMoreToPeek(): void
    {
        $cliArgument = new Arguments([]);

        $this->expectException(ArgumentsException::class);
        $cliArgument->peek();
    }
}
