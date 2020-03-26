<?php declare(strict_types=1);

namespace Qlimix\Tests\Cli\Command\Usage;

use PHPUnit\Framework\TestCase;
use Qlimix\Cli\Command\Argument;
use Qlimix\Cli\Command\Command;
use Qlimix\Cli\Command\CommandInterface;
use Qlimix\Cli\Command\Name;
use Qlimix\Cli\Command\Option;
use Qlimix\Cli\Command\Usage\DefaultUsage;
use Qlimix\Cli\Command\Value;

final class DefaultUsageTest extends TestCase
{
    public function testShouldDisplay(): void
    {
        $command = new Command(
            new Name('default'),
            'foobar',
            $this->createMock(CommandInterface::class),
            [
                new Argument('foo', 'foo', true, false),
                new Argument('bar', 'bar', true, true),
            ],
            [
                new Option(
                    'verbose',
                    'v',
                    'verbose',
                    new Value(true, true, '1'),
                    false
                ),
                new Option(
                    'help',
                    'h',
                    'Help description',
                    new Value(false, false, null),
                    false
                ),
                new Option(
                    'file',
                    'f',
                    'file path',
                    new Value(true, true, null),
                    true
                ),
            ]
        );

        $output = <<<OUTPUT
Usage: default
foobar

Arguments:
	foo - foo
	bar... - bar

Options:
	--verbose -v [default: 1]
		verbose
	--help -h
		Help description
	--file -f...
		file path
OUTPUT;


        $usage = new DefaultUsage();

        $this->assertSame($output, $usage->usage($command));
    }
}
