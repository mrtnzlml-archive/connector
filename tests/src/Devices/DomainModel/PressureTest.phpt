<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Devices\DomainModel;

use Adeira\Connector\Devices\DomainModel\Pressure;
use Adeira\Connector\PhysicalUnits\Pressure\Units\{
	Bar, Pascal, Torr
};
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class PressureTest extends \Adeira\Connector\Tests\TestCase
{

	public function testAbsolutePressure()
	{
		$p = new Pressure(new Pascal(100), new Torr(0));
		Assert::same(100.0, $p->absolute());
		Assert::same(0.0, $p->relative());
	}

	public function testRelativePressure()
	{
		$p = new Pressure(new Bar(0), new Pascal(200));
		Assert::same(0.0, $p->absolute());
		Assert::same(200.0, $p->relative());
	}

	public function testBothPressures()
	{
		$p = new Pressure(new Bar(100), new Torr(100));
		Assert::same(10000000.0, $p->absolute());
		Assert::equal(13332.2368421050, $p->relative()); // Tester\Assert::EPSILON = 1e-10
	}

}

(new PressureTest)->run();
