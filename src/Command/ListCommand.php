<?php declare(strict_types=1);

namespace Qlimix\Cli\Command;

use Qlimix\Cli\Command\Exception\ExecutionException;
use Qlimix\Cli\Command\Input\InputInterface;
use Qlimix\Cli\Command\Registry\RegistryInterface;
use Qlimix\Cli\Output\OutputInterface;
use Throwable;
use function implode;

final class ListCommand implements CommandInterface
{
    private RegistryInterface $registry;

    private OutputInterface $output;

    public function __construct(RegistryInterface $registry, OutputInterface $output)
    {
        $this->registry = $registry;
        $this->output = $output;
    }

    /**
     * @inheritDoc
     */
    public function execute(InputInterface $input): void
    {
        $output = [];
        $output[] = 'Command list:';
        foreach ($this->registry->getCommands() as $command) {
            $output[] = $command->getName()->toString();
            $output[] = "\t".$command->getDescription();
        }

        try {
            $this->output->writeLine(implode("\n", $output));
        } catch (Throwable $exception) {
            throw new ExecutionException('Failed to output command list', 0, $exception);
        }
    }
}
