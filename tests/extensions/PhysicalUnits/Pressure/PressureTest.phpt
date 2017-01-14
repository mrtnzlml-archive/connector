<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\PhysicalUnits\Pressure;

use Adeira\Connector\PhysicalUnits\Pressure\Pressure;
use Adeira\Connector\PhysicalUnits\Pressure\Units\{
	Atm, Bar, Pascal, Torr
};
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
class PressureTest extends \Adeira\Connector\Tests\TestCase
{

	public function testThatPressureAdditionIsImmutable()
	{
		$p1 = $p2 = new Pressure(2500, new Pascal);
		$p1 = $p1->add(new Pressure(500, new Pascal));
		Assert::same(3000, $p1->getPressureValue());
		Assert::same(2500, $p2->getPressureValue());
	}

	public function testThatAdditionWithWrongUnitsThrowsException()
	{
		$pressure = new Pressure(2500, new Pascal);
		Assert::exception(function () use ($pressure) {
			$pressure->add(new Pressure(500, new Bar));
		}, \InvalidArgumentException::class, 'Pressure units must be identical.');
	}

	public function testThatPressureSubstractionIsImmutable()
	{
		$p1 = $p2 = new Pressure(2500, new Pascal);
		$p1 = $p1->substract(new Pressure(500, new Pascal));
		Assert::same(2000, $p1->getPressureValue());
		Assert::same(2500, $p2->getPressureValue());
	}

	public function testThatSubstractionWithWrongUnitsThrowsException()
	{
		$pressure = new Pressure(2500, new Pascal);
		Assert::exception(function () use ($pressure) {
			$pressure->substract(new Pressure(500, new Bar));
		}, \InvalidArgumentException::class, 'Pressure units must be identical.');
	}

	public function testThatConversionFromAtmWorks()
	{
		$atm = new Pressure(1000, new Atm);
		//Tester\Assert::EPSILON === 1e-10
		Assert::equal(1000, $atm->convert(new Atm)->getPressureValue());
		Assert::equal(1013.25, $atm->convert(new Bar)->getPressureValue());
		Assert::equal(101325000, $atm->convert(new Pascal)->getPressureValue());
		Assert::equal(760000, $atm->convert(new Torr)->getPressureValue());
	}

	public function testThatConversionFromBarWorks()
	{
		$bar = new Pressure(1000, new Bar);
		//Tester\Assert::EPSILON === 1e-10
		Assert::equal(986.9232667160, $bar->convert(new Atm)->getPressureValue());
		Assert::equal(1000, $bar->convert(new Bar)->getPressureValue());
		Assert::equal(100000000.0, $bar->convert(new Pascal)->getPressureValue());
		Assert::equal(750061.682704, $bar->convert(new Torr)->getPressureValue());
	}

	public function testThatConversionFromPascalWorks()
	{
		$pascal = new Pressure(1000, new Pascal);
		//Tester\Assert::EPSILON === 1e-10
		Assert::equal(0.0098692327, $pascal->convert(new Atm)->getPressureValue());
		Assert::equal(0.01, $pascal->convert(new Bar)->getPressureValue());
		Assert::equal(1000, $pascal->convert(new Pascal)->getPressureValue());
		Assert::equal(7.5006168270, $pascal->convert(new Torr)->getPressureValue());
	}

	public function testThatConversionFromTorrWorks()
	{
		$torr = new Pressure(1000, new Torr);
		//Tester\Assert::EPSILON === 1e-10
		Assert::equal(1.3157894737, $torr->convert(new Atm)->getPressureValue());
		Assert::equal(1.3332236842, $torr->convert(new Bar)->getPressureValue());
		Assert::equal(133322.368421, $torr->convert(new Pascal)->getPressureValue());
		Assert::equal(1000, $torr->convert(new Torr)->getPressureValue());
	}

}

(new PressureTest)->run();
