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

}

(new CommandBusTest)->run();
