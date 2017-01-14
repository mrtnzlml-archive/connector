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
		$kmh = new Speed(100, new Kmh);
		//Tester\Assert::EPSILON === 1e-10
		Assert::equal(100, $kmh->convert(new Kmh)->getValue());
		Assert::equal(62.1371192237, $kmh->convert(new Mph)->getValue());
		Assert::equal(27.7777777777, $kmh->convert(new Ms)->getValue());
	}

	public function testThatConversionFromMphWorks()
	{
		$mph = new Speed(100, new Mph);
		//Tester\Assert::EPSILON === 1e-10
		Assert::equal(160.9344, $mph->convert(new Kmh)->getValue());
		Assert::equal(100, $mph->convert(new Mph)->getValue());
		Assert::equal(44.704, $mph->convert(new Ms)->getValue());
	}

	public function testThatConversionFromMsWorks()
	{
		$ms = new Speed(100, new Ms);
		//Tester\Assert::EPSILON === 1e-10
		Assert::equal(360.0, $ms->convert(new Kmh)->getValue());
		Assert::equal(223.6936292054, $ms->convert(new Mph)->getValue());
		Assert::equal(100, $ms->convert(new Ms)->getValue());
	}

}

(new SpeedTest)->run();
