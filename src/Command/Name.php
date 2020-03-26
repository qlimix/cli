<?php declare(strict_types=1);

namespace Qlimix\Cli\Command;

use Qlimix\Cli\Command\Exception\InvalidNameException;
use function preg_match;

final class Name
{
    private const REGEX = '^[a-zA-Z]{1}[a-zA-Z:_-]{1,}$';

    private string $name;

    /**
     * @throws InvalidNameException
     */
    public function __construct(string $name)
    {
        $this->guard($name);
    }

    public function toString(): string
    {
        return $this->name;
    }

    /**
     * @throws InvalidNameException
     */
    private function guard(string $name): void
    {
        if (!preg_match('~'.self::REGEX.'~', $name)) {
            throw new InvalidNameException('Invalid command name');
        }

        $this->name = $name;
    }
}
