<?php declare(strict_types=1);

namespace Qlimix\Cli\Prompt;

use Qlimix\Cli\Input\InputInterface;
use Qlimix\Cli\Output\OutputInterface;
use Qlimix\Cli\Prompt\Decorator\DecoratorInterface;
use Qlimix\Cli\Prompt\Exception\ConfirmException;
use Throwable;
use function in_array;

final class Confirm implements ConfirmInterface
{
    private DecoratorInterface $decorator;

    private InputInterface $input;

    private OutputInterface $output;

    public function __construct(DecoratorInterface $decorator, InputInterface $input, OutputInterface $output)
    {
        $this->decorator = $decorator;
        $this->input = $input;
        $this->output = $output;
    }

    /**
     * @inheritDoc
     */
    public function confirm(string $text, array $options): bool
    {
        try {
            $this->output->writeLine($this->decorator->decorate($text));
            $response = $this->input->read(1024);
        } catch (Throwable $exception) {
            throw new ConfirmException('Failed to confirm', 0, $exception);
        }

        return in_array($response, $options, true);
    }
}
