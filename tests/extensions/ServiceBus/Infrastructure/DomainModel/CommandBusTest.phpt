<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\ServiceBus\Infrastructure\DomainModel;

use Adeira\Connector\ServiceBus\Infrastructure\DomainModel\CommandBus;
use Tester\Assert;

require getenv('BOOTSTRAP');
require __DIR__ . '/Command1.php';

/**
 * @testCase
 */
final class CommandBusTest extends \Adeira\Connector\Tests\TestCase
{

	public function testThatDispatchWorks()
	{
		$com_1 = FALSE;

		$bus = new CommandBus([
			Command1::class => function () use (&$com_1) {
				$com_1 = TRUE;
			},
		]);

		$bus->dispatch(new Command1);
		Assert::true($com_1, Command1::class);
	}

	public function testThatCommandWithoutHandlerThrowsException()
	{
		$bus = new CommandBus([]);
		Assert::throws(
			function () use ($bus) {
				$bus->dispatch(new Command1);
			},
			\Adeira\Connector\ServiceBus\DomainModel\Exception\UnknownCommandHandler::class,
			'Cannot dispatch command \'' . Command1::class . '\' because there is not related handler in dispatch map.'
		);
	}

}

(new CommandBusTest)->run();
