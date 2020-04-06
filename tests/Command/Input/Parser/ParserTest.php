<?php declare(strict_types=1);

namespace Qlimix\Tests\Cli\Command\Input\Parser;

use PHPUnit\Framework\TestCase;
use Qlimix\Cli\Command\Command;
use Qlimix\Cli\Command\CommandInterface;
use Qlimix\Cli\Command\Input\Cli\Argument;
use Qlimix\Cli\Command\Input\Cli\Arguments;
use Qlimix\Cli\Command\Input\Parser\Exception\ParserException;
use Qlimix\Cli\Command\Input\Parser\Parser;
use Qlimix\Cli\Command\Name;
use Qlimix\Cli\Command\Option;
use Qlimix\Cli\Command\Value;

final class ParserTest extends TestCase
{
    public function testShouldParseArgument(): void
    {
        $parser = new Parser(new Arguments([
            new Argument('foo'),
            new Argument('bar')
        ]));

        $command = new Command(
            new Name('default'),
            'default',
            $this->createMock(CommandInterface::class),
            [
                new \Qlimix\Cli\Command\Argument('foo', 'foo', true, false),
                new \Qlimix\Cli\Command\Argument('bar', 'bar', true, false),
            ],
            []
        );

        $input = $parser->parse($command);

        $this->assertSame('foo', $input->getArgument('foo'));
        $this->assertSame('bar', $input->getArgument('bar'));
    }

    public function testShouldParseShortOption(): void
    {
        $parser = new Parser(new Arguments([
            new Argument('-v')
        ]));

        $command = new Command(
            new Name('default'),
            'default',
            $this->createMock(CommandInterface::class),
            [],
            [
                new Option(
                    'verbose',
                    'v',
                    'verbose',
                    new Value(true, true, '1'),
                    false
                )
            ]
        );

        $input = $parser->parse($command);

        $this->assertSame('1', $input->getOption('verbose'));
    }

    public function testShouldParseLongOption(): void
    {
        $parser = new Parser(new Arguments([
            new Argument('--verbose'),
            new Argument('1'),
        ]));

        $command = new Command(
            new Name('default'),
            'default',
            $this->createMock(CommandInterface::class),
            [],
            [
                new Option(
                    'verbose',
                    'v',
                    'verbose',
                    new Value(true, true, '1'),
                    false
                )
            ]
        );

        $input = $parser->parse($command);

        $this->assertSame('1', $input->getOption('verbose'));
    }

    public function testShouldParseLongOptionEqualQuoted(): void
    {
        $parser = new Parser(new Arguments([
            new Argument('--verbose="1"')
        ]));

        $command = new Command(
            new Name('default'),
            'default',
            $this->createMock(CommandInterface::class),
            [],
            [
                new Option(
                    'verbose',
                    'v',
                    'verbose',
                    new Value(true, true, '1'),
                    false
                )
            ]
        );

        $input = $parser->parse($command);

        $this->assertSame('1', $input->getOption('verbose'));
    }

    public function testShouldNoMoreOptionsShouldIgnoreGetDefault(): void
    {
        $parser = new Parser(new Arguments([
            new Argument('--'),
            new Argument('--verbose="2"'),
        ]));

        $command = new Command(
            new Name('default'),
            'default',
            $this->createMock(CommandInterface::class),
            [],
            [
                new Option(
                    'verbose',
                    'v',
                    'verbose',
                    new Value(true, true, '1'),
                    false
                )
            ]
        );

        $input = $parser->parse($command);

        $this->assertSame('1', $input->getOption('verbose'));
    }

    public function testShouldReadFromInput(): void
    {
        $parser = new Parser(new Arguments([
            new Argument('-'),
        ]));

        $command = new Command(
            new Name('default'),
            'default',
            $this->createMock(CommandInterface::class),
            [],
            []
        );

        $input = $parser->parse($command);

        $this->assertTrue($input->readFromInput());
    }

    public function testShouldParseMultipleShortOptions(): void
    {
        $parser = new Parser(new Arguments([
            new Argument('-cba'),
        ]));

        $command = new Command(
            new Name('default'),
            'default',
            $this->createMock(CommandInterface::class),
            [],
            [
                new Option(
                    'foo',
                    'a',
                    'foo',
                    new Value(true, true, 'foo'),
                    false
                ),
                new Option(
                    'bar',
                    'b',
                    'bar',
                    new Value(true, true, 'bar'),
                    false
                ),
                new Option(
                    'foobar',
                    'c',
                    'foobar',
                    new Value(true, true, 'foobar'),
                    false
                ),
            ]
        );

        $input = $parser->parse($command);

        $this->assertSame('foo', $input->getOption('foo'));
        $this->assertSame('bar', $input->getOption('bar'));
        $this->assertSame('foobar', $input->getOption('foobar'));
    }

    public function testShouldThrowOnUnknownShortOption(): void
    {
        $parser = new Parser(new Arguments([
            new Argument('-a'),
        ]));

        $command = new Command(
            new Name('default'),
            'default',
            $this->createMock(CommandInterface::class),
            [],
            []
        );

        $this->expectException(ParserException::class);
        $parser->parse($command);
    }

    public function testShouldThrowOnUnknownLongOption(): void
    {
        $parser = new Parser(new Arguments([
            new Argument('--does-not-exist'),
        ]));

        $command = new Command(
            new Name('default'),
            'default',
            $this->createMock(CommandInterface::class),
            [],
            []
        );

        $this->expectException(ParserException::class);
        $parser->parse($command);
    }

    public function testShouldFlagOption(): void
    {
        $parser = new Parser(new Arguments([
            new Argument('--verbose'),
        ]));

        $command = new Command(
            new Name('default'),
            'default',
            $this->createMock(CommandInterface::class),
            [],
            [
                new Option(
                    'verbose',
                    'v',
                    'verbose',
                    new Value(false, false, ''),
                    false
                )
            ]
        );

        $input = $parser->parse($command);
        $this->assertTrue($input->isOptionFlagged('verbose'));
    }

    public function testShouldThrowOnMoreArgumentsThanForGivenCommand(): void
    {
        $parser = new Parser(new Arguments([
            new Argument('foo'),
            new Argument('bar'),
            new Argument('oof'),
            new Argument('rab'),
        ]));

        $command = new Command(
            new Name('default'),
            'default',
            $this->createMock(CommandInterface::class),
            [
                new \Qlimix\Cli\Command\Argument('foo', 'foo', true, false),
            ],
            []
        );

        $this->expectException(ParserException::class);
        $parser->parse($command);
    }

    public function testShouldReturnLongOptionArray(): void
    {
        $parser = new Parser(new Arguments([
            new Argument('--file="1"'),
            new Argument('--file="2"'),
        ]));

        $command = new Command(
            new Name('default'),
            'default',
            $this->createMock(CommandInterface::class),
            [],
            [
                new Option(
                    'file',
                    'f',
                    'file',
                    new Value(true, true, '1'),
                    true
                )
            ]
        );

        $input = $parser->parse($command);

        $files = $input->getArrayOptions('file');
        $this->assertSame('1', $files[0]);
        $this->assertSame('2', $files[1]);
    }

    public function testShouldReturnShortOptionArray(): void
    {
        $parser = new Parser(new Arguments([
            new Argument('--file'),
            new Argument('1'),
            new Argument('--file'),
            new Argument('2'),
        ]));

        $command = new Command(
            new Name('default'),
            'default',
            $this->createMock(CommandInterface::class),
            [],
            [
                new Option(
                    'file',
                    'f',
                    'file',
                    new Value(true, true, '1'),
                    true
                )
            ]
        );

        $input = $parser->parse($command);

        $files = $input->getArrayOptions('file');
        $this->assertSame('1', $files[0]);
        $this->assertSame('2', $files[1]);
    }

    public function testShouldReturnArgumentArray(): void
    {
        $parser = new Parser(new Arguments([
            new Argument('foo'),
            new Argument('bar'),
        ]));

        $command = new Command(
            new Name('default'),
            'default',
            $this->createMock(CommandInterface::class),
            [
                new \Qlimix\Cli\Command\Argument('foo', 'foo', true, true),
            ],
            []
        );

        $input = $parser->parse($command);

        $foo = $input->getArrayArguments('foo');
        $this->assertSame('foo', $foo[0]);
        $this->assertSame('bar', $foo[1]);
    }

    public function testShouldTakeDefaultOverNextArgument(): void
    {
        $parser = new Parser(new Arguments([
            new Argument('--verbose'),
            new Argument('-h')
        ]));

        $command = new Command(
            new Name('default'),
            'default',
            $this->createMock(CommandInterface::class),
            [],
            [
                new Option(
                    'verbose',
                    'v',
                    'verbose',
                    new Value(true, false, '1'),
                    false
                ),
                new Option(
                    'help',
                    'h',
                    'help',
                    new Value(true, false, 'h'),
                    false
                )
            ]
        );

        $input = $parser->parse($command);
        $this->assertSame('1', $input->getOption('verbose'));
        $this->assertSame('h', $input->getOption('help'));
    }
}
