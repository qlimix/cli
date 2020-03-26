<?php declare(strict_types=1);

namespace Qlimix\Cli\Output;

use Qlimix\Cli\Output\Exception\OutputException;
use function fwrite;
use const PHP_EOL;

final class StreamOutput implements OutputInterface
{
    /** @var resource */
    private $stream;

    /**
     * @param resource $stream
     */
    public function __construct($stream)
    {
        $this->stream = $stream;
    }

    /**
     * @inheritDoc
     */
    public function write(string $text): void
    {
        if (@fwrite($this->stream, $text) === false) {
            throw new OutputException('Couldn\'t write to stream');
        }
    }

    /**
     * @inheritDoc
     */
    public function writeLine(string $text): void
    {
        if (@fwrite($this->stream, $text.PHP_EOL) === false) {
            throw new OutputException('Couldn\'t write to stream');
        }
    }
}
