<?php declare(strict_types=1);

namespace Qlimix\Tests\Cli\Output\Progress;

use PHPUnit\Framework\TestCase;
use Qlimix\Cli\Output\CursorInterface;
use Qlimix\Cli\Output\OutputInterface;
use Qlimix\Cli\Output\Progress\Decorator\DecoratorInterface;
use Qlimix\Cli\Output\Progress\Factory;

final class FactoryTest extends TestCase
{
    public function testShouldCreateProgress(): void
    {
        $output = $this->createMock(OutputInterface::class);
        $decorator = $this->createMock(DecoratorInterface::class);
        $cursor = $this->createMock(CursorInterface::class);

        $factory = new Factory($output, $decorator, $cursor);
        $factory->create(10);
        $this->addToAssertionCount(1);
    }
}
