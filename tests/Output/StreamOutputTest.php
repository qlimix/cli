<?php declare(strict_types=1);

namespace Qlimix\Tests\Cli\Output;

use PHPUnit\Framework\TestCase;
use Qlimix\Cli\Output\Exception\OutputException;
use Qlimix\Cli\Output\StreamOutput;

final class StreamOutputTest extends TestCase
{
    public function testShouldOutput(): void
    {
        $stream = fopen('php://memory', 'w+b');
        $output = new StreamOutput($stream);

        $toRead = 'foobar';

        $output->write($toRead);

        rewind($stream);

        $this->assertSame($toRead, fread($stream, strlen($toRead)));
    }

    public function testShouldThrowOnClosedStream(): void
    {
        $stream = fopen('php://memory', 'w+b');
        $output = new StreamOutput($stream);

        $toRead = 'foobar';

        fclose($stream);

        $this->expectException(OutputException::class);
        $output->write($toRead);
    }

    public function testShouldOutputNewline(): void
    {
        $stream = fopen('php://memory', 'w+b');
        $output = new StreamOutput($stream);

        $toRead = 'foobar';

        $output->writeLine($toRead);

        rewind($stream);

        $this->assertSame($toRead.PHP_EOL, fread($stream, strlen($toRead.PHP_EOL)));
    }

    public function testShouldThrowOnOutputNewLineClosedStream(): void
    {
        $stream = fopen('php://memory', 'w+b');
        $output = new StreamOutput($stream);

        $toRead = 'foobar';

        fclose($stream);

        $this->expectException(OutputException::class);
        $output->writeLine($toRead);
    }
}
