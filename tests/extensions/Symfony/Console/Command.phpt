<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Devices\DomainModel\WeatherStation;

use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
class Command extends \Adeira\Connector\Tests\TestCase
{

	public function testThatCommandIsSymfonyType()
	{
		Assert::type(\Symfony\Component\Console\Command\Command::class, new \Adeira\Connector\Symfony\Console\Command('name'));
	}

	public function testThatCommandDoesHavePrefixedName()
	{
		$command = new \Adeira\Connector\Symfony\Console\Command('command:name');
		Assert::same('adeira:command:name', $command->getName());
	}

	public function testThatExceptionIsThrownIfNamespaceIsToLong()
	{
		Assert::exception(function () {
			new \Adeira\Connector\Symfony\Console\Command('1:2:3');
		}, \InvalidArgumentException::class, 'It\'s allowed to use only one level namespace in command name. "adeira:" prefix is added automatically.');
	}

}

(new Command)->run();
