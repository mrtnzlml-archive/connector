<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Devices\DomainModel;

use Adeira\Connector\Devices\DomainModel\{
	Humidity, PhysicalQuantities, Pressure, Temperature, Wind
};
use Adeira\Connector\PhysicalUnits\DomainModel\Humidity\Units\Percentage;
use Adeira\Connector\PhysicalUnits\DomainModel\Pressure\Units\Pascal;
use Adeira\Connector\PhysicalUnits\DomainModel\Speed\Units\Kmh;
use Adeira\Connector\PhysicalUnits\DomainModel\Temperature\Units\Celsius;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class PhysicalQuantitiesTest extends \Adeira\Connector\Tests\TestCase
{

	public function testBasicFunctionality()
	{
		$pq = new PhysicalQuantities(
			new Pressure(new Pascal(100), new Pascal(100)),
			new Temperature(new Celsius(200), new Celsius(200)),
			new Humidity(new Percentage(300), new Percentage(300)),
			new Wind(new Kmh(400), 400, new Kmh(400))
		);

		Assert::type(Pressure::class, $pq->pressure());
		Assert::type(Temperature::class, $pq->temperature());
		Assert::type(Humidity::class, $pq->humidity());
		Assert::type(Wind::class, $pq->wind());
	}

}

(new PhysicalQuantitiesTest)->run();
