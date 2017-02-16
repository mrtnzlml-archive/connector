<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Devices\DomainModel;

use Adeira\Connector\Devices\DomainModel\Temperature;
use Adeira\Connector\PhysicalUnits\DomainModel\Temperature\Units\{
	Celsius, Kelvin
};
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class TemperatureTest extends \Adeira\Connector\Tests\TestCase
{

	public function testIndoorTemperature()
	{
		$p = new Temperature(new Celsius(100), new Kelvin(0));
		Assert::same(100.0, $p->indoor());
		Assert::equal(-273.15, $p->outdoor()); // Tester\Assert::EPSILON = 1e-10
	}

	public function testOutdoorTemperature()
	{
		$p = new Temperature(new Kelvin(0), new Celsius(200));
		Assert::equal(-273.15, $p->indoor()); // Tester\Assert::EPSILON = 1e-10
		Assert::same(200.0, $p->outdoor());
	}

	public function testBothTemperatures()
	{
		$p = new Temperature(new Kelvin(100), new Kelvin(100));
		Assert::equal(-173.15, $p->indoor()); // Tester\Assert::EPSILON = 1e-10
		Assert::equal(-173.15, $p->outdoor()); // Tester\Assert::EPSILON = 1e-10
	}

	public function testNullability()
	{
		$p = new Temperature(NULL, NULL);
		Assert::null($p->indoor());
		Assert::null($p->outdoor());
	}

}

(new TemperatureTest)->run();
