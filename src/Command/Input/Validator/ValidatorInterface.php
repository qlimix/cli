<?php declare(strict_types=1);

namespace Qlimix\Cli\Command\Input\Validator;

use Qlimix\Cli\Command\Command;
use Qlimix\Cli\Command\Input\Input;
use Qlimix\Cli\Command\Input\Validator\Exception\ArgumentMissingException;
use Qlimix\Cli\Command\Input\Validator\Exception\OptionValueRequiredException;

interface ValidatorInterface
{
    /**
     * @throws ArgumentMissingException
     * @throws OptionValueRequiredException
     */
    public function validate(Command $command, Input $input): void;
}
