<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\PhysicalUnits\DomainModel\Humidity;

use Adeira\Connector\PhysicalUnits\DomainModel\Humidity\RelativeHumidity;
use Adeira\Connector\PhysicalUnits\DomainModel\Humidity\Units\Percentage;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class RelativeHumidityTest extends \Adeira\Connector\Tests\TestCase
{

	public function testThatConversionFromPercentageWorks()
	{
		$relative = new RelativeHumidity(new Percentage(42));
		//Tester\Assert::EPSILON === 1e-10
		Assert::equal(42.0, $relative->convertTo(Percentage::class)->value());
	}

	public function testThatItAlwaysReturnsFloat()
	{
		Assert::same(1.0, (new RelativeHumidity(new Percentage('1')))->value());
	}

}

(new RelativeHumidityTest)->run();
