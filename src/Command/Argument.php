<?php declare(strict_types=1);

namespace Qlimix\Cli\Command;

final class Argument
{
    private string $name;

    private string $description;

    private bool $required;

    private bool $isArray;

    public function __construct(string $name, string $description, bool $required, bool $isArray)
    {
        $this->name = $name;
        $this->description = $description;
        $this->required = $required;
        $this->isArray = $isArray;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function isRequired(): bool
    {
        return $this->required;
    }

    public function isArray(): bool
    {
        return $this->isArray;
    }
}
