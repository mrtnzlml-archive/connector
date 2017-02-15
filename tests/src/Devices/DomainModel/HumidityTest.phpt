<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Devices\DomainModel;

use Adeira\Connector\Devices\DomainModel\Humidity;
use Adeira\Connector\PhysicalUnits\Humidity\Units\Percentage;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class HumidityTest extends \Adeira\Connector\Tests\TestCase
{

	public function testIndoorHumidity()
	{
		$p = new Humidity(new Percentage(51), new Percentage(0));
		Assert::same(51.0, $p->indoor());
		Assert::same(0.0, $p->outdoor());
	}

	public function testOutdoorHumidity()
	{
		$p = new Humidity(new Percentage(0), new Percentage(12));
		Assert::same(0.0, $p->indoor());
		Assert::same(12.0, $p->outdoor());
	}

	public function testBothHumidity()
	{
		$p = new Humidity(new Percentage(100), new Percentage(33));
		Assert::same(100.0, $p->indoor());
		Assert::same(33.0, $p->outdoor());
	}

}

(new HumidityTest)->run();
