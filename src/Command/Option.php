<?php declare(strict_types=1);

namespace Qlimix\Cli\Command;

final class Option
{
    private string $name;

    private string $short;

    private string $description;

    private Value $value;

    private bool $isArray;

    public function __construct(string $name, string $short, string $description, Value $value, bool $isArray)
    {
        $this->name = $name;
        $this->short = $short;
        $this->description = $description;
        $this->value = $value;
        $this->isArray = $isArray;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getShort(): string
    {
        return $this->short;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getValue(): Value
    {
        return $this->value;
    }

    public function isArray(): bool
    {
        return $this->isArray;
    }
}
