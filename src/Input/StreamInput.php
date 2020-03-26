<?php declare(strict_types=1);

namespace Qlimix\Cli\Input;

use Qlimix\Cli\Input\Exception\InputException;
use function fread;
use function stream_get_contents;
use function trim;

final class StreamInput implements InputInterface
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
    public function read(int $length): string
    {
        $input = @fread($this->stream, $length);

        if ($input === false) {
            throw new InputException('failed to read from stream');
        }

        return trim($input);
    }

    /**
     * @inheritDoc
     */
    public function readAll(): string
    {
        $input = @stream_get_contents($this->stream);

        if ($input === false) {
            throw new InputException('failed to readAll from stream');
        }

        return trim($input);
    }
}
