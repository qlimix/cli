<?php declare(strict_types=1);

namespace Qlimix\Cli\Command;

final class Command
{
    private Name $name;

    private string $description;

    private CommandInterface $command;

    /** @var Argument[] */
    private array $arguments;

    /** @var Option[] */
    private array $options;

    /**
     * @param Argument[] $arguments
     * @param Option[] $options
     */
    public function __construct(
        Name $name,
        string $description,
        CommandInterface $command,
        array $arguments,
        array $options
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->command = $command;
        $this->arguments = $arguments;
        $this->options = $options;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCommand(): CommandInterface
    {
        return $this->command;
    }

    /**
     * @return Argument[]
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * @return Option[]
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    public function equals(self $command): bool
    {
        return $command->getName() === $this->name;
    }
}
