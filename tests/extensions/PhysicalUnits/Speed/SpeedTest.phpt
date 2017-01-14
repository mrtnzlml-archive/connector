<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\PhysicalUnits\Speed;

use Adeira\Connector\PhysicalUnits\Speed\Speed;
use Adeira\Connector\PhysicalUnits\Speed\Units\{
	Kmh, Mph, Ms
};
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
class SpeedTest extends \Adeira\Connector\Tests\TestCase
{

	public function testThatConversionFromKmhWorks()
	{
		$kmh = new Speed(new Kmh(100));
		//Tester\Assert::EPSILON === 1e-10
		Assert::equal(100, $kmh->convertTo(Kmh::class)->value());
		Assert::equal(62.1371192237, $kmh->convertTo(Mph::class)->value());
		Assert::equal(27.7777777777, $kmh->convertTo(Ms::class)->value());
	}

	public function testThatConversionFromMphWorks()
	{
		$mph = new Speed(new Mph(100));
		//Tester\Assert::EPSILON === 1e-10
		Assert::equal(160.9344, $mph->convertTo(Kmh::class)->value());
		Assert::equal(100, $mph->convertTo(Mph::class)->value());
		Assert::equal(44.704, $mph->convertTo(Ms::class)->value());
	}

	public function testThatConversionFromMsWorks()
	{
		$ms = new Speed(new Ms(100));
		//Tester\Assert::EPSILON === 1e-10
		Assert::equal(360.0, $ms->convertTo(Kmh::class)->value());
		Assert::equal(223.6936292054, $ms->convertTo(Mph::class)->value());
		Assert::equal(100, $ms->convertTo(Ms::class)->value());
	}

}

(new SpeedTest)->run();
