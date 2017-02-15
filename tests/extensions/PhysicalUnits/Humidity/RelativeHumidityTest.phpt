<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\PhysicalUnits\Humidity;

use Adeira\Connector\PhysicalUnits\Humidity\RelativeHumidity;
use Adeira\Connector\PhysicalUnits\Humidity\Units\Percentage;
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
		Assert::equal(42, $relative->convertTo(Percentage::class)->value());
	}

}

(new RelativeHumidityTest)->run();
