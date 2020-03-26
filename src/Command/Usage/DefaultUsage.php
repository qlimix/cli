<?php declare(strict_types=1);

namespace Qlimix\Cli\Command\Usage;

use Qlimix\Cli\Command\Argument;
use Qlimix\Cli\Command\Command;
use Qlimix\Cli\Command\Option;
use function array_merge;
use function implode;

final class DefaultUsage implements UsageInterface
{
    public function usage(Command $command): string
    {
        $output = [];
        $output[] = 'Usage: '.$command->getName()->toString();
        $output[] = $command->getDescription();
        $output[] = '';
        $output = array_merge($output, $this->formatArguments($command->getArguments()));
        $output[] = '';
        $output = array_merge($output, $this->formatOptions($command->getOptions()));

        return implode("\n", $output);
    }

    /**
     * @param Argument[] $arguments
     *
     * @return string[]
     */
    private function formatArguments(array $arguments): array
    {
        $output = [];
        $output[] = 'Arguments:';
        foreach ($arguments as $argument) {
            $isArray = $argument->isArray() ? '...' : '';
            $output[] = "\t".$argument->getName().$isArray.' - '.$argument->getDescription();
        }

        return $output;
    }

    /**
     * @param Option[] $options
     *
     * @return string[]
     */
    private function formatOptions(array $options): array
    {
        $output = [];
        $output[] = 'Options:';
        foreach ($options as $option) {
            $default = $option->getValue()->has() && $option->getValue()->getDefault() !== null
                ? ' [default: '.$option->getValue()->getDefault().']' : '';
            $isArray = $option->isArray() ? '...' : '';
            $output[] = "\t--".$option->getName().' -'.$option->getShort().$default.$isArray;
            $output[] = "\t\t".$option->getDescription();
        }

        return $output;
    }
}
