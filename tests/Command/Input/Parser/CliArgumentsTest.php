<?php declare(strict_types=1);

namespace Qlimix\Tests\Cli\Command\Input\Parser;

use PHPUnit\Framework\TestCase;
use Qlimix\Cli\Command\Input\Parser\CliArgument;
use Qlimix\Cli\Command\Input\Parser\CliArguments;
use Qlimix\Cli\Command\Input\Parser\Exception\ArgumentsException;

final class CliArgumentsTest extends TestCase
{
    public function testShouldNext(): void
    {
        $foo = 'foo';
        $bar = 'bar';

        $cliArgument = new CliArguments([
            new CliArgument('foo'),
            new CliArgument('bar'),
        ]);

        $this->assertSame($foo, $cliArgument->next()->toString());
        $this->assertSame($bar, $cliArgument->next()->toString());

        $this->expectException(ArgumentsException::class);
        $cliArgument->next();
    }

    public function testShouldThrowOnNothingMoreToNext(): void
    {
        $cliArgument = new CliArguments([]);
        $this->expectException(ArgumentsException::class);
        $cliArgument->next();
    }

    public function testShouldPeek(): void
    {
        $foo = 'foo';

        $cliArgument = new CliArguments([
            new CliArgument('foo'),
        ]);

        $this->assertSame($foo, $cliArgument->peek()->toString());
        $this->assertSame($foo, $cliArgument->next()->toString());

        $this->expectException(ArgumentsException::class);
        $cliArgument->peek();
    }

    public function testShouldThrowOnNothingMoreToPeek(): void
    {
        $cliArgument = new CliArguments([]);

        $this->expectException(ArgumentsException::class);
        $cliArgument->peek();
    }
}
