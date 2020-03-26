<?php declare(strict_types=1);

namespace Qlimix\Cli\Command;

final class Value
{
    private bool $has;

    private bool $required;

    private ?string $default;

    public function __construct(bool $has, bool $required, ?string $default)
    {
        $this->has = $has;
        $this->required = $required;
        $this->default = $default;
    }

    public function has(): bool
    {
        return $this->has;
    }

    public function isRequired(): bool
    {
        return $this->has && $this->required;
    }

    public function getDefault(): ?string
    {
        return $this->default;
    }
}
