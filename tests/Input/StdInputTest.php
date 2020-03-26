<?php declare(strict_types=1);

namespace Qlimix\Tests\Cli\Input;

use PHPUnit\Framework\TestCase;
use Qlimix\Cli\Input\Exception\InputException;
use Qlimix\Cli\Input\StreamInput;

final class StdInputTest extends TestCase
{
    public function testShouldReadInput(): void
    {
        $stream = fopen('php://memory', 'w+b');
        $input = new StreamInput($stream);

        $toRead = 'foobar';

        fwrite($stream, $toRead);
        rewind($stream);

        $this->assertSame($toRead, $input->read(strlen($toRead)));
    }

    public function testShouldThrowOnClosedStream(): void
    {
        $stream = fopen('php://memory', 'w+b');
        $input = new StreamInput($stream);

        $toRead = 'foobar';

        fwrite($stream, $toRead);
        fclose($stream);

        $this->expectException(InputException::class);
        $input->read(strlen($toRead));
    }

    public function testShouldReadAllInput(): void
    {
        $stream = fopen('php://memory', 'w+b');
        $input = new StreamInput($stream);

        $toRead = <<<TEXT
Lorem ipsum dolor sit amet, consectetur adipiscing elit.
Suspendisse dolor dui, vehicula vitae pretium eget, iaculis in mauris.
In tristique consequat ex.
Curabitur ornare, augue et sollicitudin ornare, ante arcu semper arcu, a sollicitudin sapien tellus eu metus.
Maecenas vulputate sapien mauris, quis laoreet magna egestas ac.
Sed cursus malesuada nunc, sit amet elementum justo mollis vel.
Curabitur mollis justo ex, non auctor urna tempor ut.
Cras posuere facilisis mauris in posuere. Sed ante augue, tempor non pulvinar eget, tincidunt ut odio.
TEXT;

        fwrite($stream, $toRead);
        rewind($stream);

        $this->assertSame($toRead, $input->readAll(strlen($toRead)));
    }

    public function testShouldThrowOnClosedStreamReadAll(): void
    {
        $stream = fopen('php://memory', 'w+b');
        $input = new StreamInput($stream);

        $toRead = 'foobar';

        fwrite($stream, $toRead);
        fclose($stream);

        $this->expectException(InputException::class);
        $input->readAll(strlen($toRead));
    }
}
