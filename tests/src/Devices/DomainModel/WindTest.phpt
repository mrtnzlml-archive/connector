<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Devices\DomainModel;

use Adeira\Connector\Devices\DomainModel\Wind;
use Adeira\Connector\PhysicalUnits\Speed\Units\Kmh;
use Adeira\Connector\PhysicalUnits\Speed\Units\Ms;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class WindTest extends \Adeira\Connector\Tests\TestCase
{

	public function testSpeed()
	{
		$p = new Wind(new Ms(100), 0, new Kmh(0));
		Assert::same(360.0, $p->speed());
	}

	public function testDirection()
	{
		$p = new Wind(new Kmh(0), 180, new Kmh(0));
		Assert::same(180.0, $p->directionAzimuth());
	}

	public function testGust()
	{
		$p = new Wind(new Kmh(0), 180, new Ms(100));
		Assert::same(360.0, $p->gust());
	}

}

(new WindTest)->run();
