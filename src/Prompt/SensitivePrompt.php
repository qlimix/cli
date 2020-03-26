<?php declare(strict_types=1);

namespace Qlimix\Cli\Prompt;

use Qlimix\Cli\Input\Hidden\HiddenInterface;
use Qlimix\Cli\Input\InputInterface;
use Qlimix\Cli\Output\OutputInterface;
use Qlimix\Cli\Prompt\Decorator\DecoratorInterface;
use Qlimix\Cli\Prompt\Exception\PromptException;
use Throwable;

final class SensitivePrompt implements PromptInterface
{
    private DecoratorInterface $decorator;

    private InputInterface $input;

    private OutputInterface $output;

    private HiddenInterface $hide;

    public function __construct(
        DecoratorInterface $decorator,
        InputInterface $input,
        OutputInterface $output,
        HiddenInterface $hide
    ) {
        $this->decorator = $decorator;
        $this->input = $input;
        $this->output = $output;
        $this->hide = $hide;
    }

    public function prompt(string $text): string
    {
        try {
            $this->output->writeLine($this->decorator->decorate($text));
            $this->hide->hide();
            $response = $this->input->read(1024);
            $this->hide->show();
        } catch (Throwable $exception) {
            throw new PromptException('Failed to prompt sensitive', 0, $exception);
        }

        return $response;
    }
}
