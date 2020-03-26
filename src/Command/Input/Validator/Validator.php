<?php declare(strict_types=1);

namespace Qlimix\Cli\Command\Input\Validator;

use Qlimix\Cli\Command\Command;
use Qlimix\Cli\Command\Input\Input;
use Qlimix\Cli\Command\Input\Validator\Exception\ArgumentMissingException;
use Qlimix\Cli\Command\Input\Validator\Exception\OptionValueRequiredException;

final class Validator implements ValidatorInterface
{
    /**
     * @inheritDoc
     */
    public function validate(Command $command, Input $input): void
    {
        foreach ($command->getArguments() as $argument) {
            if ($argument->isRequired() && !$input->hasArgument($argument)) {
                throw new ArgumentMissingException('Missing '.$argument->getName());
            }
        }

        foreach ($command->getOptions() as $option) {
            if ($option->getValue()->isRequired() && !$input->hasOptionWithValue($option)) {
                throw new OptionValueRequiredException('Missing value for '.$option->getName());
            }
        }
    }
}
